<?php

namespace App\Http\Controllers\Cashier;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new Transaction();
    }

    public function index(Request $request): View
    {
        // dd($this->transactionModel->totalSales());
        // dd($this->transactionModel->dailySales()->get()->toArray());
        $limit = $request->query('limit', 5);
        $data = [
            'user' => Auth::user(),
            'limit' => $limit,
            'soldProducts' => $this->transactionModel->dailySales()->paginate($limit),
            // Data Resume
            'sales' => $this->transactionModel->totalSales(),
            'transactions' => $this->transactionModel->totalTransactions(),
            'retur' => 0,
            'sold' => $this->transactionModel->totalSold(),
        ];

        return view('cashier.index', $data);
    }
}
