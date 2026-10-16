<?php

namespace App\Services;

class CsvExporter
{
    /**
     * 从二维数组生成 CSV 并返回响应
     */
    public static function download(array $headers, array $rows, string $filename)
    {
        $filename = $filename . '-' . date('YmdHis') . '.csv';

        $callback = function () use ($headers, $rows) {
            $fp = fopen('php://output', 'w');
            // BOM，Excel 打开不乱码
            fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($fp, $headers);
            foreach ($rows as $row) {
                fputcsv($fp, $row);
            }
            fclose($fp);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
