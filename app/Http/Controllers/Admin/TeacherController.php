<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Services\ImageOptimizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    protected ImageOptimizationService $imageService;

    public function __construct(ImageOptimizationService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of teachers.
     */
    public function index(Request $request)
    {
        $query = Teacher::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('subject_specialty', 'like', "%{$search}%");
            });
        }

        // Filter by subject
        if ($request->filled('subject')) {
            $query->where('subject_specialty', $request->subject);
        }

        $teachers = $query->latest()->paginate(12);
        $subjects = Teacher::whereNotNull('subject_specialty')
            ->distinct()
            ->pluck('subject_specialty');

        return view('admin.teachers.index', compact('teachers', 'subjects'));
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created teacher.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:30',
            'subject_specialty' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'education' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // 2MB max
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        // Handle photo upload with WebP conversion
        if ($request->hasFile('photo')) {
            $validated['photo'] = $this->imageService
                ->setQuality(85)
                ->setMaxDimensions(800, 800) // Smaller for profile photos
                ->optimizeAndStore($request->file('photo'), 'teachers');
        }

        Teacher::create($validated);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Guru/Staff berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified teacher.
     */
    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified teacher.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:30',
            'subject_specialty' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'education' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        // Handle photo upload with WebP conversion
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($teacher->photo) {
                Storage::disk('public')->delete($teacher->photo);
            }

            $validated['photo'] = $this->imageService
                ->setQuality(85)
                ->setMaxDimensions(800, 800)
                ->optimizeAndStore($request->file('photo'), 'teachers');
        }

        $teacher->update($validated);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Guru/Staff berhasil diperbarui.');
    }

    /**
     * Remove the specified teacher.
     */
    public function destroy(Teacher $teacher)
    {
        // Delete photo if exists
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }

        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Guru/Staff berhasil dihapus.');
    }

    /**
     * Toggle teacher active status.
     */
    public function toggleActive(Teacher $teacher)
    {
        $teacher->update(['is_active' => !$teacher->is_active]);

        $status = $teacher->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Guru/Staff berhasil {$status}.");
    }
}
