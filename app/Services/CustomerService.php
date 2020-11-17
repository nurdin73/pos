<?php
namespace App\Services;

use App\Models\CashReceipts;
use App\Models\Customers;

class CustomerService
{
    public function getAll()
    {
        $results = Customers::select('id','nama','email')->orderBy('id', 'ASC')->get();
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
        $total = collect(['total_kasbon' => CashReceipts::select("jumlah")->where('pelanggan_id', $id)->sum('jumlah')]); 
        $customer->setRelation('cashReceipts', $customer->cashReceipts()->with('installments')->paginate(5));
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
}