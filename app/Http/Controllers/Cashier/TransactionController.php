<?php

namespace App\Http\Controllers\Cashier;

use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TransactionProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    protected $transactionModel;
    protected $transactionProductModel;

    public function __construct()
    {
        $this->transactionModel = new Transaction();
        $this->transactionProductModel = new TransactionProduct();
    }

    protected function _bonGenerator()
    {
        do {
            $nomor_bon = date('m') . date('d') . strtoupper(Str::random(4));
        } while (Transaction::find($nomor_bon));

        return $nomor_bon;
    }

    public function sale(Request $request)
    {
        // Jika ada transaksi pending lebih dari 10 menit
        $pending_transaction = $this->transactionModel->getPendingSaleMoreThanTenMinutes();

        $transaction = $this->transactionProductModel->where('transaction_id', $pending_transaction->id)->get();
        $data = [
            'bon' => $pending_transaction->id,
            'transaction' => $transaction,
        ];

        return view('cashier.sales', $data);
    }

    public function scanProduct(Request $request)
    {
        $barcode = $request->post('barcode');
        $nomor_bon = $request->post('nomor_bon');
        $transactionProduct = $this->transactionProductModel->getTransactionProduct($nomor_bon, $barcode);
        dd($transactionProduct);

        if ($transactionProduct) {
            $transactionProduct->increment('quantity');
            $transactionProduct->subtotal = $transactionProduct->quantity * $transactionProduct->product->price;
            $transactionProduct->save();
        } else {
            $data = [
                'transaction_id' => $nomor_bon,
                'product_id' => $transactionProduct->product->id,
                'quantity' => 1,
                'subtotal' => $transactionProduct->product->price,
            ];
            $this->transactionProductModel->create($data);
        }

        return redirect()->back();
    }

    public function removeSaleProduct(Request $request)
    {
        $idTransactionProduct = $request->post('id-transaksi-produk');
        // Menghapus data produk transaksi
        DB::table('transaction_products')->where('id', $idTransactionProduct)->delete();

        return redirect()->back();
    }
}
