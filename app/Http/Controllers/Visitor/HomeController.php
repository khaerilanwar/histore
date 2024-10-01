<?php

namespace App\Http\Controllers\Visitor;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(): View
    {
        $data = [
            'categories' => Category::all()
        ];

        return view('visitor.index', $data);
    }
}
