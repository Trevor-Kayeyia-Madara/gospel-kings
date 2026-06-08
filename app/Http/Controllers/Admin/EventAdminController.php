<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.events.index', [
            'events' => Event::orderBy('starts_at')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.events.create', [
            'categories' => EventCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'event_category_id' => ['nullable', 'exists:event_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'edition' => ['nullable', 'string', 'max:255'],
            'theme' => ['nullable', 'string', 'max:255'],
            'summary' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'venue' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'is_paid' => ['nullable', 'boolean'],
            'registration_open' => ['nullable', 'boolean'],
            'base_price' => ['nullable', 'numeric', 'min:0'],
            'banner_image' => ['nullable', 'string', 'max:500'],
            'schedule_time' => ['nullable', 'array'],
            'schedule_item' => ['nullable', 'array'],
        ]);

        $data['slug'] = Str::slug($data['title'].' '.($data['edition'] ?? ''));
        $data['is_paid'] = $request->boolean('is_paid');
        $data['registration_open'] = $request->boolean('registration_open', true);
        $data['base_price'] = $data['base_price'] ?? 0;
        $data['schedule'] = $this->normalizeSchedule($request);

        $event = Event::create($data);

        return redirect()->route('events.show', $event)->with('status', 'Event created.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', [
            'event' => $event,
            'categories' => EventCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $data = $request->validate([
            'event_category_id' => ['nullable', 'exists:event_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'edition' => ['nullable', 'string', 'max:255'],
            'theme' => ['nullable', 'string', 'max:255'],
            'summary' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'venue' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'is_paid' => ['nullable', 'boolean'],
            'registration_open' => ['nullable', 'boolean'],
            'base_price' => ['nullable', 'numeric', 'min:0'],
            'banner_image' => ['nullable', 'string', 'max:500'],
            'schedule_time' => ['nullable', 'array'],
            'schedule_item' => ['nullable', 'array'],
        ]);

        $data['slug'] = Str::slug($data['title'].' '.($data['edition'] ?? ''));
        $data['is_paid'] = $request->boolean('is_paid');
        $data['registration_open'] = $request->boolean('registration_open', true);
        $data['base_price'] = $data['base_price'] ?? 0;
        $data['schedule'] = $this->normalizeSchedule($request);

        $event->update($data);

        return redirect()->route('events.show', $event)->with('status', 'Event updated.');
    }

    private function normalizeSchedule(Request $request): ?array
    {
        $times = $request->input('schedule_time', []);
        $items = $request->input('schedule_item', []);

        if (empty($times) && empty($items)) {
            return null;
        }

        $schedule = [];
        $count = max(count($times), count($items));

        for ($i = 0; $i < $count; $i++) {
            $time = $times[$i] ?? null;
            $item = $items[$i] ?? null;

            if (!$time && !$item) {
                continue;
            }

            $schedule[] = [
                'time' => $time ?: '',
                'item' => $item ?: '',
            ];
        }

        return $schedule;
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('admin.dashboard')->with('status', 'Event deleted.');
    }
}
