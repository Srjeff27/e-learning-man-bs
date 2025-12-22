<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_teachers' => User::where('role', 'guru')->count(),
            'total_students' => User::where('role', 'siswa')->count(),
            'total_news' => News::count(),
            'published_news' => News::published()->count(),
            'total_galleries' => Gallery::count(),
            'unread_contacts' => Contact::unread()->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentNews = News::latest()->take(5)->get();
        $unreadContacts = Contact::unread()->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentNews', 'unreadContacts'));
    }
}
