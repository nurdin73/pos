<?php
namespace App\Services;

use App\Exports\KasbonExport;
use App\Helpers\CreatePaginationLink;
use App\Models\CashReceipts;
use App\Models\Customers;
use App\Models\Installments;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class KasbonService
{
    public function showAll($nama)
    {
        $data = [];
        $results = Customers::with('cashReceipts.installments')->select("*");
        $countData = $results->count();
        $totalKasbon = CashReceipts::with("installments")->get();
        $totalSisa = 0;
        foreach ($totalKasbon as $t) {
            $cicilan = 0;
            foreach ($t->installments as $i) {
                $cicilan += $i->cicilan;
            }
            $totalSisa += $t->jumlah - $cicilan;
        }
        if($nama != "") {
            $results = $results->where('nama', 'like', '%'.$nama.'%')->paginate(5);
        } else {
            $results = $results->paginate(5);
        }
        $convertData = new CreatePaginationLink($results->getCollection(), $results->links(), $results->currentPage());
        $pagination = collect([
            'dataset' => $convertData->crafting(),
            'totalTrx' => $countData,
            'totalKasbon' => $totalSisa
        ]);
        $data['data'] = [];
        foreach ($results as $customer) {
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
        $result->setRelation('installments', $result->installments()->simplePaginate(5));
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

    public function chartKasbon($query, $type)
    {
        $labelTime = [];
        $sets = [];
        $sets['data'] = [];
        switch ($query) {
            case 'days':
                $dateAwal = date('j') > 5 ? date('j') - 5 : 1;
                for ($i=$dateAwal; $i <= date('j') + 3; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $tgl = date('Y-m'). "-" .$i;
                    $labelTime[$tgl] = [];
                }
                foreach ($labelTime as $t => $value) {
                    $results = CashReceipts::with('installments')->where('tgl_kasbon', 'like', '%'.$t.'%')->get();
                    $sets['data'][$t] = [];
                    foreach ($results as $r) {
                        $dibayar = 0;
                        foreach ($r->installments as $installment) {
                            $dibayar += $installment->cicilan;
                        }
                        $sisa = $r->jumlah - $dibayar;
                        $data = [
                            'dibayar' => $dibayar,
                            'sisa'    => $sisa,
                            'jumlah'  => $r->jumlah
                        ];
                        array_push($sets['data'][$t], $data);
                    }
                }
                break;
            case 'months':
                for ($i=1; $i <= 12; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $bln = date('Y')."-".$i;
                    $labelTime[$bln] = [];
                }
                foreach ($labelTime as $t => $value) {
                    $results = CashReceipts::with('installments')->where('tgl_kasbon', 'like', '%'.$t.'%')->get();
                    $monthName = explode('-', $t);
                    $convertMonth = DateTime::createFromFormat('!m', $monthName[1]);
                    $nameMonth = $convertMonth->format('F');
                    $sets['data'][$nameMonth] = [];
                    foreach ($results as $r) {
                        $dibayar = 0;
                        foreach ($r->installments as $installment) {
                            $dibayar += $installment->cicilan;
                        }
                        $sisa = $r->jumlah - $dibayar;
                        $data = [
                            'dibayar' => $dibayar,
                            'sisa'    => $sisa,
                            'jumlah'  => $r->jumlah
                        ];
                        array_push($sets['data'][$nameMonth], $data);
                    }
                }
                break;
            case 'years':
                for ($i=date('Y') - 2; $i <= date('Y') + 8; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $labelTime[$i] = [];
                }
                foreach ($labelTime as $t => $value) {
                    $results = CashReceipts::with('installments')->where('tgl_kasbon', 'like', '%'.$t.'%')->get();
                    $sets['data'][$t] = [];
                    foreach ($results as $r) {
                        $dibayar = 0;
                        foreach ($r->installments as $installment) {
                            $dibayar += $installment->cicilan;
                        }
                        $sisa = $r->jumlah - $dibayar;
                        $data = [
                            'dibayar' => $dibayar,
                            'sisa'    => $sisa,
                            'jumlah'  => $r->jumlah
                        ];
                        array_push($sets['data'][$t], $data);
                    }
                }
                break;
            
            default:
                $dateAwal = date('j') > 5 ? date('j') - 5 : 1;
                for ($i= $dateAwal; $i <= date('j') + 3; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $tgl = date('Y-m'). "-" .$i;
                    $labelTime[$tgl] = [];
                }
                foreach ($labelTime as $t => $value) {
                    $results = CashReceipts::with('installments')->where('tgl_kasbon', 'like', '%'.$t.'%')->get();
                    $sets['data'][$t] = [];
                    foreach ($results as $r) {
                        $dibayar = 0;
                        foreach ($r->installments as $installment) {
                            $dibayar += $installment->cicilan;
                        }
                        $sisa = $r->jumlah - $dibayar;
                        $data = [
                            'dibayar' => $dibayar,
                            'sisa'    => $sisa,
                            'jumlah'  => $r->jumlah
                        ];
                        array_push($sets['data'][$t], $data);
                    }
                }
                break;
        }
        $kasbon = CashReceipts::with('installments')->get();
        $sets['totalKasbon'] = 0;
        $sets['totalSisaKasbon'] = 0;
        $sets['totalDibayar'] = 0;
        foreach ($kasbon as $k) {
            $dibayar = 0;
            foreach ($k->installments as $installment) {
                $dibayar += $installment->cicilan;
            }
            $sisa = $k->jumlah - $dibayar;
            $sets['totalKasbon'] += $k->jumlah;
            $sets['totalSisaKasbon'] += $sisa;
            $sets['totalDibayar'] += $dibayar;
        }
        if($type == "export") {
            $filename = 'Kasbon-'.Str::random(20).'.xlsx';
            return Excel::download(new KasbonExport($sets, $query), $filename);
        } else {
            return $sets;
        }
    }
}