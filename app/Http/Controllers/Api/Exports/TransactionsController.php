<?php

namespace App\Http\Controllers\Api\Exports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    protected $transactionService;

    public function __construct() {
        $this->transactionService = app()->make('TransactionService');
    }

    public function hours()
    {
        return $this->transactionService->getTrxPerHours("export");
    }

    public function days()
    {
        return $this->transactionService->getTrxPerDays("export");
    }

    public function months()
    {
        return $this->transactionService->getTrxPerMonth("export");
    }

    public function years()
    {
        return $this->transactionService->getTrxPerYear("export");
    }

    public function transactions(Request $request)
    {
        $years = $request->input('year') != null ? $request->input('year') : date('Y');
        return $this->transactionService->exportTransactions($years);
    }

    public function invoice(Request $request)
    {
        $id = $request->input('id');
        return $this->transactionService->exportPdfInvoice($id);
    }
}
