<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Список всіх замовлень
    public function index()
    {
        $orders = Order::with(['items.product'])->orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    }

    // Оновлення статусу замовлення
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,completed,canceled',
        ]);

        $order->status = $validated['status'];
        $order->save();

        return response()->json(['message' => 'Order status updated.']);
    }

    // Видалення замовлення (опційно)
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted.']);
    }
}


