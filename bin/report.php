<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/OrderStream.php';
require_once __DIR__ . '/../src/Report.php';

use App\OrderStream;
use App\Report;

$csvPath = $argv[1] ?? __DIR__ . '/../data/orders.csv';

try {
    $orders = OrderStream::fromCsv($csvPath);
    $paidOrders = Report::paidOrders($orders);
    $report = Report::revenueByCategory($paidOrders);
} catch (Throwable $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}

echo 'Revenue by category' . PHP_EOL;
echo str_repeat('-', 42) . PHP_EOL;
printf("% % %\n", 'Category', 'Orders', 'Revenue');
echo str_repeat('-', 42) . PHP_EOL;

foreach ($report as $category => $row) {
    printf(
        "% % %\n",
        $category,
        $row['orders'],
        $row['revenue']
    );
}
