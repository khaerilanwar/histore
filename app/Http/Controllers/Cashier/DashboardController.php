<?php

namespace App\Http\Controllers\Cashier;

use App\Models\Shop;
use App\Models\Product;
use Illuminate\View\View;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $transactionModel;
    protected $shopModel;

    public function __construct()
    {
        $this->transactionModel = new Transaction();
        $this->shopModel = new Shop();
    }

    public function index(Request $request): View
    {
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
