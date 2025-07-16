<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Auth;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Хром-KZ Логистика - Грузоперевозки по Казахстану</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
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
                    <a href="/astana.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Заказать доставку</a>
                    <a href="/admin/login.php" class="text-gray-600 hover:text-blue-600">Вход в систему</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg text-white py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Надёжные грузоперевозки по Казахстану
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                Быстрая и безопасная доставка грузов по Астане и всему Казахстану. 
                Профессиональный сервис с полным контролем качества.
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="/astana.php" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Доставка по Астане
                </a>
                <a href="/regional.php" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                    Межгородские перевозки
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Наши услуги</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="text-blue-600 text-4xl mb-4">🚚</div>
                    <h3 class="text-xl font-bold mb-4">Доставка по Астане</h3>
                    <p class="text-gray-600 mb-6">
                        Быстрая доставка грузов в пределах города. 
                        Забор груза в удобное для вас время и доставка в кратчайшие сроки.
                    </p>
                    <a href="/astana.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Оформить заказ
                    </a>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="text-green-600 text-4xl mb-4">🌍</div>
                    <h3 class="text-xl font-bold mb-4">Межгородские перевозки</h3>
                    <p class="text-gray-600 mb-6">
                        Доставка грузов по всему Казахстану. 
                        Различные способы доставки и контроль на всех этапах транспортировки.
                    </p>
                    <a href="/regional.php" class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        Оформить заказ
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Почему выбирают нас</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-blue-600 text-5xl mb-4">⚡</div>
                    <h3 class="text-xl font-bold mb-2">Быстрая доставка</h3>
                    <p class="text-gray-600">Оперативная обработка заказов и доставка в срок</p>
                </div>
                
                <div class="text-center">
                    <div class="text-blue-600 text-5xl mb-4">🛡️</div>
                    <h3 class="text-xl font-bold mb-2">Безопасность</h3>
                    <p class="text-gray-600">Полная ответственность за сохранность груза</p>
                </div>
                
                <div class="text-center">
                    <div class="text-blue-600 text-5xl mb-4">📱</div>
                    <h3 class="text-xl font-bold mb-2">Контроль</h3>
                    <p class="text-gray-600">Отслеживание статуса доставки в реальном времени</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex items-center justify-center space-x-3 mb-4">
                <img src="/assets/logo.png" alt="Хром-KZ" class="h-8 w-8" onerror="this.style.display='none'">
                <span class="text-xl font-bold">Хром-KZ Логистика</span>
            </div>
            <p class="text-gray-400">
                Надёжный партнёр в сфере грузоперевозок по Казахстану
            </p>
        </div>
    </footer>
</body>
</html>