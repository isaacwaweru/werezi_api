<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Seller;
use App\Models\Category;
use App\Models\Order;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'books' => Book::count(),
            'authors' => Author::count(),
            'categories' => Category::count(),
            'sellers' => Seller::count(),
            'orders' => Order::whereDate('created_at', now())->count(),
            'orders_total' => Order::whereDate('created_at', now())->sum('amount')
        ];

        return view('admin.dashboard')->with([
            'stats' => $stats,
            'current_orders' => Order::where('status', 'pending')->get()
        ]);
    }
}
