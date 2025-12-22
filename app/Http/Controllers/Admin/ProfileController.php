<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = SchoolProfile::first() ?? new SchoolProfile();
        return view('admin.profile.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'principal_name' => 'nullable|string|max:255',
            'principal_nip' => 'nullable|string|max:30',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'missions' => 'nullable|array',
            'missions.*.title' => 'nullable|string|max:255',
            'missions.*.description' => 'nullable|string',
            'values' => 'nullable|array',
            'values.*.title' => 'nullable|string|max:255',
            'values.*.description' => 'nullable|string',
            'motto' => 'nullable|string|max:255',
            'accreditation' => 'nullable|string|max:10',
            'history' => 'nullable|string',
            'facilities' => 'nullable|array',
            'facilities.*' => 'nullable|string|max:255',
            'school_photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('school_photo')) {
            $validated['school_photo'] = $request->file('school_photo')->store('profile', 'public');
        }

        // Filter empty facilities
        if (isset($validated['facilities'])) {
            $validated['facilities'] = array_filter($validated['facilities'], fn($v) => !empty($v));
        }

        // Filter empty missions
        if (isset($validated['missions'])) {
            $validated['missions'] = array_filter($validated['missions'], fn($m) => !empty($m['title']) || !empty($m['description']));
            $validated['missions'] = array_values($validated['missions']);
        }

        // Filter empty values
        if (isset($validated['values'])) {
            $validated['values'] = array_filter($validated['values'], fn($v) => !empty($v['title']) || !empty($v['description']));
            $validated['values'] = array_values($validated['values']);
        }

        $profile = SchoolProfile::first();
        if ($profile) {
            $profile->update($validated);
        } else {
            SchoolProfile::create($validated);
        }

        return back()->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
