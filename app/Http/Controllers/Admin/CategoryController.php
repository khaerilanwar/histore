<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function index(Request $request)
    {
        $search = $request->query('s');
        $limit = $request->query('limit', 5);
        $categories = $this->categoryModel->categorySearch($search)->paginate($limit);
        $data = [
            'categories' => $categories,
            'limit' => $limit
        ];

        return view('admin.categories', $data);
    }

    public function storeCategory(Request $request)
    {
        // Mengecek apakah nama produk sudah ada di database
        $category = $this->categoryModel->getCategoryBySlug(Str::slug($request->post('name')));
        if ($category) {
            return back()->with('error', 'Nama kategori sudah terdaftar!');
        }

        $newCategory = $request->validate(
            [
                'name' => 'required|min:3',
                'slogan' => 'required|min:6',
                'image' => 'image|mimes:png,jpg,jpeg|file|max:1024'
            ]
        );

        // Mengecek apakah gambar di update
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Menyimpan file gambar baru
            $image = $request->file('image');
            $imageName = 'category_' . Str::random(4) . '.' . $image->extension();
            $newCategory['image'] = $imageName;
            $image->storeAs('public/images', $imageName);

            // Menyimpan gambar thumbnail
            $manager = new ImageManager(new Driver);
            $imageResize = $manager->read($image->getRealPath())->resize(400, 400);
            $imageResize->save(public_path('storage/thumbnail/' . $imageName));
        } else {
            // Menambahkan gambar default ke kategori
            $newCategory['image'] = "default.jpg";
        }

        // Menambahkan data slug
        $newCategory['slug'] = Str::slug($newCategory['name']);

        // Menyimpan data kategori baru ke database
        $this->categoryModel->create($newCategory);

        return back()->with('success', 'Berhasil menambahkan kategori baru!');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $categoryUpdate = $request->validate(
            [
                'slogan' => 'required|min:6',
                'image' => 'image|mimes:png,jpg,jpeg|file|max:1024'
            ]
        );

        // Mengecek apakah gambar di update
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Menghapus file gambar lama
            Storage::delete('public/images/' . $category->image);
            // Menyimpan file gambar baru
            $image = $request->file('image');
            $imageName = 'category_' . Str::random(4) . '.' . $image->extension();
            $categoryUpdate['image'] = $imageName;
            $image->storeAs('public/images', $imageName);
        }

        // Mengubah data update category
        $category->update($categoryUpdate);

        return redirect()->back()->with('success', 'Berhasil perbarui data kategori!');
    }

    public function removeCategory(Request $request, Category $category)
    {
        // Mengecek apakah ada produk yang memiliki kategori ini
        if ($category->products->count() >= 1) {
            return back()->with('error', 'Kategori masih memiliki produk!');
        }

        // Menghapus gambar kategori
        if ($category->image !== "default.jpg") {
            Storage::delete('public/images/' . $category->image);
            Storage::delete('public/thumbnail/' . $category->image);
        }

        // Menghapus data kategori 
        $category->delete();
        return back()->with('success', 'Berhasil hapus kategori produk!');
    }
}
