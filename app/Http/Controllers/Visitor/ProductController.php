<?php

namespace App\Http\Controllers\Visitor;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function index(Request $request)
    {
        $search = $request->query('s');
        $limit = 12;
        $products = $search ? $this->productModel->search($search) : $this->productModel;
        $data = [
            'products' => $products->paginate($limit),
            'categories' => $this->categoryModel->all()
        ];
        return view('visitor.products', $data);
    }

    public function byCategory(Request $request, string $category)
    {
        $search = $request->query('s');
        $limit = 12;
        $products =
            $search ?
            $this->productModel->byCategory($category)->search($search) :
            $this->productModel->byCategory($category);
        $data = [
            'products' => $products->paginate($limit),
            'categories' => $this->categoryModel->all()
        ];
        return view('visitor.products', $data);
    }
}
