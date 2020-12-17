<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenjualanProductExport implements FromView, WithStyles
{
    use Exportable;

    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function styles(Worksheet $sheet)
    {
        return  [
            4    => [
                'font' => ['bold' => true],
            ],
        ];
    }

    public function view() : View
    {
        return view('exports.penjualanProduct', ['products' => $this->data]);
    }
}