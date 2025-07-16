<?php

namespace App\Models;

class ShipmentOrder {
    private $db;
    
    public function __construct() {
        $this->db = \Database::getInstance()->getConnection();
    }
    
    public function create($data) {
        $sql = "INSERT INTO shipment_orders (
            pickup_address, delivery_address, ready_time, cargo_type, weight, 
            dimensions, contact_person, phone, recipient_contact, recipient_phone, 
            comment, pickup_city, destination_city, delivery_method, 
            desired_arrival_date, order_type, status, created_at, updated_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW()) RETURNING *";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['pickup_address'],
            $data['delivery_address'],
            $data['ready_time'],
            $data['cargo_type'],
            $data['weight'],
            $data['dimensions'],
            $data['contact_person'],
            $data['phone'],
            $data['recipient_contact'],
            $data['recipient_phone'],
            $data['comment'] ?? null,
            $data['pickup_city'] ?? null,
            $data['destination_city'] ?? null,
            $data['delivery_method'] ?? null,
            $data['desired_arrival_date'] ?? null,
            $data['order_type'],
            $data['status'] ?? 'processing'
        ]);
        
        $order = $stmt->fetch();
        
        // Отправляем Telegram уведомление
        if ($order) {
            $telegram = new \App\TelegramService();
            $telegram->sendNewOrderNotification($order);
        }
        
        return $order;
    }
    
    public function getAll($filters = []) {
        $sql = "SELECT * FROM shipment_orders WHERE 1=1";
        $params = [];
        
        if (!empty($filters['date_from'])) {
            $sql .= " AND created_at >= ?";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND created_at <= ?";
            $params[] = $filters['date_to'];
        }
        
        if (!empty($filters['order_type'])) {
            $sql .= " AND order_type = ?";
            $params[] = $filters['order_type'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function updateStatus($id, $status) {
        // Получаем текущий заказ для отправки уведомления
        $currentOrder = $this->getById($id);
        $oldStatus = $currentOrder ? $currentOrder['status'] : null;
        
        $stmt = $this->db->prepare("UPDATE shipment_orders SET status = ?, updated_at = NOW() WHERE id = ? RETURNING *");
        $stmt->execute([$status, $id]);
        $updatedOrder = $stmt->fetch();
        
        // Отправляем Telegram уведомление о смене статуса
        if ($updatedOrder && $oldStatus && $oldStatus !== $status) {
            $telegram = new \App\TelegramService();
            $telegram->sendStatusUpdateNotification($updatedOrder, $oldStatus);
        }
        
        return $updatedOrder;
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM shipment_orders WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}