<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticationController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index(Request $request): View
    {
        $data = [];
        return view('authentication.login', $data);
    }

    public function login(Request $request)
    {
        // Mendapatkan data yang dikirim dengan method post
        $nik = $request->post('nik');

        $validated = $request->validate(
            [
                'nik' => 'required',
                'password' => 'required'
            ]
        );

        if (Auth::attempt($validated)) {
            $role_id = $this->userModel->getUser('nik', $nik)->role;
            $request->session()->regenerate();

            return $role_id == 2 ? redirect()->intended('cashier') : redirect()->intended('admin');
        }

        return back()->with('error', 'Gagal melakukan login')->withInput();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
