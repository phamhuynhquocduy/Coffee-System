<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class DashboardController extends Controller
{
    //dashboard
    public function dashboard(){
        $category = Category::all();
        $product = Product::all();
        return view('page.dashboard', compact(['category', 'product']));
    }
}
