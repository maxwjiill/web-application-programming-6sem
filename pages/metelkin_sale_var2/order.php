<?php
function getBasePrice($type, $file) {
    $prices = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($prices as $line) {
        list($key, $price) = explode(':', $line);
        if ($key == $type) {
            return (float)trim($price);
        }
    }
    return 0;
}

function calculateTotal($data) {
    $basePrice = getBasePrice($data['product_type'], 'txt/base_price.txt');
    $doughPrice = getBasePrice($data['dough_type'], 'txt/base_price.txt');
    $creamPrice = getBasePrice('cream', 'txt/base_price.txt');
    $deliveryCost = 100;

    if ($data['delivery_time'] == '15:00-19:00') {
        $deliveryCost *= 1.2;
    } elseif ($data['delivery_time'] == '19:00-23:00') {
        $deliveryCost *= 2;
    }

    $additionalServicesCost = 0;
    $additionalServices = [];
    if (isset($data['additional_services'])) {
        foreach ($data['additional_services'] as $service) {
            $serviceCost = getBasePrice($service, 'txt/additional_services.txt');
            $additionalServicesCost += $serviceCost;
            $additionalServices[$service] = $serviceCost;
        }
    }

    $total = $basePrice + $doughPrice + $creamPrice + $deliveryCost + $additionalServicesCost;

    $data['base_price'] = $basePrice;
    $data['dough_price'] = $doughPrice;
    $data['cream_price'] = $creamPrice;
    $data['delivery_cost'] = $deliveryCost;
    $data['additional_services'] = $additionalServices;
    $data['total_cost'] = $total;

    return $data;
}

$orderData = calculateTotal($_POST);
$orderDataQuery = http_build_query($orderData);

header('Location: bill.php?' . $orderDataQuery);
exit;
?>
