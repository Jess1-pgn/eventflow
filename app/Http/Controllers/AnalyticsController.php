<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TicketType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        abort_unless(Auth::check() && Auth::user()->hasAnyRole(['organizer', 'super-admin']), 403);

        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $eventIds = Event::query()
            ->when(! $isSuperAdmin, fn (Builder $query): Builder => $query->where('organizer_id', Auth::id()))
            ->pluck('id');

        $eventsCount = $eventIds->count();

        $paidOrders = Order::query()
            ->whereIn('event_id', $eventIds)
            ->where('status', Order::STATUS_PAID);

        $paidOrderIds = $paidOrders->pluck('id');

        $revenueAmount = (int) Order::query()
            ->whereIn('id', $paidOrderIds)
            ->sum('total_amount');

        $ticketsSold = (int) OrderItem::query()
            ->whereIn('order_id', $paidOrderIds)
            ->sum('qty');

        $ticketCapacity = (int) TicketType::query()->whereIn('event_id', $eventIds)->sum('max_per_order');

        $events = Event::query()
            ->withSum('ticketTypes as ticket_capacity_sum', 'max_per_order')
            ->whereIn('id', $eventIds)
            ->latest('starts_at')
            ->take(10)
            ->get();

        return view('dashboard.analytics.index', [
            'isSuperAdmin' => $isSuperAdmin,
            'eventsCount' => $eventsCount,
            'ticketsSold' => $ticketsSold,
            'ticketCapacity' => $ticketCapacity,
            'revenueAmount' => $revenueAmount,
            'events' => $events,
        ]);
    }
}
