<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransactionHistoryController extends Controller
{
    protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new Transaction();
    }

    public function index(Request $request): View
    {
        $search = $request->query('s');
        $limit = $request->query('limit', 5);
        $historyTransactions = $this->transactionModel->dailyHistories($search);
        $data = [
            'user' => Auth::user(),
            'histories' => $historyTransactions->paginate($limit),
            'limit' => $limit,
        ];
        return view('cashier.history-sales', $data);
    }
}
