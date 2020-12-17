<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ModalExport implements FromView, WithStyles
{
    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            8 => [
                'font' => ['bold' => true],
            ]
        ];
    }

    public function view() : View
    {
        return view('exports.modal', ['modals' => $this->data]);
    }
}