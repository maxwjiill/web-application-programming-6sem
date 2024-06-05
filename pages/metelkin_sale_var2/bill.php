<?php
function getServiceName($key) {
    $services = [
        'product_type' => [
            'cake' => 'Торт',
            'pastry' => 'Пирожные'
        ],
        'dough_type' => [
            'biscuit' => 'Бисквит',
            'meringue' => 'Безе',
            'shortcrust' => 'Песочное'
        ],
        'additional_services' => [
            'marzipan_figures' => 'Фигурки из марципана',
            'glaze' => 'Глазурь'
        ],
        'delivery_time' => [
            '10:00-15:00' => '10:00 - 15:00',
            '15:00-19:00' => '15:00 - 19:00',
            '19:00-23:00' => '19:00 - 23:00'
        ]
    ];

    foreach ($services as $type => $options) {
        if (isset($options[$key])) {
            return $options[$key];
        }
    }

    return $key;
}

$orderData = $_GET;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваш заказ</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <table>
        <tr>
            <th>Параметр</th>
            <th>Значение</th>
            <th>Цена</th>
        </tr>
        <tr>
            <td>Имя</td>
            <td><?php echo htmlspecialchars($orderData['name']); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Адрес</td>
            <td><?php echo htmlspecialchars($orderData['address']); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><?php echo htmlspecialchars($orderData['phone']); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Дата</td>
            <td><?php echo htmlspecialchars($orderData['date']); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Вид изделия</td>
            <td><?php echo htmlspecialchars(getServiceName($orderData['product_type'])); ?></td>
            <td><?php echo '+'. htmlspecialchars($orderData['base_price']) . ' руб.<br>'; ?></td>
        </tr>
        <tr>
            <td>Тип теста</td>
            <td><?php echo htmlspecialchars(getServiceName($orderData['dough_type'])); ?></td>
            <td><?php echo '+'. htmlspecialchars($orderData['dough_price']) . ' руб.<br>'; ?></td>
        </tr>
        <tr>
            <td>Тип крема</td>
            <td>Масляный</td>
            <td><?php echo '+'. htmlspecialchars($orderData['cream_price']) . ' руб.<br>'; ?></td>
        </tr>
        <tr>
            <td>Время доставки</td>
            <td><?php echo htmlspecialchars(getServiceName($orderData['delivery_time'])); ?></td>
            <td><?php echo '+'. htmlspecialchars($orderData['delivery_cost']) . ' руб.<br>'; ?></td>
        </tr>
        <tr>
            <td>Дополнительные услуги</td>
            <td>
                <?php
                if (isset($orderData['additional_services']) && is_array($orderData['additional_services'])) {
                    foreach ($orderData['additional_services'] as $service => $cost) {
                        echo htmlspecialchars(getServiceName($service)) . '<br>';
                    }
                } else {
                    echo 'Нет';
                }
                ?>
            </td>
            <td>
                <?php
                if (isset($orderData['additional_services']) && is_array($orderData['additional_services'])) {
                    foreach ($orderData['additional_services'] as $cost) {
                        echo '+'. htmlspecialchars($cost) . ' руб.<br>';
                    }
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Общая стоимость</td>
            <td colspan="2"><?php echo number_format((float)$orderData['total_cost'], 2, '.', ''); ?> руб.</td>
        </tr>
    </table>
</body>
</html>
