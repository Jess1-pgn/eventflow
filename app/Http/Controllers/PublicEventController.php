<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicEventController extends Controller
{
    public function index(Request $request): View
    {
        $likedEventIds = [];

        if (auth()->check() && auth()->user()->hasRole('attendee')) {
            $likedEventIds = auth()->user()->likedEvents()->pluck('events.id')->all();
        }

        $events = Event::query()
            ->where('status', Event::STATUS_PUBLISHED)
            ->with(['venue', 'categories', 'ticketTypes'])
            ->when($request->string('q')->isNotEmpty(), function (Builder $query) use ($request): void {
                $search = '%'.$request->string('q')->value().'%';
                $query->where(fn (Builder $nested): Builder => $nested
                    ->where('title', 'like', $search)
                    ->orWhere('description_html', 'like', $search));
            })
            ->when($request->filled('category'), fn (Builder $query): Builder => $query->whereHas('categories', fn (Builder $q): Builder => $q->where('slug', $request->string('category')->value())))
            ->when($request->filled('city'), fn (Builder $query): Builder => $query->whereHas('venue', fn (Builder $q): Builder => $q->where('city', 'like', '%'.$request->string('city')->value().'%')))
            ->when($request->filled('date_from'), fn (Builder $query): Builder => $query->whereDate('starts_at', '>=', $request->string('date_from')->value()))
            ->when($request->filled('date_to'), fn (Builder $query): Builder => $query->whereDate('starts_at', '<=', $request->string('date_to')->value()))
            ->latest('starts_at')
            ->paginate(12)
            ->withQueryString();

        return view('public.events.index', [
            'events' => $events,
            'categories' => Category::query()->orderBy('name')->get(),
            'likedEventIds' => $likedEventIds,
        ]);
    }

    public function show(Event $event): View
    {
        if ($event->status !== Event::STATUS_PUBLISHED) {
            $canPreviewUnpublished = auth()->check() && (
                auth()->user()->hasRole('super-admin') ||
                $event->organizer_id === auth()->id()
            );

            abort_unless($canPreviewUnpublished, 404);
        }

        $event->load(['venue', 'categories', 'tags', 'ticketTypes', 'organizer']);

        return view('public.events.show', [
            'event' => $event,
        ]);
    }
}
