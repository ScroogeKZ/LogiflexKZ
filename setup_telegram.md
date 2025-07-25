# Настройка Telegram уведомлений для Хром-KZ

## Пошаговая инструкция

### 1. Создание Telegram бота

1. Откройте Telegram и найдите бота [@BotFather](https://t.me/BotFather)
2. Отправьте команду `/newbot`
3. Введите название бота, например: `Хром-KZ Логистика`
4. Введите username бота, например: `khrom_kz_logistics_bot`
5. Скопируйте полученный токен (выглядит как: `123456789:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw`)

### 2. Получение Chat ID

**Вариант 1: Личные сообщения**
1. Напишите боту любое сообщение
2. Откройте в браузере: `https://api.telegram.org/bot<ВАШ_ТОКЕН>/getUpdates`
3. Найдите `"chat":{"id":123456789` - это ваш chat_id

**Вариант 2: Группа**
1. Добавьте бота в группу
2. Отправьте сообщение в группу
3. Откройте: `https://api.telegram.org/bot<ВАШ_ТОКЕН>/getUpdates`
4. Найдите chat_id группы (обычно отрицательное число)

### 3. Настройка в Replit

Добавьте секреты в проект:

```bash
TELEGRAM_BOT_TOKEN=123456789:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw
TELEGRAM_CHAT_ID=123456789
```

### 4. Проверка работы

После настройки:
- Зайдите в админ-панель
- Статус Telegram должен показать "✓ Telegram настроен и работает"
- Создайте тестовый заказ для проверки уведомлений

## Что будет приходить в Telegram

### При создании нового заказа:
```
🚚 Новая заявка #123

Тип: Астана
Клиент: Иван Иванов
Телефон: +77001234567
Груз: документы (2 кг)
Забор: ул. Абая 123
Доставка: пр. Назарбаева 456
Время готовности: 14:00
Получатель: Петр Петров (+77007654321)
Комментарий: Срочная доставка

Дата создания: 16.07.2025 14:30
```

### При изменении статуса:
```
📋 Обновление статуса заявки #123

Клиент: Иван Иванов
Статус изменен: 🔄 В обработке → ✅ Выполнена
Дата изменения: 16.07.2025 16:45
```

## Безопасность

- Никогда не публикуйте токен бота в открытых репозиториях
- Используйте только переменные окружения
- Регулярно обновляйте токены при необходимости