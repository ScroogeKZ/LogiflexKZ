<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\ShipmentOrder;
use App\Auth;

Auth::requireAuth();

$orderModel = new ShipmentOrder();
$telegramService = new App\TelegramService();
$filters = [];

// Handle filters
if (isset($_GET['date_from'])) $filters['date_from'] = $_GET['date_from'];
if (isset($_GET['date_to'])) $filters['date_to'] = $_GET['date_to'];
if (isset($_GET['order_type'])) $filters['order_type'] = $_GET['order_type'];
if (isset($_GET['status'])) $filters['status'] = $_GET['status'];

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $orderId = (int)$_POST['order_id'];
    $newStatus = $_POST['status'];
    
    try {
        $orderModel->updateStatus($orderId, $newStatus);
        $success = 'Статус заказа обновлен';
    } catch (Exception $e) {
        $error = 'Ошибка обновления: ' . $e->getMessage();
    }
}

$orders = $orderModel->getAll($filters);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления - Хром-KZ Логистика</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <img src="/assets/logo.png" alt="Хром-KZ" class="h-10 w-10" onerror="this.style.display='none'">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Хром-KZ</h1>
                        <p class="text-sm text-gray-600">Панель управления</p>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <a href="/" class="text-gray-600 hover:text-blue-600">Главная</a>
                    <a href="/admin/logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Выйти</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Управление заказами</h1>
        
        <?php if (isset($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <!-- Filters -->
        <!-- Telegram Status -->
        <div class="bg-white p-4 rounded-lg shadow-lg mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Статус Telegram уведомлений</h3>
                    <p class="text-sm text-gray-600">
                        <?php if ($telegramService->isConfigured()): ?>
                            <span class="text-green-600">✓ Telegram настроен и работает</span>
                        <?php else: ?>
                            <span class="text-red-600">✗ Telegram не настроен</span>
                        <?php endif; ?>
                    </p>
                </div>
                <?php if (!$telegramService->isConfigured()): ?>
                    <div class="text-sm text-gray-500">
                        <p>Для настройки уведомлений нужны:</p>
                        <p>• TELEGRAM_BOT_TOKEN</p>
                        <p>• TELEGRAM_CHAT_ID</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-xl font-bold mb-4">Фильтры</h2>
            <form method="GET" class="grid md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">От даты</label>
                    <input type="date" name="date_from" value="<?php echo htmlspecialchars($_GET['date_from'] ?? ''); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">До даты</label>
                    <input type="date" name="date_to" value="<?php echo htmlspecialchars($_GET['date_to'] ?? ''); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Тип заказа</label>
                    <select name="order_type" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Все</option>
                        <option value="astana" <?php echo ($_GET['order_type'] ?? '') === 'astana' ? 'selected' : ''; ?>>Астана</option>
                        <option value="regional" <?php echo ($_GET['order_type'] ?? '') === 'regional' ? 'selected' : ''; ?>>Региональные</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Статус</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Все</option>
                        <option value="processing" <?php echo ($_GET['status'] ?? '') === 'processing' ? 'selected' : ''; ?>>В обработке</option>
                        <option value="completed" <?php echo ($_GET['status'] ?? '') === 'completed' ? 'selected' : ''; ?>>Завершен</option>
                    </select>
                </div>
                
                <div class="md:col-span-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Применить фильтры
                    </button>
                    <a href="/admin/panel.php" class="ml-2 bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                        Сбросить
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-xl font-bold">Заказы (<?php echo count($orders); ?>)</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Тип</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Маршрут</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Груз</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Контакт</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #<?php echo $order['id']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo $order['order_type'] === 'astana' ? 'Астана' : 'Региональный'; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php if ($order['order_type'] === 'regional'): ?>
                                        <?php echo htmlspecialchars($order['pickup_city'] . ' → ' . $order['destination_city']); ?>
                                    <?php else: ?>
                                        Астана
                                    <?php endif; ?>
                                    <br>
                                    <small class="text-gray-400">
                                        <?php echo htmlspecialchars(substr($order['pickup_address'], 0, 30)); ?>...
                                    </small>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php echo htmlspecialchars($order['cargo_type']); ?>
                                    <br>
                                    <small class="text-gray-400"><?php echo $order['weight']; ?> кг</small>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php echo htmlspecialchars($order['contact_person']); ?>
                                    <br>
                                    <small class="text-gray-400"><?php echo htmlspecialchars($order['phone']); ?></small>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php echo $order['status'] === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                        <?php echo $order['status'] === 'completed' ? 'Завершен' : 'В обработке'; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo date('d.m.Y H:i', strtotime($order['created_at'])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                        <select name="status" onchange="this.form.submit()" 
                                                class="text-xs border border-gray-300 rounded px-2 py-1">
                                            <option value="processing" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>В обработке</option>
                                            <option value="completed" <?php echo $order['status'] === 'completed' ? 'selected' : ''; ?>>Завершен</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    Заказы не найдены
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>