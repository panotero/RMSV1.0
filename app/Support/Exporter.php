<?php

namespace App\Support;

use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Response;

/**
 * Shared tabular export helper - takes a flat headers/rows shape and renders
 * it as csv, xlsx, or pdf depending on $format. Any controller wanting an
 * export endpoint builds its own scoped/filtered rows and hands them off
 * here rather than duplicating writer setup.
 */
class Exporter
{
    public static function respond(string $format, string $filename, array $headers, array $rows): Response
    {
        return match ($format) {
            'xlsx' => self::xlsx($filename, $headers, $rows),
            'pdf' => self::pdf($filename, $headers, $rows),
            default => self::csv($filename, $headers, $rows),
        };
    }

    private static function csv(string $filename, array $headers, array $rows): Response
    {
        $handle = fopen('php://temp', 'w+');

        fputcsv($handle, $headers);

        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'.csv"',
        ]);
    }

    private static function xlsx(string $filename, array $headers, array $rows): Response
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray($headers, null, 'A1');

        $lastColumn = $sheet->getHighestColumn(1);
        $sheet->getStyle('A1:'.$lastColumn.'1')->getFont()->setBold(true);

        $sheet->fromArray($rows, null, 'A2');

        $tempFile = tempnam(sys_get_temp_dir(), 'export_').'.xlsx';

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename.'.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    private static function pdf(string $filename, array $headers, array $rows): Response
    {
        return Pdf::loadView('exports.generic-table', [
            'title' => $filename,
            'headers' => $headers,
            'rows' => $rows,
        ])->setPaper('a4', 'landscape')->download($filename.'.pdf');
    }
}
