<?php

namespace App\Http\Controllers\Cashier;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Contracts\View\View;

class InventoryController extends Controller
{
    protected $productModel;
    protected $notificationModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->notificationModel = new Notification();
    }

    public function index(Request $request): View
    {
        $search = $request->query('s');
        $limit = $request->query('limit', 5);
        $products = $this->productModel->inventoryShop($search);

        $data = [
            'limit' => $limit,
            'products' => $products->paginate($limit),
            'notifications' => $this->notificationModel->notificationUser()->orderBy('updated_at')->get()
        ];

        return view('cashier.inventory', $data);
    }
}
