<?php
namespace App\Services;

use App\Models\CashReceipts;
use App\Models\Customers;

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

    // public function showAll($nama)
    // {   
    //     $customers = null;
    //     $totalkasbonUser = collect(['total_kasbon_user' => 0]);
    //     $totalTrx = collect(['total_trx' => CashReceipts::all()->count()]);
    //     $total = collect(['total_kasbon' => CashReceipts::select("jumlah", 'pelanggan_id')->sum('jumlah')]);
    //     if($nama != "") {
    //         $customers = Customers::where('nama', 'like', '%'.$nama.'%')->paginate(5);
    //     } else {
    //         $customers = Customers::select('id', 'nama', 'email', 'no_telp')->paginate(5);
    //     }
    //     if($customers) {
    //         foreach ($customers as $customer) {
    //             $totalkasbonUser = collect(['total_kasbon_user' => CashReceipts::select("jumlah", 'pelanggan_id')->where('pelanggan_id', $customer->id)->sum('jumlah')]);
    //         }
    //     }
    //     $results = $totalkasbonUser->merge($customers);
    //     $results = $total->merge($results);
    //     $results = $totalTrx->merge($results);
    //     return response($results);
    // }
    public function showAll($nama)
    {
        $data = [];
        $customers = null;
        if($nama != "") {
            $customers = Customers::with('cashReceipts.installments')->where('nama', 'like', '%'.$nama.'%')->paginate(5);
        } else {
            $customers = Customers::with('cashReceipts.installments')->paginate(5);
        }
        $pagination = collect([
            'last_page' => $customers->lastPage(),
            'current_page' => $customers->currentPage(),
            'prev_page_url' => $customers->previousPageUrl()
        ]);
        $data['data'] = [];
        foreach ($customers as $customer) {
            if(count($customer->cashReceipts) > 0) {
                $sub_array = [];
                $sub_array['id'] = $customer->id;
                $sub_array['nama'] = $customer->nama;
                $sub_array['email'] = $customer->email;
                $sub_array['no_telp'] = $customer->no_telp;
                $sub_array['jumlah'] = 0;
                $sub_array['cicilan'] = 0;
                $sub_array['total'] = count($customer->cashReceipts);
                foreach ($customer->cashReceipts as $cr) {
                    $sub_array['jumlah'] += $cr->jumlah;
                    foreach ($cr->installments as $i) {
                        $sub_array['cicilan'] += $i->cicilan;
                    }
                }
                $sub_array['sisa'] = $sub_array['jumlah'] - $sub_array['cicilan'];
                array_push($data['data'], $sub_array);
            }
        }
        // $data = array_values($data);
        $results = $pagination->merge($data);
        return response($results);
    }

    public function add($data)
    {
        $create = CashReceipts::create($data);
        if(!$create) return response(['message' => 'Kasbon gagal ditambahkan'], 500);
        return response(['message' => 'Kasbon berhasil ditambahkan']);
    }

    public function detail($id)
    {
        $result = CashReceipts::with('customer', 'installments')->where('id', $id)->first();
        return response($result);
    }
}