<?php

namespace App\Http\Controllers\Api\Exports;

use App\Http\Controllers\Controller;

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
}
