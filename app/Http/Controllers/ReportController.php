<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function financial()
    {
        $totalRevenue = Invoice::where('payment_status', 'paid')->sum('total_amount');

        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'paid')->count();
        $activeOrders = Order::whereNotIn('status', ['paid', 'cancelled'])->count();
        $paidInvoicesCount = Invoice::where('payment_status', 'paid')->count();

        $topSellingItems = DB::table('order_items')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select('menu_items.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('menu_items.name')
            ->orderByDesc('total_sold')
            ->limit(5) 
            ->get();

        return response()->json([
            'message' => 'تقرير الأداء المالي',
            'data' => [
                'total_revenue' => $totalRevenue,
                'total_orders' => $totalOrders,
                'paid_invoices_count' => $paidInvoicesCount,
                'completed_orders' => $completedOrders,
                'active_orders' => $activeOrders,
                'top_selling_items' => $topSellingItems
            ]
        ], 200);
    }
}