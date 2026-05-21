<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Table;

class TableController extends Controller
{
    
    public function index()
    {
        return response()->json(Table::all(), 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:available,occupied,reserved']);
        $table = Table::findOrFail($id); 
        $table->update(['status' => $request->status]);
        
        return response()->json(['message' => 'تم تحديث حالة الطاولة', 'table' => $table]);
    }

    public function assignWaiter(Request $request, $id)
    {
        $request->validate(['waiter_id' => 'required|exists:users,id']);
        
        $table = Table::findOrFail($id);
        $table->update(['waiter_id' => $request->waiter_id]); 

        return response()->json(['message' => 'تم تعيين الويتر للطاولة بنجاح', 'table' => $table]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|integer|unique:tables',
            'capacity' => 'required|integer|min:1',
        ]);

        $table = Table::create([
            'table_number' => $request->table_number,
            'capacity' => $request->capacity,
            'status' => 'available' 
        ]);

        return response()->json(['message' => 'تم إضافة الطاولة بنجاح', 'table' => $table], 201);
    }

    public function show($id)
    {
        $table = Table::findOrFail($id);
        return response()->json($table, 200);
    }

    public function update(Request $request, $id)
    {
        $table = Table::findOrFail($id);

        $request->validate([
            'table_number' => 'sometimes|integer|unique:tables,table_number,' . $id,
            'capacity' => 'sometimes|integer|min:1',
        ]);

        $table->update($request->all());

        return response()->json(['message' => 'تم تعديل الطاولة بنجاح', 'table' => $table], 200);
    }

    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        
        try {
            $table->delete();
            return response()->json(['message' => 'تم حذف الطاولة بنجاح'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'عفواً، لا يمكن حذف هذه الطاولة لارتباطها بطلبات أو فواتير سابقة مخصصة لها'], 400);
        }
    }
}