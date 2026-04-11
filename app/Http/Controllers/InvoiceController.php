<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Table;

class InvoiceController extends Controller
{
    public function generateInvoice($orderId)
    {
        $order = Order::with(['items.menuItem', 'table'])->findOrFail($orderId);
        return response()->json(['invoice_details' => $order]);
    }

    public function processPayment(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        
        if (!$order || $order->status === 'paid') {
            return response()->json(['message' => 'الطلب غير موجود أو مدفوع مسبقاً'], 400);
        }

        if ($order->total_amount <= 0) {
            return response()->json(['message' => 'عذراً، لا يمكن دفع أو إغلاق طلب فارغ (المبلغ 0)'], 400);
        }

        $invoice = Invoice::create([
            'order_id' => $order->id,
            'cashier_id' => auth()->id(), 
            'total_amount' => $order->total_amount,
            'payment_method' => $request->payment_method ?? 'cash', 
            'payment_status' => 'paid'
        ]);

        $order->update(['status' => 'paid']);
        
        Table::where('id', $order->table_id)->update(['status' => 'available']);

        return response()->json([
            'message' => 'تم الدفع بنجاح وإصدار الفاتورة، والطاولة أصبحت متاحة',
            'invoice' => $invoice
        ], 201);
    }
}