<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        return response()->json(MenuItem::with('category')->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'is_available' => 'boolean'
        ]);

        $menuItem = MenuItem::create($request->all());
        return response()->json(['message' => 'تم إضافة الوجبة بنجاح', 'item' => $menuItem], 201);
    }

    public function show($id)
    {
        $menuItem = MenuItem::with('category')->find($id);
        if (!$menuItem) return response()->json(['message' => 'الوجبة غير موجودة'], 404);
        return response()->json($menuItem, 200);
    }

    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::find($id);
        if (!$menuItem) return response()->json(['message' => 'الوجبة غير موجودة'], 404);

        $menuItem->update($request->all());
        return response()->json(['message' => 'تم تعديل الوجبة', 'item' => $menuItem], 200);
    }

    public function destroy($id)
    {
        $menuItem = MenuItem::find($id);
        if (!$menuItem) return response()->json(['message' => 'الوجبة غير موجودة'], 404);

        try {
            $menuItem->delete();
            return response()->json(['message' => 'تم حذف الوجبة بنجاح'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'لا يمكن حذف هذه الوجبة حيث أنها مرتبطة بطلبات تم إجراؤها من قبل'], 400);
        }
    }

    public function updatePrice(Request $request, $id)
    {
        $request->validate(['price' => 'required|numeric|min:0']);
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update(['price' => $request->price]);
        return response()->json(['message' => 'تم تحديث السعر', 'item' => $menuItem]);
    }

    public function changeAvailability(Request $request, $id)
    {
        $request->validate(['is_available' => 'required|boolean']);
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update(['is_available' => $request->is_available]);
        return response()->json(['message' => 'تم تحديث حالة التوفر', 'item' => $menuItem]);
    }
}