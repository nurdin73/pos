<?php
namespace App\Services;

use App\Models\CashReceipts;

class KasbonService
{
    public function getAll($name, $tempo)
    {
        $results = null;
        $total = collect(['total_kasbon' => CashReceipts::select("jumlah")->sum('jumlah')]);
        if($name != "") {
            $results = CashReceipts::with('customer')->whereHas('customer', function($q) use($name) {
                $q->where('nama', 'like', '%'. $name .'%');
            });
        } else {
            $results = CashReceipts::with('customer');
        }
        $results->orderBy('id', 'DESC');
        if($tempo != "") {
            $tempo .= " 00:00:00";
            $results = $results->where('jatuh_tempo', $tempo);
        }
        $results = $results->paginate(5);
        $results = $total->merge($results);
        return response($results);
    }

    public function add($data)
    {
        $create = CashReceipts::create($data);
        if(!$create) return response(['message' => 'Kasbon gagal ditambahkan'], 500);
        return response(['message' => 'Kasbon berhasil ditambahkan']);
    }
}