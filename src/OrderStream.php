<?php

declare(strict_types=1);

namespace App;

use Generator;
use RuntimeException;

final class OrderStream
{
    /**
     * @return Generator<int, array{
     *     id: int,
     *     date: string,
     *     customer: string,
     *     category: string,
     *     amount: float,
     *     status: string
     * }>
     */
    public static function fromCsv(string $path): Generator
    {
        $handle = fopen($path, 'rb');

        if ($handle === false) {
            throw new RuntimeException("Cannot open CSV file: {$path}");
        }

        try {
            $header = fgetcsv($handle);

            if ($header === false) {
                return;
            }

            while (($row = fgetcsv($handle)) !== false) {
                $order = array_combine($header, $row);

                if ($order === false) {
                    continue;
                }

                yield (int) $order['id'] => [
                    'id' => (int) $order['id'],
                    'date' => $order['date'],
                    'customer' => $order['customer'],
                    'category' => $order['category'],
                    'amount' => (float) $order['amount'],
                    'status' => $order['status'],
                ];
            }
        } finally {
            fclose($handle);
        }
    }
}
