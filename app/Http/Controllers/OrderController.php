<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Order::with('items')
                ->orderBy('created_at', 'desc')
                ->paginate(15),
            'message' => 'Pedidos obtenidos exitosamente'
        ]);
    }

    public function show($id)
    {
        $order = Order::with('items')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'required|string|regex:/^[0-9\-\+\(\)\s]+$/',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.note' => 'nullable|string',
            'total_usd' => 'required|numeric|min:0',
            'total_bs' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'whatsapp_message' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'customer_name' => $validated['customer_name'] ?? 'Cliente',
                'customer_phone' => $validated['customer_phone'],
                'total_usd' => $validated['total_usd'],
                'total_bs' => $validated['total_bs'] ?? 0,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? '',
                'whatsapp_message' => $validated['whatsapp_message'] ?? '',
            ]);

            foreach ($validated['items'] as $item) {
                $order->items()->attach($item['id'], [
                    'quantity' => $item['quantity'],
                    'note' => $item['note'] ?? '',
                    'subtotal' => $item['quantity'] * 0, // Se calculará desde frontend
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $order->load('items'),
                'message' => 'Pedido creado exitosamente',
                'order_id' => $order->id
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear pedido: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,completed,cancelled',
        ]);

        $order->update($validated);

        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'Estado del pedido actualizado'
        ]);
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        $order->items()->detach();
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pedido eliminado exitosamente'
        ]);
    }

    public function statistics()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_usd');
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $pendingOrders = Order::where('status', 'pending')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_orders' => $totalOrders,
                'total_revenue_usd' => round($totalRevenue, 2),
                'average_order_value' => round($avgOrderValue, 2),
                'pending_orders' => $pendingOrders,
                'completed_orders' => Order::where('status', 'completed')->count(),
            ]
        ]);
    }
}
