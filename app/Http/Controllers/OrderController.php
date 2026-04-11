<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\Table;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['table_id' => 'required|exists:tables,id']);

        $table = Table::findOrFail($request->table_id);
        if ($table->status !== 'available') {
            return response()->json(['message' => 'عذراً، هذه الطاولة غير متاحة (محجوزة أو مشغولة)'], 400);
        }

        try {
            $order = DB::transaction(function () use ($request) {
                $newOrder = Order::create([
                    'table_id' => $request->table_id,
                    'waiter_id' => auth()->id(), 
                    'status' => 'pending',
                    'special_requests' => $request->special_requests ?? null,
                    'total_amount' => 0, 
                ]);
                Table::where('id', $request->table_id)->update(['status' => 'occupied']);
                return $newOrder;
            });

            return response()->json(['message' => 'تم فتح الطلب بنجاح', 'order_id' => $order->id], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'حدث خطأ.', 'error' => $e->getMessage()], 500);
        }
    }

    public function addItem(Request $request, $order_id)
    {
        $request->validate([
            'items' => 'required|array', 
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($order_id);
        if ($order->status === 'paid' || $order->status === 'cancelled') {
            return response()->json(['message' => 'عذراً، لا يمكن التعديل على طلب مدفوع أو ملغي'], 403);
        }

        try {
            DB::transaction(function () use ($request, $order) {
                foreach ($request->items as $requestedItem) {
                    $menuItem = MenuItem::find($requestedItem['menu_item_id']);
                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_item_id' => $menuItem->id,
                        'quantity' => $requestedItem['quantity'],
                        'item_price' => $menuItem->price,
                    ]);
                }
                $this->calculateTotal($order->id);
            });

            return response()->json(['message' => 'تم إضافة الأصناف', 'order' => $order->fresh()], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'حدث خطأ.', 'error' => $e->getMessage()], 500);
        }
    }

    public function removeItem($order_id, $item_id)
    {
        $order = Order::findOrFail($order_id);
        if ($order->status === 'paid' || $order->status === 'cancelled') {
            return response()->json(['message' => 'عذراً، لا يمكن الحذف من طلب مدفوع أو ملغي'], 403);
        }

        try {
            DB::transaction(function () use ($order_id, $item_id) {
                $orderItem = OrderItem::where('order_id', $order_id)->where('id', $item_id)->firstOrFail();
                $orderItem->delete();
                $this->calculateTotal($order_id);
            });

            return response()->json(['message' => 'تم إزالة الصنف وتحديث الفاتورة', 'order' => $order->fresh()], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'حدث خطأ.', 'error' => $e->getMessage()], 500);
        }
    }

    private function calculateTotal($orderId)
    {
        $total = OrderItem::where('order_id', $orderId)
            ->selectRaw('SUM(quantity * item_price) as total')
            ->value('total');

        Order::where('id', $orderId)->update(['total_amount' => $total ?? 0]);
    }

    public function unpaidOrders()
    {
        $orders = Order::with(['table', 'items.menuItem'])->whereIn('status', ['ready', 'served'])->get();
        return response()->json($orders);
    }
    
    public function waiterOrders()
    {
        $orders = Order::with(['table', 'items.menuItem'])
                        ->where('waiter_id', auth()->id())
                        ->whereNotIn('status', ['paid', 'cancelled'])
                        ->get();
        return response()->json($orders);
    }

    public function serveOrder($id)
    {
        $order = Order::findOrFail($id);
        
        if ($order->status === 'paid' || $order->status === 'cancelled') {
            return response()->json(['message' => 'عذراً، لا يمكن تغيير حالة هذا الطلب'], 400);
        }

        $order->update(['status' => 'served']);
        
        return response()->json([
            'message' => 'تم تقديم الطلب للزبون بنجاح!',
            'order' => $order
        ], 200);
    }
}