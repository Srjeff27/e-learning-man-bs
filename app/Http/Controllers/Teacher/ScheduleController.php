<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Show schedules for a classroom.
     */
    public function index(Classroom $classroom)
    {
        $this->authorize('view', $classroom);

        $schedules = $classroom->schedules()
            ->active()
            ->orderByRaw("FIELD(day, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu')")
            ->orderBy('start_time')
            ->get()
            ->groupBy('day');

        return view('teacher.schedules.index', compact('classroom', 'schedules'));
    }

    /**
     * Show form to create a new schedule.
     */
    public function create(Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $days = Schedule::DAYS;

        return view('teacher.schedules.create', compact('classroom', 'days'));
    }

    /**
     * Store a new schedule.
     */
    public function store(Classroom $classroom, Request $request)
    {
        $this->authorize('update', $classroom);

        $validated = $request->validate([
            'day' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        $classroom->schedules()->create($validated);

        return redirect()
            ->route('teacher.schedules.index', $classroom)
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Show form to edit a schedule.
     */
    public function edit(Classroom $classroom, Schedule $schedule)
    {
        $this->authorize('update', $classroom);

        $days = Schedule::DAYS;

        return view('teacher.schedules.edit', compact('classroom', 'schedule', 'days'));
    }

    /**
     * Update a schedule.
     */
    public function update(Classroom $classroom, Schedule $schedule, Request $request)
    {
        $this->authorize('update', $classroom);

        $validated = $request->validate([
            'day' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        $schedule->update($validated);

        return redirect()
            ->route('teacher.schedules.index', $classroom)
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Delete a schedule.
     */
    public function destroy(Classroom $classroom, Schedule $schedule)
    {
        $this->authorize('update', $classroom);

        $schedule->delete();

        return redirect()
            ->route('teacher.schedules.index', $classroom)
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
