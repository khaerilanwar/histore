<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new Transaction();
    }

    public function index(Request $request): View
    {
        $data = [
            'chartData' => $this->transactionModel->getSalesMonthly(),        // output: 2D Array [month, sales] 
            'dataThisMonth' => $this->transactionModel->getDataThisMonth()    // output: 1D Array [penjualan, modal, profit]
        ];
        return view('admin.index', $data);
    }
}
