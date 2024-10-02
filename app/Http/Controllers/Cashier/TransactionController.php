<?php

namespace App\Http\Controllers\Cashier;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TransactionProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    protected $transactionModel;
    protected $transactionProductModel;
    protected $productModel;
    protected $memberModel;
    protected $shopModel;

    public function __construct()
    {
        $this->transactionModel = new Transaction();
        $this->transactionProductModel = new TransactionProduct();
        $this->productModel = new Product();
        $this->memberModel = new Member();
        $this->shopModel = new Shop();
    }

    protected function _bonGenerator()
    {
        do {
            $nomor_bon = date('m') . date('d') . strtoupper(Str::random(4));
        } while (Transaction::find($nomor_bon));

        return $nomor_bon;
    }

    public function sale(Request $request): View
    {
        $processTransaction = $this->transactionModel->getTransactionProcess();
        $pending_transaction = $this->transactionModel->getPendingSaleMoreThanTenMinutes();

        // Jika ada transaksi yang masih proses transaksi
        if ($processTransaction) {
            $data = [
                'bon' => $processTransaction->id,
                'transaction' => $processTransaction
            ];
        }

        // Jika ada transaksi pending lebih dari 10 menit
        elseif ($pending_transaction) {
            $data = [
                'bon' => $pending_transaction->id,
                'transaction' => $pending_transaction
            ];
        }

        // Jika tidak ada transaksi yang statusnya masih proses ataupun pending
        else {
            $data = ['bon' => $this->_bonGenerator(), 'transaction' => ''];
        }

        return view('cashier.sales', $data);
    }

    public function scanProduct(Request $request)
    {
        // Data pada method request post
        $barcode = $request->post('barcode');
        $nomor_bon = $request->post('nomor_bon');
        $idLastProduct = $request->post('id-last-product');
        $quantityLastProduct = $request->post('quantity-last-product');

        // Mendapatkan data pada database
        $transactionProduct = $this->transactionProductModel->getTransactionProduct($nomor_bon, 'barcode', $barcode);
        $lastProduct = $this->transactionProductModel->getTransactionProduct($nomor_bon, 'product_id', $idLastProduct);
        $product = $this->shopModel->findProductBy('barcode', $barcode);

        // Mengecek jika tidak ada produk (transaksi baru)
        if ($idLastProduct && $quantityLastProduct) {
            // Memperbarui kuantitas produk terjual jika antara data pada tabel dan aktual berbeda
            if ($lastProduct->quantity != $quantityLastProduct) {
                $lastProduct->quantity = $quantityLastProduct;
                $lastProduct->subtotal = $quantityLastProduct * $lastProduct->product->price;
                $lastProduct->save();
            }
        }

        // Update quantity and subtotal product when product scan is exist on transaction_products table
        if ($transactionProduct) {
            // Mengecek jika stok yang dijual lebih dari stok sebenarnya
            if ($product->stock != $transactionProduct->quantity) {
                $transactionProduct->increment('quantity');
                $transactionProduct->subtotal = $transactionProduct->quantity * $transactionProduct->product->price;
                $transactionProduct->save();
            } else {
                return redirect()->back()->with('error', 'Stok produk sudah habis!');
            }
        } else {
            // Mengecek jika produk tidak ada pada data master produk
            if (!$product) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan');
            }

            // Mengecek jika stok produknya kosong
            if ($product->stock != 0) {
                // Jika transaksi baru dan baru scan produk pertama
                $transaction = $this->transactionModel->find($nomor_bon);
                if (!$transaction) {
                    $this->transactionModel->create(
                        [
                            'id' => $nomor_bon,
                            'status' => 'process',
                            'user_id' => Auth::user()->id,
                        ]
                    );
                }

                // Menambahkan data transaksi produk ke tabel
                $this->transactionProductModel->create(
                    [
                        'transaction_id' => $nomor_bon,
                        'product_id' => $product->product->id,
                        'quantity' => 1,
                        'subtotal' => $product->product->price,
                    ]
                );
            } else {
                return redirect()->back()->with('error', 'Stok produk kosong!');
            }
        }

        return redirect()->back();
    }

    public function removeSaleProduct(Request $request)
    {
        $idTransactionProduct = $request->post('id-transaksi-produk');
        $this->transactionProductModel->find($idTransactionProduct)->delete();

        return redirect()->back();
    }

    public function finishTransaction(Request $request)
    {
        // Mendapatkan data request method post
        $nomor_bon = $request->post('nomor_bon');
        $totalPrice = $request->post('totalPriceFinish');
        $idLastProduct = $request->post('id-last-product');
        $quantityLastProduct = $request->post('quantity-last-product');
        $nomor_bon = $request->post('nomor_bon');

        // Mendapatkan data session
        $member_id = $request->session()->get('member_id');

        // Mendapatkan data transaksi produk
        $lastProduct = $this->transactionProductModel->getTransactionProduct($nomor_bon, 'product_id', $idLastProduct);

        // Update quantity and subtotal of last product before disable edit quantity
        if ($lastProduct->quantity != $quantityLastProduct) {
            $lastProduct->quantity = $quantityLastProduct;
            $lastProduct->subtotal = $quantityLastProduct * $lastProduct->product->price;
            $lastProduct->save();
        }

        $transaction = $this->transactionModel->find($nomor_bon);

        try {
            DB::beginTransaction();

            // Melakukan looping untuk produk terjual
            foreach ($transaction->transactionProducts as $item) {
                // Mengurangi stock produk pada tabel produk
                $this->shopModel->findProductBy('id', $item->product_id)->decrement('stock', $item->quantity);
            }

            // Mengubah data pada tabel transaksi
            $dataFinishTransaction = [
                'total_price' => $transaction->transactionProducts->sum('subtotal'),
                'transaction_date' => Carbon::now(),
                'payment_method' => 'cash',
                'status' => 'success'
            ];

            $member_id ? $dataFinishTransaction['member_id'] = $member_id : '';

            $this->transactionModel->find($nomor_bon)->update($dataFinishTransaction);

            DB::commit();

            // delete session member data
            $request->session()->forget(['member_id', 'member_name']);
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect()->back();
    }

    public function cekMember(Request $request)
    {
        $nomor_hp = $request->post('no_hp');
        $member = $this->memberModel->getMemberBy('no_hp', $nomor_hp);
        $request->session()->put(['member_id' => $member->id, 'member_name' => $member->name]);

        return redirect()->back();
    }

    public function removeMember(Request $request)
    {
        $request->session()->forget(['member_id', 'member_name']);

        return redirect()->back();
    }
}
