<?php

namespace App\Http\Controllers\Api\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    protected $transactionService;

    public function __construct() {
        $this->transactionService = app()->make('TransactionService');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_invoice' => 'required',
            'kode' => 'required',
        ]);
        $data = [
            'no_invoice' => $request->input('no_invoice'),
            'kode' => $request->input('kode'),
            'qyt'        => 1
        ];
        return $this->transactionService->store($data);
    }

    
    public function addTransaksi(Request $request)
    {
        $request->validate([
            'no_invoice' => 'required|unique:transactions',
            'customer_id' => 'required',
            'createdBy' => 'required',
            'total' => 'required',
            'cash' => 'required',
            'change' => 'required'
        ]);
        return $this->transactionService->add($request->all());
    }

    public function getCarts($no_invoice)
    {
        return $this->transactionService->getCarts($no_invoice);
    }

    public function deleteCart($id)
    {
        return $this->transactionService->delete($id);
    }

    public function detailCart($id)
    {
        return $this->transactionService->detailCart($id);
    }

    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'qyt' => 'required|numeric',
            'diskon_product' => 'required|numeric'
        ]);
        $data = [
            'qyt' => $request->input('qyt'),
            'diskon_product' => $request->input('diskon_product')
        ];
        return $this->transactionService->updateCart($data, $id);
    }

    public function transactions(Request $request)
    {
        $date = $request->input('date');
        if(!$date) {
            $date = "hari ini";
        }
        return $this->transactionService->transactions($date);
    }

    public function changePrice(Request $request, $id)
    {
        $request->validate([
            'price' => 'required'
        ]);
        $price = $request->input('price');
        $eceran = $request->input('eceran');
        return $this->transactionService->changePrice($price, $id, $eceran);
    }

    public function getTransactionPerHours()
    {
        return $this->transactionService->getTrxPerHours();
    }

    public function getTransactionPerDays()
    {
        return $this->transactionService->getTrxPerDays();
    }

    public function getTransactionPerMonth()
    {
        return $this->transactionService->getTrxPerMonth();
    }

    public function getTransactionPerYear()
    {
        return $this->transactionService->getTrxPerYear();
    }

    public function listTransaksi(Request $request)
    {
        $no_invoice = $request->input('no_invoice') != null ? $request->input('no_invoice') : "";
        $sorting = $request->input('sorting') != null ? $request->input('sorting') : 10;
        return $this->transactionService->listTransaksi($no_invoice, $sorting);
    }

    public function invoice($id)
    {
        return $this->transactionService->invoice($id);
    }

    public function cancelTransaction($no_invoice)
    {
        return $this->transactionService->cancelTransaction($no_invoice);
    }

    public function cetakStruk($id)
    {
        return $this->transactionService->cetakStruk($id);
    }
}
