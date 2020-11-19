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
            'product_id' => 'required|numeric',
        ]);
        $data = [
            'no_invoice' => $request->input('no_invoice'),
            'product_id' => $request->input('product_id'),
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
            'total' => 'required'
        ]);
        return $this->transactionService->add($request->all());
    }

    public function getCarts($no_invoice)
    {
        return $this->transactionService->getCarts($no_invoice);
    }
}
