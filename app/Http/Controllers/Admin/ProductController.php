<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function index(Request $request): View
    {
        $search = $request->query('s');
        $limit = $request->query('limit', 5);
        $products = $this->productModel->masterProduct($search);
        $data = [
            'products' => $products->paginate($limit),
            'limit' => $limit
        ];
        return view('admin.products', $data);
    }

    public function addProduct(Request $request): View
    {
        $data = [
            'categories' => $this->categoryModel->all()
        ];
        return view('admin.add-product', $data);
    }

    public function checkBarcode(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Barcode harus numeric!');
        }

        // Mengecek apakah barcode sudah ada pada data master
        $checkProduct = $this->productModel->getProductByBarcode($validator->validate()['barcode']);

        if ($checkProduct) {
            // Jika produk sudah ada dalam data master
            return redirect()->back()->with(['error' => 'Produk sudah tersedia!', 'product' => $checkProduct]);
        } else {
            // Jika produk belum ada dalam data master
            return redirect()->back()->with('barcodeNewProduct', $request->post('barcode'));
        }
    }

    public function updateProduct(Request $request, Product $product)
    {
        // Mendapatkan data harga beli dan jual
        $updateData = [
            'price_buy' => str($request->post('price_buy'))->replace(['Rp. ', '.'], '')->value(),
            'price' => str($request->post('price'))->replace(['Rp. ', '.'], '')->value(),
        ];

        // Mengecek apakah ada harga diskon
        if ($request->post('price_discount')) {
            // Jika ada maka tambahkan ke array update data
            $updateData['price_discount'] = str($request->post('price_discount'))->replace(['Rp. ', '.'], '')->value();
        }

        // Menyimpan perubahan data ke dalam database
        $product->update($updateData);

        // Mengarahkan kembali ke halaman daftar product
        return redirect()->back()->with('success', 'Berhasil mengubah data produk!');
    }

    public function storeProduct(Request $request)
    {
        $validateNewProduct = $request->validate(
            [
                'barcode' => 'required|numeric',
                'name' => 'required|unique:products,name|min:5',
                'price' => 'required',
                'price_buy' => 'required',
                'category_id' => 'required|numeric',
                'images.*' => 'image|mimes:jpeg,jpg,png|file|max:1024'
            ]
        );

        // Mengecek apakah ada gambar produk
        if ($request->hasFile('images')) {
            $imagesName = [];
            foreach ($request->file('images') as $image) {
                // Memberikan nama gambar secara unik dan kumpulkan nama dalam sebuah array
                $imageName = time() . '_' . Str::random(5) . '.' . $image->extension();
                array_push($imagesName, $imageName);
            }
        }

        // Filtering data inputan sebelum masuk ke database
        $validateNewProduct['price_buy'] = str($validateNewProduct['price_buy'])->replace(['Rp. ', '.'], '')->value();
        $validateNewProduct['price'] = str($validateNewProduct['price'])->replace(['Rp. ', '.'], '')->value();
        $validateNewProduct['images'] = implode(" -- ", $imagesName);

        // Memulai proses transaksi
        DB::beginTransaction();
        try {
            // Menambahkan data produk baru ke dalam database
            $this->productModel->create($validateNewProduct);

            // Mengurus upload file image
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $i => $image) {
                    // Menyimpan file gambar ke dalam server
                    $savePath = "public/images";
                    $image->storeAs($savePath, $imagesName[$i]);
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan data produk baru!');
            //throw $th;
        }

        return redirect('/admin/product')->with('success', 'Berhasil menambahkan data produk baru!');
    }

    public function removeProduct(Request $request, Product $product): RedirectResponse
    {
        try {
            // Memecah nama gambar menjadi array
            $images = explode(' -- ', $product->images);
            // Menghapus file gambar dari database
            foreach ($images as $image) {
                Storage::delete("public/images/" . $image);
            }
            // Menghapus data produk dari database
            $product->delete();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus data produk!');
            //throw $th;
        }
        return redirect()->back()->with('success', 'Berhasil menghapus data produk!');
    }
}
