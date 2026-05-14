<?php

declare(strict_types=1);

namespace App;

use Generator;
use Traversable;

final class Report
{
    /**
     * @param Traversable<int, array{id: int, category: string, amount: float, status: string}> $orders
     * @return Generator<int, array{id: int, category: string, amount: float, status: string}>
     */
    public static function paidOrders(Traversable $orders): Generator
    {
        foreach ($orders as $id => $order) {
            if ($order['status'] !== 'paid') {
                continue;
            }

            yield $id => $order;
        }
    }

    /**
     * @param Traversable<int, array{category: string, amount: float}> $orders
     * @return array<string, array{orders: int, revenue: float}>
     */
    public static function revenueByCategory(Traversable $orders): array
    {
        $report = [];

        foreach ($orders as $order) {
            $category = $order['category'];

            if (!isset($report[$category])) {
                $report[$category] = [
                    'orders' => 0,
                    'revenue' => 0.0,
                ];
            }

            $report[$category]['orders']++;
            $report[$category]['revenue'] += $order['amount'];
        }

        ksort($report);

        return $report;
    }
}
