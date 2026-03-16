<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FavoriteEventController extends Controller
{
    public function store(Request $request, Event $event): RedirectResponse
    {
        $request->user()->likedEvents()->syncWithoutDetaching([$event->id]);

        return back()->with('status', 'Event added to favorites.');
    }

    public function destroy(Request $request, Event $event): RedirectResponse
    {
        $request->user()->likedEvents()->detach($event->id);

        return back()->with('status', 'Event removed from favorites.');
    }
}
