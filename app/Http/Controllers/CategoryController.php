<?php

namespace App\Http\Controllers;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json(CategoryResource::collection($categories), 200);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return response()->json(['message' => 'تم إضافة القسم بنجاح', 'category' => $category], 201);
    }

    public function show($id)
    {
        $category = Category::with('menuItems')->find($id);
        if (!$category) return response()->json(['message' => 'القسم غير موجود'], 404);
        return response()->json(new CategoryResource($category), 200);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'القسم غير موجود'], 404);
        
        $category->update($request->all());
        return response()->json(['message' => 'تم التعديل بنجاح', 'category' => $category], 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'القسم غير موجود'], 404);

        try {
            $category->delete();
            return response()->json(['message' => 'تم حذف القسم'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'لا يمكن حذف هذا القسم لأنه يحتوي على وجبات'], 400);
        }
    }
}