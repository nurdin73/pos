<?php
namespace App\Services;

use App\Models\Tax;
use App\Models\Products;
use App\Models\Transactions;
use DateTime;

class TaxService
{
    protected function getTax()
    {
        $results = Tax::select(['id', 'nama_pajak', 'persentasePajak', 'persentaseLayanan', 'hargaBarang', 'pajakAktif', 'layananAktif']);
        // $results = Tax::select('*');
        return $results;
    }

    public function getAll($nama, $paginate)
    {
        $results = $this->getTax();
        $results->orderBy('nama_pajak', 'ASC');
        if($nama != "") {
            $results = $results->where('nama_pajak', 'like', '%'.$nama.'%')->paginate($paginate);
        } else {
           $results = $results->paginate($paginate);
        }

        return response($results);
    }

    public function getDetail($id)
    {
        $result = $this->getTax()->where('id', $id)->first();
        return response($result);
    }

    public function addTax($data)
    {
        $create = Tax::create($data);
        if(!$create) return response(['message' => 'Pajak gagal ditambahkan'], 500);
        return response(['message' => 'Pajak berhasil ditambahkan']);
    }

    public function updateTax($data, $id)
    {
        $checkTax = Tax::find($id);
        $update = null;
        if(!$checkTax) {
            $update = Tax::create($data);
        } else {
            $update = $checkTax->update($data);
        }
        if(!$update) return response(['message' => 'Update Pajak tidak berhasil'], 500);
        return response(['message' => 'Update Pajak berhasil']);
    }

    public function deleteTax($id)
    {
        $checkTax = $this->getTax()->where('id', $id)->first();
        if(!$checkTax) return response(['message' => 'Data Pajak tidak ditemukan'], 404);
        $delete = $checkTax->delete();
        if(!$delete) return response(['message' => 'Hapus Pajak tidak berhasil'], 500);
        return response(['message' => 'Hapus Pajak berhasil']);
    }

    public function reportTaxes()
    {
        $results = Transactions::select('id', 'pajak', 'total');
        $data = [];
        $data['totalPenjualan'] = $results->sum('total');
        $data['totalPajak'] = $results->sum('pajak');
        
        $response = $data;
        return response($response);
    }

    public function cartPajak($query)
    {
        $labelTime = [];
        $sets = [];
        switch ($query) {
            case 'days':
                $dateAwal = date('j') > 5 ? date('j') - 5 : 1;
                for ($i=$dateAwal; $i <= date('j') + 3; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $tgl = date('Y-m'). "-" .$i;
                    $labelTime[$tgl] = [];
                }
                foreach ($labelTime as $t => $value) {
                    $result = Transactions::where('created_at', 'like', "%$t%")->get();
                    $totalTransaksi = 0;
                    $totalPajak = 0;
                    foreach ($result as $r) {
                        $totalPajak += $r->pajak;
                        $totalTransaksi += $r->total;
                    }
                    $sets[$t] = [
                        'total_transaksi' => $totalTransaksi,
                        'total_pajak' => $totalPajak
                    ];
                }
                break;
            
            case 'months':
                for ($i=1; $i <= 12; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $bln = date('Y')."-".$i;
                    $labelTime[$bln] = [];
                }
                foreach ($labelTime as $t => $value) {
                    $result = Transactions::where('created_at', 'like', "%$t%")->get();
                    $monthName = explode('-', $t);
                    $convertMonth = DateTime::createFromFormat('!m', $monthName[1]);
                    $nameMonth = $convertMonth->format('F');
                    $totalTransaksi = 0;
                    $totalPajak = 0;
                    foreach ($result as $r) {
                        $totalPajak += $r->pajak;
                        $totalTransaksi += $r->total;
                    }
                    $sets[$nameMonth] = [
                        'total_transaksi' => $totalTransaksi,
                        'total_pajak' => $totalPajak
                    ];
                }
                break;
            
            case 'years':
                for ($i=date('Y') - 2; $i <= date('Y') + 8; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $labelTime[$i] = [];
                }
                foreach ($labelTime as $t => $value) {
                    $result = Transactions::where('created_at', 'like', "%$t%")->get();
                    $totalTransaksi = 0;
                    $totalPajak = 0;
                    foreach ($result as $r) {
                        $totalPajak += $r->pajak;
                        $totalTransaksi += $r->total;
                    }
                    $sets[$t] = [
                        'total_transaksi' => $totalTransaksi,
                        'total_pajak' => $totalPajak
                    ];
                }
                break;
            
            default:
                $dateAwal = date('j') > 5 ? date('j') - 5 : 1;
                for ($i=$dateAwal; $i <= date('j') + 3; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $tgl = date('Y-m'). "-" .$i;
                    $labelTime[$tgl] = [];
                }
                foreach ($labelTime as $t => $value) {
                    $result = Transactions::where('created_at', 'like', "%$t%")->get();
                    $totalTransaksi = 0;
                    $totalPajak = 0;
                    foreach ($result as $r) {
                        $totalPajak += $r->pajak;
                        $totalTransaksi += $r->total;
                    }
                    $sets[$t] = [
                        'total_transaksi' => $totalTransaksi,
                        'total_pajak' => $totalPajak
                    ];
                }
                break;
        }
        return response($sets);
    }
}