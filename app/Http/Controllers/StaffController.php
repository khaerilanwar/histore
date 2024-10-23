<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StaffController extends Controller
{
    protected $userModel;
    protected $shopModel;
    protected $staffModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->shopModel = new Shop();
        $this->staffModel = new Staff();
    }

    public function index(Request $request): View
    {
        $limit = $request->query('limit', 5);
        $search = $request->query('s');

        $data = [
            'users' => $this->userModel->userActive($search)->orderBy('nik')->paginate($limit),
            'limit' => $limit
        ];

        return view('admin.staff', $data);
    }

    public function add(Request $request)
    {
        $data = [
            'shops' => $this->shopModel->all()
        ];

        return view('admin.staff-add', $data);
    }

    public function storeStaff(Request $request)
    {
        $newStaff = $request->validate(
            [
                'nik' => 'required|string|digits:16|numeric|unique:staff,nik',
                'name' => 'required|min:4',
                'ttl' => 'required|min:12',
                'email' => 'required|email:rfc,dns|unique:staff,email',
                'no_hp' => 'required|starts_with:08|numeric|unique:staff,no_hp',
                'alamat' => 'required|min:15',
                'salary' => 'required',
                'shop_id' => 'required'
            ]
        );

        // Jika validasi lolos semua

        // Melakukan filtering data
        // Mendapatkan id toko
        $shop_id = array_pop($newStaff);

        // Mengubah format salary ke integer
        $newStaff['salary'] = str($newStaff['salary'])->replace(['Rp. ', '.'], '')->value();

        DB::beginTransaction();
        try {
            // Menambahkan data ke tabel staff
            $this->staffModel->create($newStaff);

            // Menambahkan data ke tabel users
            $this->userModel->create(
                [
                    'nik' => date('y') . date('m') . str_pad(rand(1, 2000), 4, '0', STR_PAD_LEFT),
                    'password' => Hash::make("hi-store123"),
                    'role' => 2,
                    'shop_id' => $shop_id,
                    'nik_ktp' => $newStaff['nik'],
                    'status' => 'active',
                ]
            );

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan staff baru !');
        }

        return redirect()->to('/admin/staff')->with('success', 'Berhasil menambahkan staff !');
    }

    public function biodata(Request $request, User $user): View
    {
        $data = [
            'user' => $user
        ];

        return view('admin.staff-biodata', $data);
    }

    public function mutasi(Request $request, User $user): View
    {
        $data = [
            'user' => $user,
            'shops' => $this->shopModel->all()
        ];

        return view('admin.staff-mutasi', $data);
    }

    public function mutasiPatch(Request $request, User $user)
    {
        if (!$user) {
            abort(404);
        }

        // Mengecek jika toko sekarang sama dengan toko mutasi
        $shop_id = $request->post('shop_id');
        if ($shop_id == $user->shop_id) {
            return back()->with('error', 'Toko tujuan tidak boleh sama dengan toko lama!');
        }

        // Jika sudah sesuai, maka merubah data pada database
        DB::beginTransaction();
        try {
            // Mengganti status user menjadi inactive pada tabel users
            $user->status = 'inactive';
            $user->save();

            // Membuat user baru dengan nik baru
            $this->userModel->create(
                [
                    'nik' => date('y') . date('m') . str_pad(rand(1, 2000), 4, '0', STR_PAD_LEFT),
                    'password' => Hash::make("hi-store123"),
                    'role' => 2,
                    'shop_id' => $shop_id,
                    'nik_ktp' => $user->nik_ktp,
                    'status' => 'active',
                ]
            );

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('error', 'Gagal melakukan mutasi staff!');
        }

        return redirect()->to('/admin/staff')->with('success', 'Berhasil melakukan mutasi staff !');
    }

    public function resign(Request $request, User $user)
    {
        if (!$user) {
            abort(404);
        }

        // Mengganti status user menjadi inactive
        try {
            $user->status = 'inactive';
            $user->save();
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Gagal resign staff !');
        }

        return back()->with('success', 'Staff berhasil melakukan resign!');
    }
}
