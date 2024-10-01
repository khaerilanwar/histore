<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\StockShop;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class NotificationController extends Controller
{
    protected $stockShopModel;

    public function __construct()
    {
        $this->stockShopModel = new StockShop();
    }

    public function detail(Request $request, Notification $notif): View
    {
        $data = [
            'notif' => $notif
        ];
        return view('cashier.detail-notif', $data);
    }

    public function confirm(Request $request, Notification $notif): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Mengubah readable notif menjadi true
            $notif->readable = true;
            $notif->save();

            foreach ($notif->inproducts as $item) {
                // Menambah stock produk masuk
                $stock_shop = $this->stockShopModel
                    ->where('product_id', $item->product_id)
                    ->where('shop_id', $notif->shop_id)->first();

                $stock_shop->increment('stock', $item->stock_in);
                $stock_shop->save();

                // Mengubah date confirm in product
                $item->date_confirm = Carbon::now();
                $item->save();
            }

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal konfirmasi data!');
        }

        return redirect()->to('/cashier/inventory')->with('success', 'Berhasil konfirmasi data!');
    }
}
