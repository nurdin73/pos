<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PembelianProductExport implements FromView, WithStyles
{
    use Exportable;
    protected $data;
    public function __construct($data) {
        $this->data = $data;
    }

    public function styles(Worksheet $sheet)
    {
        return  [
            8    => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'f1f1f1'], 'name' => 'Arial'],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '21209c']]
            ],
        ];
    }

    public function view() : View
    {
        return view('exports.pembelianProducts', ['products' => $this->data]);
    }
}