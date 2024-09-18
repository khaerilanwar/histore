<?php

namespace App\Http\Controllers\Cashier;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new Transaction();
    }

    public function index(Request $request)
    {
        $limit = $request->query('limit', 5);
        $data = [
            'limit' => $limit,
            'soldProducts' => $this->transactionModel->dailySales(date('2024-09-14'))->paginate($limit),
            // Data Resume
            'sales' => $this->transactionModel->totalSales(),
            'transactions' => $this->transactionModel->totalTransactions(),
            'retur' => 0,
            'sold' => $this->transactionModel->totalSold(),
        ];

        return view('cashier.index', $data);
    }
}
