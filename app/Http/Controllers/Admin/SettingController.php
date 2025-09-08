<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{

    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = SiteSetting::orderBy('id', 'desc')->first();
        return view('admin.cms.settings.upload', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        // Validate the form inputs
        $validator = Validator::make($request->all(), [
            'header_logo' => 'nullable|image',
            'footer_logo' => 'nullable|image',
            'footer_description' => 'required|string',
            'opening_day' => 'required|string|max:100',
            'opening_time' => 'required|string|max:100',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|max:255',
            'social_entries.*.platform' => 'required|string|max:50',
            'social_entries.*.url' => 'required|url|max:255',
            'social_entries.*.icon' => 'required|string|max:255',
            'newsletter_title' => 'required|string|max:255',
            'newsletter_subtitle' => 'required|string|max:255',
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle the image uploads and other fields
        $data = $request->only([
            'footer_description',
            'opening_day',
            'opening_time',
            'phone_number',
            'address',
            'newsletter_title',
            'newsletter_subtitle',
        ]);

        // Handle file uploads for header and footer logos
        if ($request->hasFile('header_logo')) {
            $data['header_logo'] = $this->imageUpload($request->file('header_logo'), 'logos');
        }

        if ($request->hasFile('footer_logo')) {
            $data['footer_logo'] = $this->imageUpload($request->file('footer_logo'), 'logos');
        }

        // Handle social links as an array
        $socialLinks = [];
        if ($request->has('social_entries')) {
            foreach ($request->social_entries as $entry) {
                $socialLinks[] = [
                    'platform' => $entry['platform'],
                    'url' => $entry['url'],
                    'icon' => $entry['icon'],
                    'icon_path' => $entry['icon_path'] ?? null, // Assuming this is how you handle icons
                ];
            }
        }

        // Store or update settings in the database
        $settings = SiteSetting::updateOrCreate(
            ['id' => $request->id], // If updating existing settings
            array_merge($data, ['social_links' => $socialLinks])
        );

        session()->flash('message', 'Settings updated successfully!');
        // Return a success response
        return response()->json(['success' => true, 'message' => 'Settings updated successfully!']);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
