<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UmrahPackage;

class UmrahPackageController extends Controller
{
    public function index()
    {
        $packages = UmrahPackage::ordered()->paginate(15);
        return view('admin.packages.index', compact('packages'));
    }

    public function show(UmrahPackage $package)
    {
        return view('admin.packages.show', compact('package'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'duration' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/packages'), $imageName);
            $data['image'] = 'images/packages/' . $imageName;
        }

        UmrahPackage::create($data);

        return redirect()->route('admin.packages.index')
            ->with('success', 'تم إنشاء حزمة العمرة بنجاح');
    }

    public function edit(UmrahPackage $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, UmrahPackage $package)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'duration' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($package->image && file_exists(public_path($package->image))) {
                unlink(public_path($package->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/packages'), $imageName);
            $data['image'] = 'images/packages/' . $imageName;
        }

        $package->update($data);

        return redirect()->route('admin.packages.index')
            ->with('success', 'تم تحديث حزمة العمرة بنجاح');
    }

    public function destroy(UmrahPackage $package)
    {
        // Delete image if exists
        if ($package->image && file_exists(public_path($package->image))) {
            unlink(public_path($package->image));
        }
        
        $package->delete();
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'تم حذف حزمة العمرة بنجاح');
    }
}
