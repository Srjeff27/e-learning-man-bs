<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Services\ImageOptimizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    protected ImageOptimizationService $imageService;

    public function __construct(ImageOptimizationService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $news = News::with('author')->latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:50',
            'featured_image' => 'nullable|image|max:5120', // 5MB max
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['author_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        // Convert image to WebP (desktop + mobile versions)
        if ($request->hasFile('featured_image')) {
            $images = $this->imageService->optimizeAndStoreResponsive(
                $request->file('featured_image'),
                'news'
            );
            $validated['featured_image'] = $images['desktop'];
            $validated['featured_image_mobile'] = $images['mobile'];
        }

        News::create($validated);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:50',
            'featured_image' => 'nullable|image|max:5120', // 5MB max
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['is_featured'] = $request->has('is_featured');

        if (!$news->published_at && $validated['is_published']) {
            $validated['published_at'] = now();
        }

        // Convert image to WebP (desktop + mobile versions)
        if ($request->hasFile('featured_image')) {
            // Delete old images
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            if ($news->featured_image_mobile) {
                Storage::disk('public')->delete($news->featured_image_mobile);
            }

            $images = $this->imageService->optimizeAndStoreResponsive(
                $request->file('featured_image'),
                'news'
            );
            $validated['featured_image'] = $images['desktop'];
            $validated['featured_image_mobile'] = $images['mobile'];
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function toggle(News $news)
    {
        $news->update(['is_published' => !$news->is_published]);
        $status = $news->is_published ? 'dipublikasikan' : 'disembunyikan';
        return back()->with('success', "Berita berhasil {$status}.");
    }

    public function destroy(News $news)
    {
        // Delete image files (desktop + mobile)
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }
        if ($news->featured_image_mobile) {
            Storage::disk('public')->delete($news->featured_image_mobile);
        }

        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
