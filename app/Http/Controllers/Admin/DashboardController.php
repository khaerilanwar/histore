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
        dd($this->transactionModel->getSalesMonthly()->toArray());
        $data = [];
        return view('admin.index', $data);
    }
}
