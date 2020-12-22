<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransaksiExport implements FromView, WithStyles
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
        return [
            8    => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'f1f1f1'], 'name' => 'Arial'],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '21209c']]
            ],
        ];
    }

    public function view() : View
    {
        return view('exports.transaksi-list', ['transactions' => $this->data, 'year' => $this->year]);
    }
}