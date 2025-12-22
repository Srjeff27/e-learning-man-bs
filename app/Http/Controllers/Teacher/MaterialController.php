<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Show the form for creating a new material.
     */
    public function create(Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        return view('teacher.materials.create', compact('classroom'));
    }

    /**
     * Store a newly created material.
     */
    public function store(Request $request, Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:text,file,video,link',
            'external_link' => 'nullable|url|required_if:type,link',
            'file' => 'nullable|file|max:10240|required_if:type,file',
            'is_published' => 'boolean',
        ]);

        $validated['classroom_id'] = $classroom->id;
        $validated['created_by'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published', true);
        $validated['order'] = $classroom->materials()->max('order') + 1;

        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('materials/' . $classroom->id, 'public');
            $validated['file_path'] = $path;
            $validated['file_name'] = $file->getClientOriginalName();
        }

        Material::create($validated);

        return redirect()->route('teacher.classrooms.show', $classroom)
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    /**
     * Show the material.
     */
    public function show(Classroom $classroom, Material $material)
    {
        $this->authorize('view', $classroom);

        return view('teacher.materials.show', compact('classroom', 'material'));
    }

    /**
     * Show the form for editing a material.
     */
    public function edit(Classroom $classroom, Material $material)
    {
        $this->authorize('update', $classroom);

        return view('teacher.materials.edit', compact('classroom', 'material'));
    }

    /**
     * Update the material.
     */
    public function update(Request $request, Classroom $classroom, Material $material)
    {
        $this->authorize('update', $classroom);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:text,file,video,link',
            'external_link' => 'nullable|url',
            'file' => 'nullable|file|max:10240',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published', true);

        // Handle new file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('materials/' . $classroom->id, 'public');
            $validated['file_path'] = $path;
            $validated['file_name'] = $file->getClientOriginalName();
        }

        $material->update($validated);

        return redirect()->route('teacher.classrooms.show', $classroom)
            ->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Delete the material.
     */
    public function destroy(Classroom $classroom, Material $material)
    {
        $this->authorize('update', $classroom);

        // Delete file if exists
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('teacher.classrooms.show', $classroom)
            ->with('success', 'Materi berhasil dihapus.');
    }
}
