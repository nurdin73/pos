<?php
namespace App\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Throwable;

class TransaksiExport implements FromView, WithStyles, ShouldQueue
{
    use Exportable;

    protected $data;
    protected $year;
    public function __construct(Object $data, String $year) {
        $this->data = $data;
        $this->year = $year;
    }

    public function styles(Worksheet $sheet)
    {
        $dataset = [
            8    => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'f1f1f1'], 'name' => 'Arial'],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '21209c']],
            ],
        ];
        for ($i=1; $i <= count($this->data); $i++) { 
            $row = 8 + $i;
            $dataset[$row] = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '808080'
                        ]
                    ]
                ]
            ];
        }
        return $dataset;
        // return [
        //     8    => [
        //         'font' => ['bold' => true, 'color' => ['rgb' => 'f1f1f1'], 'name' => 'Arial'],
        //         'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '21209c']],
        //     ],
        //     9 => [
        //         'borders' => [
        //             'allBorders' => [
        //                 'borderStyle' => Border::BORDER_THIN,
        //                 'color' => [
        //                     'rgb' => '808080'
        //                 ]
        //             ]
        //         ]
        //     ],
        //     $dataset
        // ];
    }

    public function view() : View
    {
        return view('exports.transaksi-list', ['transactions' => $this->data, 'year' => $this->year]);
    }

    public function failed(Throwable $exception): void
    {
        Log::error($exception->getMessage());
    }
}