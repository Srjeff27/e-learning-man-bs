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
        return view('pages.profil');
    }

    /**
     * Display the vision & mission page.
     */
    public function visiMisi()
    {
        return view('pages.visi-misi');
    }

    /**
     * Display the organizational structure page.
     */
    public function strukturOrganisasi()
    {
        return view('pages.struktur-organisasi');
    }

    /**
     * Display the teachers & staff page.
     */
    public function guruStaff()
    {
        return view('pages.guru-staff');
    }

    /**
     * Display the news listing page.
     */
    public function berita()
    {
        return view('pages.berita');
    }

    /**
     * Display the gallery page.
     */
    public function galeri()
    {
        return view('pages.galeri');
    }

    /**
     * Display the academic calendar page.
     */
    public function kalender()
    {
        return view('pages.kalender');
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

        // TODO: Store contact message or send email

        return back()->with('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }
}
