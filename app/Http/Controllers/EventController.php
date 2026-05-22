<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Category;
use App\Models\Event;
use App\Models\Tag;
use App\Models\Venue;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Event::class, 'event');
    }

    public function index(): View
    {
        $eventsQuery = Event::query()->with(['categories', 'tags'])->latest('starts_at');

        if (! Auth::user()->hasRole('super-admin')) {
            $eventsQuery->where('organizer_id', Auth::id());
        }

        return view('events.index', [
            'events' => $eventsQuery->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('events.create', [
            'timezones' => timezone_identifiers_list(),
            'statuses' => Event::STATUSES,
            'venues' => Venue::query()->orderBy('name')->get(),
            'categories' => Category::query()->orderBy('name')->get(),
            'tags' => Tag::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $event = Event::create($this->normalizeData($validated) + [
            'organizer_id' => Auth::id(),
        ]);

        $event->categories()->sync($validated['category_ids'] ?? []);
        $event->tags()->sync($validated['tag_ids'] ?? []);

        return redirect()
            ->route('dashboard.events.edit', $event)
            ->with('status', 'Event created successfully.');
    }

    public function edit(Event $event): View
    {
        $event->load(['categories:id', 'tags:id']);

        return view('events.edit', [
            'event' => $event,
            'timezones' => timezone_identifiers_list(),
            'statuses' => Event::STATUSES,
            'venues' => Venue::query()->orderBy('name')->get(),
            'categories' => Category::query()->orderBy('name')->get(),
            'tags' => Tag::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $validated = $request->validated();

        $event->update($this->normalizeData($validated));
        $event->categories()->sync($validated['category_ids'] ?? []);
        $event->tags()->sync($validated['tag_ids'] ?? []);

        return redirect()
            ->route('dashboard.events.edit', $event)
            ->with('status', 'Event updated successfully.');
    }

    public function duplicate(Event $event): RedirectResponse
    {
        $this->authorize('create', Event::class);

        $duplicate = $event->replicate(['seo_slug', 'status']);
        $duplicate->title = $event->title.' (Copy)';
        $duplicate->seo_slug = Event::buildUniqueSlug($duplicate->title);
        $duplicate->status = Event::STATUS_DRAFT;
        $duplicate->organizer_id = Auth::id();
        $duplicate->save();

        $duplicate->categories()->sync($event->categories()->pluck('categories.id'));
        $duplicate->tags()->sync($event->tags()->pluck('tags.id'));

        return redirect()
            ->route('dashboard.events.edit', $duplicate)
            ->with('status', 'Event duplicated successfully.');
    }

    public function archive(Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $event->update([
            'status' => Event::STATUS_ARCHIVED,
        ]);

        return redirect()
            ->route('dashboard.events.index')
            ->with('status', 'Event archived successfully.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);
        $event->delete();

        return redirect()
            ->route('dashboard.events.index')
            ->with('status', 'Event deleted successfully.');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalizeData(array $data): array
    {
        $timezone = (string) $data['timezone'];

        $data['starts_at'] = CarbonImmutable::parse((string) $data['starts_at'], $timezone);
        $data['ends_at'] = CarbonImmutable::parse((string) $data['ends_at'], $timezone);

        return $data;
    }
}
