<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HomePageSection;
use Illuminate\Support\Facades\Storage;

class HomePageSectionController extends Controller
{
    public function index()
    {
        $sections = HomePageSection::orderBy('order')->get();
        return view('admin.home-sections.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.home-sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'subtitle_ar' => 'nullable|string',
            'subtitle_en' => 'nullable|string',
            'button_text_ar' => 'nullable|string|max:100',
            'button_text_en' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'video_url' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'content_ar' => 'nullable|array',
            'content_en' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('home-sections', 'public');
            $validated['image'] = $path;
        }

        HomePageSection::create($validated);

        return redirect()->route('admin.home-sections.index')->with('success', 'تم إضافة القسم بنجاح');
    }

    public function edit(HomePageSection $homePageSection)
    {
        return view('admin.home-sections.edit', compact('homePageSection'));
    }

    public function update(Request $request, HomePageSection $homePageSection)
    {
        $validated = $request->validate([
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'subtitle_ar' => 'nullable|string',
            'subtitle_en' => 'nullable|string',
            'button_text_ar' => 'nullable|string|max:100',
            'button_text_en' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'video_url' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'content_ar' => 'nullable|array',
            'content_en' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            if ($homePageSection->image) {
                Storage::disk('public')->delete($homePageSection->image);
            }
            $path = $request->file('image')->store('home-sections', 'public');
            $validated['image'] = $path;
        }

        $homePageSection->update($validated);

        return redirect()->route('admin.home-sections.index')->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(HomePageSection $homePageSection)
    {
        if ($homePageSection->image) {
            Storage::disk('public')->delete($homePageSection->image);
        }
        $homePageSection->delete();

        return redirect()->route('admin.home-sections.index')->with('success', 'تم حذف القسم بنجاح');
    }

    public function updateOrder(Request $request)
    {
        $data = $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:home_page_sections,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($data['orders'] as $item) {
            HomePageSection::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
