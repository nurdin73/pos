<?php
namespace App\Services;

use App\Exports\CustomerExport;
use App\Models\CashReceipts;
use App\Models\Customers;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class CustomerService
{
    public function getAll()
    {
        $results = Customers::select('id', 'nik', 'nama', 'email', 'point')->orderBy('id', 'ASC')->get();
        return datatables()
        ->of($results)
        ->addIndexColumn()
        ->addColumn('actions', function($rows) {
            $rows = json_encode($rows);
            $rows = json_decode($rows);
            $id = $rows->id;
            $btn = "<div class='btn-group'>";
            $btn .= "<button class='btn btn-sm btn-info update' data-id='$id' data-toggle='modal' data-target='#updateCustModal'>Update</button>";
            $btn .= "<button class='btn btn-sm btn-primary detail' data-id='$id' data-toggle='modal' data-target='#detailCustModal'>Detail</button>";
            $btn .= "<button class='btn btn-sm btn-danger delete' data-id='$id'>Delete</button>";
            $btn .= '</btn>';
            return $btn;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function search($nama)
    {
        $nama = '%'.$nama.'%';
        $results = Customers::where('nama', 'like', $nama)->limit(5)->get();
        return response($results);
    }

    public function kasbonCustomers($id)
    {
        $customer = Customers::find($id);
        $total = collect([
            'total_kasbon' => CashReceipts::select("jumlah")->where('pelanggan_id', $id)->sum('jumlah'),
            'total_trx'    => CashReceipts::select("jumlah")->where('pelanggan_id', $id)->count()
        ]); 
        $customer->setRelation('cashReceipts', $customer->cashReceipts()->with('installments')->simplePaginate(5));
        $results = $total->merge($customer);
        return response($results);
    }

    public function add($data)
    {
        $create = Customers::create($data);
        if(!$create) return response(['message' => 'Pelanggan gagal ditambahkan'], 500);
        return response(['message' => 'Pelanggan berhasil ditambahkan']);
    }

    public function get($id)
    {
        $result = Customers::find($id);
        if(!$result) return response(['message' => 'Opps!. Terjadi kesalahan'], 406);
        return response($result);
    }

    public function update($data, $id)
    {
        $result = Customers::find($id);
        if(!$result) return response(['message' => 'Opps!. Terjadi kesalahan'], 406);
        $result->update($data);
        return response(['message' => 'Data customer berhasil diupdate']);
    }

    public function destroy($id)
    {
        $result = Customers::find($id);
        if(!$result) return response(['message' => 'Opps!. Terjadi kesalahan'], 406);
        $result->delete();
        return response(['message' => 'Pelanggan berhasil dihapus!']);
    }

    public function chartPelanggan($query)
    {
        $sets = [];
        $sets['data'] = [];
        $labelTime = [];
        switch ($query) {
            case 'days':
                $dateAwal = date('j') > 5 ? date('j') - 5 : 1;
                for ($i=$dateAwal; $i <= date('j') + 3; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $tgl = date('Y-m'). "-" .$i;
                    $labelTime[$tgl] = [];
                }
                foreach ($labelTime as $t => $val) {
                    $results = Customers::where('created_at', 'like', '%'.$t.'%')->count();
                    $sets['data'][$t] = $results;
                }
                break;
            case 'months':
                for ($i=1; $i <= 12; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $bln = date('Y')."-".$i;
                    $labelTime[$bln] = [];
                }
                foreach ($labelTime as $t => $value) {
                    $results = Customers::where('created_at', 'like', '%'.$t.'%')->count();
                    $monthName = explode('-', $t);
                    $convertMonth = DateTime::createFromFormat('!m', $monthName[1]);
                    $nameMonth = $convertMonth->format('F');
                    $sets['data'][$nameMonth] = $results;
                }
                break;
            case 'years':
                for ($i=date('Y') - 2; $i <= date('Y') + 8; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $labelTime[$i] = [];
                }
                foreach ($labelTime as $t => $value) {
                    $results = Customers::where('created_at', 'like', '%'.$t.'%')->count();
                    $sets['data'][$t] = $results;
                }
                break;

            default:
                $dateAwal = date('j') > 5 ? date('j') - 5 : 1;
                for ($i=$dateAwal; $i <= date('j') + 3; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $tgl = date('Y-m'). "-" .$i;
                    $labelTime[$tgl] = [];
                }
                foreach ($labelTime as $t => $val) {
                    $results = Customers::where('created_at', 'like', '%'.$t.'%')->count();
                    $sets['data'][$t] = $results;
                }
                break;
        }
        $yesterday = date('Y-m-d', strtotime('-1 days'));
        $now = date('Y-m-d');
        $selectDB = Customers::select("*");
        $sets['total'] = $selectDB->count();
        $sets['totalCustYesterday'] = $selectDB->where('created_at', 'like', '%'.$yesterday.'%')->count();
        $sets['totalCustNow'] = Customers::where('created_at', 'like', '%'.$now.'%')->count();
        return response($sets);
    }

    public function report()
    {
        $yesterday = date('Y-m-d', strtotime('-1 days'));
        $now = date('Y-m-d');
        $sets = [];
        $selectDB = Customers::select("*");
        $sets['total'] = $selectDB->count();
        $sets['totalCustYesterday'] = $selectDB->where('created_at', 'like', '%'.$yesterday.'%')->count();
        $sets['totalCustNow'] = Customers::where('created_at', 'like', '%'.$now.'%')->count();
        $sets['data'] = Customers::select("*")->orderBy('id', 'ASC')->get();
        $filename = 'Customers-'. Str::random(20) .'.xlsx';
        return Excel::download(new CustomerExport($sets), $filename);
    }
}