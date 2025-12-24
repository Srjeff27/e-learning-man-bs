<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Models\Teacher;
use App\Services\ImageOptimizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected ImageOptimizationService $imageService;

    public function __construct(ImageOptimizationService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $profile = SchoolProfile::first() ?? new SchoolProfile();
        $teachers = Teacher::orderBy('full_name')->get();
        return view('admin.profile.index', compact('profile', 'teachers'));
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
            'pimpinan' => 'nullable|array',
            'pimpinan.*.position' => 'nullable|string|max:255',
            'pimpinan.*.name' => 'nullable|string|max:255',
            'pimpinan.*.nip' => 'nullable|string|max:50',
            'pimpinan.*.photo' => 'nullable|string',
            'pimpinan_photos.*' => 'nullable|image|max:1024',
            'koordinator' => 'nullable|array',
            'koordinator.*.position' => 'nullable|string|max:255',
            'koordinator.*.name' => 'nullable|string|max:255',
            'koordinator.*.nip' => 'nullable|string|max:50',
            'koordinator.*.photo' => 'nullable|string',
            'koordinator_photos.*' => 'nullable|image|max:1024',
            'motto' => 'nullable|string|max:255',
            'accreditation' => 'nullable|string|max:10',
            'history' => 'nullable|string',
            'facilities' => 'nullable|array',
            'facilities.*' => 'nullable|string|max:255',
            'school_photo' => 'nullable|image|max:5120',
        ]);

        // Convert school_photo to WebP
        if ($request->hasFile('school_photo')) {
            $validated['school_photo'] = $this->imageService
                ->setQuality(85)
                ->setMaxDimensions(1920, 1080)
                ->optimizeAndStore($request->file('school_photo'), 'profile');
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

        // Handle pimpinan and koordinator as organization_structure
        $profile = SchoolProfile::first();
        $organizationStructure = [];

        // Process pimpinan
        if (isset($validated['pimpinan'])) {
            foreach ($validated['pimpinan'] as $key => $item) {
                // Handle new photo upload with WebP conversion
                if ($request->hasFile("pimpinan_photos.$key")) {
                    $item['photo'] = $this->imageService
                        ->setQuality(85)
                        ->setMaxDimensions(400, 400)
                        ->optimizeAndStore($request->file("pimpinan_photos.$key"), 'organization');
                }

                // Set type
                $item['type'] = 'pimpinan';

                if (!empty($item['position']) || !empty($item['name'])) {
                    $organizationStructure[] = $item;
                }
            }
        }

        // Process koordinator
        if (isset($validated['koordinator'])) {
            foreach ($validated['koordinator'] as $key => $item) {
                // Handle new photo upload with WebP conversion
                if ($request->hasFile("koordinator_photos.$key")) {
                    $item['photo'] = $this->imageService
                        ->setQuality(85)
                        ->setMaxDimensions(400, 400)
                        ->optimizeAndStore($request->file("koordinator_photos.$key"), 'organization');
                }

                // Set type
                $item['type'] = 'koordinator';

                if (!empty($item['position']) || !empty($item['name'])) {
                    $organizationStructure[] = $item;
                }
            }
        }

        $validated['organization_structure'] = $organizationStructure;
        unset($validated['pimpinan'], $validated['koordinator']);

        if ($profile) {
            $profile->update($validated);
        } else {
            SchoolProfile::create($validated);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Profil sekolah berhasil diperbarui.']);
        }

        return back()->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
