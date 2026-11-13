<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('is_admin', false)
            ->withCount(['bookings' => function ($query) {
                $query->where('is_admin', false);
            }])
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        $bookings = Booking::where('customer_email', $customer->email)
            ->with(['schedule.film', 'seats'])
            ->latest()
            ->paginate(10);

        return view('admin.customers.show', compact('customer', 'bookings'));
    }

    public function toggleStatus(User $customer)
    {
        if ($customer->is_admin) {
            return back()->with('error', 'Tidak dapat mengubah status admin.');
        }

        $customer->update([
            'is_active' => !$customer->is_active
        ]);

        $status = $customer->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', 'Akun pelanggan telah ' . $status . '.');
    }
}