<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MemberController extends Controller
{
    protected $memberModel;

    public function __construct()
    {
        $this->memberModel = new Member();
    }

    public function index(Request $request): View
    {
        $search = $request->query('s');
        $member = $this->memberModel->getMemberBy('no_hp', $search);
        $data = [
            'member' => $member
        ];
        return view('cashier.member', $data);
    }

    public function store(Request $request): RedirectResponse
    {
        $validateMember = $request->validate([
            'name' => 'required|min:3|alpha',
            'no_hp' => 'required|min:11|numeric|unique:members,no_hp',
            'gender' => 'required|in:male,female'
        ]);

        // Menyimpan data member baru ke database
        $validateMember['point'] = 0;
        $this->memberModel->create($validateMember);

        return redirect()->back()->with('success', 'Berhasil menambahkan member baru!');
    }
}
