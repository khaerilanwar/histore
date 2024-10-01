<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\UniquePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function cashierProfile()
    {
        $data = [
            'user' => Auth::user()
        ];
        return view('cashier.profile', $data);
    }

    public function changePasswordCashier(Request $request)
    {
        $validated = $request->validate(
            [
                'oldpassword' => ['required', 'current_password'],
                'newpassword' => ['required', 'confirmed', new UniquePassword],
                'newpassword_confirmation' => ['required']
            ]
        );

        // Mengubah password lama di database
        $user = $this->userModel->find(Auth::user()->id);
        $user->password = Hash::make($validated['newpassword']);
        $user->save();

        // Melakukan redirect
        return redirect()->back()->with('success', 'Berhasil ganti kata sandi!');
    }
}
