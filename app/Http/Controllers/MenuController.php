<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // نجلب المنيو كامل مع الوجبات عشان الزبون او الويتر يشوفو
        $menu = \App\Models\Category::with('menuItems')->get();
        return response()->json($menu, 200);
    }
}
