<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\ShipmentOrder;

$success = false;
$error = '';

$cities = [
    'Алматы', 'Шымкент', 'Тараз', 'Караганда', 'Актобе', 'Павлодар', 'Усть-Каменогорск',
    'Семей', 'Атырау', 'Костанай', 'Петропавловск', 'Уральск', 'Кызылорда', 'Актау',
    'Темиртау', 'Туркестан', 'Кокшетау', 'Талдыкорган', 'Экибастуз', 'Рудный'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $order = new ShipmentOrder();
        $data = [
            'pickup_city' => $_POST['pickup_city'] ?? '',
            'pickup_address' => $_POST['pickup_address'] ?? '',
            'destination_city' => $_POST['destination_city'] ?? '',
            'delivery_address' => $_POST['delivery_address'] ?? '',
            'ready_time' => $_POST['ready_time'] ?? '',
            'cargo_type' => $_POST['cargo_type'] ?? '',
            'weight' => (int)($_POST['weight'] ?? 0),
            'dimensions' => $_POST['dimensions'] ?? '',
            'contact_person' => $_POST['contact_person'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'recipient_contact' => $_POST['recipient_contact'] ?? '',
            'recipient_phone' => $_POST['recipient_phone'] ?? '',
            'delivery_method' => $_POST['delivery_method'] ?? '',
            'desired_arrival_date' => $_POST['desired_arrival_date'] ?? '',
            'comment' => $_POST['comment'] ?? '',
            'order_type' => 'regional'
        ];
        
        $result = $order->create($data);
        if ($result) {
            $success = true;
        }
    } catch (Exception $e) {
        $error = 'Ошибка при создании заказа: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Межгородские перевозки - Хром-KZ Логистика</title>
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
                        <p class="text-sm text-gray-600">Логистика</p>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <a href="/" class="text-gray-600 hover:text-blue-600">Главная</a>
                    <a href="/astana.php" class="text-gray-600 hover:text-blue-600">Доставка по Астане</a>
                    <a href="/admin/login.php" class="text-gray-600 hover:text-blue-600">Вход</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-6 text-center">Межгородские перевозки</h1>
            
            <?php if ($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <strong>Успешно!</strong> Ваша заявка принята. Мы свяжемся с вами в ближайшее время.
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <strong>Ошибка:</strong> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Город отправления *</label>
                        <select name="pickup_city" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Выберите город</option>
                            <option value="Астана">Астана</option>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?php echo htmlspecialchars($city); ?>"><?php echo htmlspecialchars($city); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Город назначения *</label>
                        <select name="destination_city" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Выберите город</option>
                            <option value="Астана">Астана</option>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?php echo htmlspecialchars($city); ?>"><?php echo htmlspecialchars($city); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Адрес забора груза *</label>
                        <input type="text" name="pickup_address" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Адрес доставки *</label>
                        <input type="text" name="delivery_address" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Время готовности груза *</label>
                        <input type="text" name="ready_time" required placeholder="например: 14:00"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Желаемая дата прибытия *</label>
                        <input type="date" name="desired_arrival_date" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Тип груза *</label>
                        <select name="cargo_type" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Выберите тип груза</option>
                            <option value="документы">Документы</option>
                            <option value="посылка">Посылка</option>
                            <option value="грузы">Грузы</option>
                            <option value="продукты">Продукты питания</option>
                            <option value="другое">Другое</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Способ доставки *</label>
                        <select name="delivery_method" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Выберите способ</option>
                            <option value="до_двери">Доставка до двери</option>
                            <option value="до_терминала">Доставка до терминала</option>
                            <option value="самовывоз">Самовывоз</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Вес груза (кг) *</label>
                        <input type="number" name="weight" required min="1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Габариты *</label>
                        <input type="text" name="dimensions" required placeholder="например: 30x20x10 см"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Контактное лицо *</label>
                        <input type="text" name="contact_person" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Телефон отправителя *</label>
                        <input type="tel" name="phone" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Контактное лицо получателя *</label>
                        <input type="text" name="recipient_contact" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Телефон получателя *</label>
                        <input type="tel" name="recipient_phone" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Комментарий</label>
                    <textarea name="comment" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                
                <div class="text-center">
                    <button type="submit" 
                            class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        Оформить заказ
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>