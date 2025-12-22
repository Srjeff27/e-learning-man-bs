<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Get active announcement banner
        $banner = Banner::active()->ordered()->first();

        // Get 5 latest published news for slider
        $latestNews = News::published()
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.home', compact('banner', 'latestNews'));
    }

    /**
     * Display the school profile page.
     */
    public function profil()
    {
        $profile = \App\Models\SchoolProfile::first();
        return view('pages.profil', compact('profile'));
    }

    /**
     * Display the vision & mission page.
     */
    public function visiMisi()
    {
        $profile = \App\Models\SchoolProfile::first();
        return view('pages.visi-misi', compact('profile'));
    }

    /**
     * Display the organizational structure page.
     */
    public function strukturOrganisasi()
    {
        $profile = \App\Models\SchoolProfile::first();
        return view('pages.struktur-organisasi', compact('profile'));
    }

    /**
     * Display the teachers & staff page.
     */
    public function guruStaff()
    {
        $teachers = \App\Models\Teacher::with('user')
            ->where('is_active', true)
            ->get();
        $profile = \App\Models\SchoolProfile::first();
        return view('pages.guru-staff', compact('teachers', 'profile'));
    }

    /**
     * Display the news listing page.
     */
    public function berita(Request $request)
    {
        $query = \App\Models\News::published()->latest('published_at');

        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        $news = $query->paginate(6);
        $categories = \App\Models\News::published()->distinct()->pluck('category')->filter()->values();

        return view('pages.berita', compact('news', 'categories'));
    }

    /**
     * Display a single news article.
     */
    public function beritaShow($slug)
    {
        $article = \App\Models\News::published()->where('slug', $slug)->firstOrFail();

        // Increment view count
        $article->increment('views');

        // Get related news from same category
        $relatedNews = \App\Models\News::published()
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->take(3)
            ->get();

        return view('pages.berita-detail', compact('article', 'relatedNews'));
    }

    /**
     * Display the gallery page.
     */
    public function galeri()
    {
        $photos = \App\Models\Gallery::photos()->latest()->get();
        $videos = \App\Models\Gallery::videos()->latest()->get();
        $categories = \App\Models\Gallery::photos()->distinct()->pluck('category')->filter()->values();

        return view('pages.galeri', compact('photos', 'videos', 'categories'));
    }

    /**
     * Download the academic calendar as PDF.
     */
    public function downloadCalendar()
    {
        $currentYear = \App\Models\Event::max('academic_year') ?? '2025/2026';

        $semesterGanjil = \App\Models\Event::byAcademicYear($currentYear)
            ->bySemester('ganjil')
            ->orderBy('event_date')
            ->get();

        $semesterGenap = \App\Models\Event::byAcademicYear($currentYear)
            ->bySemester('genap')
            ->orderBy('event_date')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.kalender', compact('semesterGanjil', 'semesterGenap', 'currentYear'));

        // Setup paper size
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Kalender_Akademik_' . str_replace('/', '-', $currentYear) . '.pdf');
    }

    /**
     * Display the academic calendar page.
     */
    public function kalender()
    {
        $currentYear = \App\Models\Event::max('academic_year') ?? '2025/2026';

        $semesterGanjil = \App\Models\Event::byAcademicYear($currentYear)
            ->bySemester('ganjil')
            ->orderBy('event_date')
            ->get();

        $semesterGenap = \App\Models\Event::byAcademicYear($currentYear)
            ->bySemester('genap')
            ->orderBy('event_date')
            ->get();

        $upcomingEvents = \App\Models\Event::upcoming()->take(5)->get();

        return view('pages.kalender', compact('semesterGanjil', 'semesterGenap', 'upcomingEvents', 'currentYear'));
    }

    /**
     * Display the contact page.
     */
    public function kontak()
    {
        return view('pages.kontak');
    }

    /**
     * Handle contact form submission.
     */
    public function kontakSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Simpan pesan ke database
        \App\Models\Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return back()->with('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }
}
