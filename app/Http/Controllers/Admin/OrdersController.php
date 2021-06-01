<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\SoldItem;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */

    public function index(Request $request)
    {
        if ($request->filled('clean')) {
            return $this->cleanOrders();
        }

        $orders = Order::query()
            ->with('items')
            ->where('orders.created_at', '>=', now()->subMonths(3))
            ->leftJoin('users as u', 'u.id', '=', 'orders.user_id')

            // Order by
            ->when($request->filled('order'), function (Builder $query) use ($request) {
                $direction = ($request->direction == 'asc') ? 'ASC' : 'DESC';
                if ($request->order == 'amount') {
                    $query->orderBy('orders.amount', $direction);
                }
                if ($request->order == 'status') {
                    $query->orderBy("orders.status", $direction);
                }
                if ($request->order == 'customer') {
                    $query->orderBy("u.name", $direction);
                }
                if ($request->order == 'date') {
                    $query->orderBy("orders.created_at", $direction);
                }
            }, function (Builder $query) {
                $query->latest('orders.created_at');
            })

            // Filter by status
            ->when($request->filled('status'), function (Builder $query) use ($request) {
                $query->where("orders.status", $request->status);
            })
            ->select('orders.*', 'u.name', 'u.phone_number')
            ->paginate($request->show ?? 50);

        if ($request->filled('csv')) {
            return $this->convertOrdersToExcel($orders);
        }

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);

        return view('admin.orders.show')->with([
            'order' => $order
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status == 'pending') {
            $request->validate([
                'status' => 'required'
            ]);

            if ($request->status == 'confirmed') {
                $order->update([
                    'status' => $request->status
                ]);

                // notify supplier
            } else if ($request->status == 'cancelled') {
                $order->update([
                    'status' => $request->status
                ]);

                // notify customer
            }
        } else if ($order->status == 'confirmed') {
            collect($order->items)->each(function ($item) {
                SoldItem::create([
                    'order_item_id' => $item->id,
                    'status' => 'sold'
                ]);
            });

            $order->update([
                'status' => 'packaged'
            ]);
        } else if ($order->status == 'packaged') {
            $order->update([
                'status' => 'shipped'
            ]);

        } else if ($order->status == 'shipped') {
            $order->update([
                'status' => 'complete'
            ]);
        }

        return redirect()->back();
    }

    public function invoice($id)
    {
        $order = Order::findOrFail($id);

        return view('mails.html.orders.invoice', ['order' => $order]);
    }

    public function shippingList($id)
    {
        $order = Order::findOrFail($id);

        return view('mails.html.orders.shipping-list', ['order' => $order]);
    }
}
