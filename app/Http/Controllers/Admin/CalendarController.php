<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(15);
        $upcomingEvents = Event::upcoming()->take(5)->get();
        return view('admin.calendar.index', compact('events', 'upcomingEvents'));
    }

    public function create()
    {
        return view('admin.calendar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:event_date',
            'category' => 'nullable|string|max:50',
            'is_all_day' => 'boolean',
            'color' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
        ]);

        $validated['is_all_day'] = $request->has('is_all_day');

        Event::create($validated);

        return redirect()->route('admin.calendar.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit(Event $calendar)
    {
        return view('admin.calendar.edit', ['event' => $calendar]);
    }

    public function update(Request $request, Event $calendar)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:event_date',
            'category' => 'nullable|string|max:50',
            'is_all_day' => 'boolean',
            'color' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
        ]);

        $validated['is_all_day'] = $request->has('is_all_day');

        $calendar->update($validated);

        return redirect()->route('admin.calendar.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $calendar)
    {
        $calendar->delete();
        return redirect()->route('admin.calendar.index')->with('success', 'Event berhasil dihapus.');
    }
}
