<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('uploader')->latest()->paginate(12);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:photo,video',
            'category' => 'nullable|string|max:50',
            'file' => 'required|file|max:10240',
            'is_featured' => 'boolean',
        ]);

        $validated['uploaded_by'] = auth()->id();
        $validated['is_featured'] = $request->has('is_featured');
        $validated['file_path'] = $request->file('file')->store('galleries', 'public');

        if ($validated['type'] === 'photo') {
            $validated['thumbnail'] = $validated['file_path'];
        }

        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'Item galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:50',
            'file' => 'nullable|file|max:10240',
            'is_featured' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('galleries', 'public');
            if ($gallery->type === 'photo') {
                $validated['thumbnail'] = $validated['file_path'];
            }
        }

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'Item galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Item galeri berhasil dihapus.');
    }
}
