<?php
namespace App\Services;

use App\Models\CashReceipts;
use App\Models\Customers;
use App\Models\Installments;

class KasbonService
{
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
        $result = CashReceipts::with('customer')->where('id', $id)->first();
        $result->setRelation('installments', $result->installments()->paginate(5));
        return response($result);
    }

    public function processPayment($data = [], $id)
    {
        $message = [];
        $totalCicilan = 0;
        $cicilan = $data['cicilan'];
        $checkKasbon = CashReceipts::with('installments')->where('id', $id)->first();
        foreach ($checkKasbon->installments as $i) {
            $totalCicilan += $i->cicilan;
        }
        if(!$checkKasbon) return response(['message' => 'Kasbon tidak ditemukan'], 404);
        $data['cash_receipt_id'] = $id;
        $data['tgl_pembayaran'] = date('Y-m-d H:i:s');
        $newTotalCicilan = $totalCicilan + $data['cicilan'];
        $message['message'] = 'Cicilan berhasil ditambahkan';
        if($newTotalCicilan > $checkKasbon->jumlah) {
            $data['cicilan'] = $checkKasbon->jumlah - $totalCicilan;
            $kembalian = intval($cicilan) - intval($data['cicilan']);
            $message['message'] = 'Kasbon lunas. biaya kembalian = '. $kembalian;
        }
        $create = Installments::create($data);
        if(!$create) return response(['message' => 'Cicilan gagal ditambahkan'], 500);
        return response($message);
    }
}