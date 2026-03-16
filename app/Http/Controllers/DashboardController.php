<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->hasRole('attendee') && ! $request->boolean('from_events')) {
            return redirect()
                ->route('public.events.index')
                ->with('dashboard_gate_message', 'Explore events first, then use the button to access your dashboard.');
        }

        $likedEvents = collect();
        $paidEvents = collect();

        if ($user->hasRole('attendee')) {
            $likedEvents = $user->likedEvents()
                ->latest('events.starts_at')
                ->take(10)
                ->get();

            $paidEvents = Order::query()
                ->with('event')
                ->where('buyer_user_id', $user->id)
                ->where('status', Order::STATUS_PAID)
                ->latest()
                ->get()
                ->pluck('event')
                ->filter()
                ->unique('id')
                ->values();
        }

        return view('dashboard', [
            'likedEvents' => $likedEvents,
            'paidEvents' => $paidEvents,
        ]);
    }
}
