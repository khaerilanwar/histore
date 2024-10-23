<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    protected $shopModel;

    public function __construct()
    {
        $this->shopModel = new Shop();
    }

    public function index(Request $request): View
    {
        $limit = $request->query('limit', 5);
        $search = $request->query('s');

        $data = [
            'shops' => $this->shopModel->shopSearch($search)->paginate($limit),
            'limit' => $limit
        ];

        return view('admin.shops', $data);
    }

    public function shopInventory(Request $request, Shop $shop): View
    {
        // Mengecek apakah kode toko tidak ditemukan
        if (!$shop) {
            abort(404);
        }

        // Menjalankan kode di bawah jika kode toko ditemukan
        $limit = $request->query('limit', 5);
        $search = $request->query('s');
        $data = [
            'shop' => $shop,
            'products' => $this->shopModel->inventoryShopById($shop->id, $search)->orderBy('stock')->paginate($limit),
            'limit' => $limit
        ];
        return view('admin.shop-inventory', $data);
    }

    public function shopStaff(Request $request, Shop $shop): View
    {
        // Mengecek apakah kode toko tidak ditemukan
        if (!$shop) {
            abort(404);
        }

        $limit = $request->query('limit', 5);
        $search = $request->query('s');

        $data = [
            'shop' => $shop,
            'limit' => $limit
        ];

        return view('admin.shop-staff', $data);
    }
}
