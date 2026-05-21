<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class KitchenController extends Controller
{
    public function activeOrders()
    {
        $orders = Order::with(['table', 'items.menuItem'])
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->get();
            
        return response()->json($orders);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:preparing,ready'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'تم تحديث حالة الطلب بنجاح', 
            'order' => $order
        ], 200);
    }
}