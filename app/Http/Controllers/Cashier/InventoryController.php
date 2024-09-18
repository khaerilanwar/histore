<?php

namespace App\Http\Controllers\Cashier;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class InventoryController extends Controller
{
    protected $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function index(Request $request): View
    {
        $search = $request->query('s');
        $limit = $request->query('limit', 5);
        $products = $this->productModel;

        if ($search) {
            $products = $products->search($search);
        }

        $data = [
            'limit' => $limit,
            'products' => $products->paginate($limit),
        ];

        return view('cashier.inventory', $data);
    }
}
