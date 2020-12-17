<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KasbonExport implements FromView, WithStyles
{
    protected $data;
    protected $query;

    public function __construct($data, $query) {
        $this->data = $data;
        $this->query = $query;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            10 => [
                'font' => ['bold' => true],
            ]
        ];
    }

    public function view() : View
    {
        return view('exports.kasbon', ['kasbon' => $this->data, 'query' => $this->query]);
    }
}