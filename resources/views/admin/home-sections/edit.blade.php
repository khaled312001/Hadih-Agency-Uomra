@extends('layouts.admin')

@section('title', 'تعديل القسم')

@section('content')
<div class="page-gradient-bar"></div>

<div class="content-card">
    <div class="content-card-header">
        <h5 class="mb-0">تعديل القسم: {{ $homePageSection->title_ar ?? $homePageSection->type }}</h5>
        <a href="{{ route('admin.home-sections.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-right me-1"></i>رجوع
        </a>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.home-sections.update', ['section' => $homePageSection->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">نوع القسم</label>
                    <input type="text" class="form-control" value="{{ ucfirst($homePageSection->type) }}" disabled>
                    <input type="hidden" name="type" value="{{ $homePageSection->type }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">الحالة</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $homePageSection->is_active ? 'checked' : '' }}>
                        <label class="form-check-label">نشط</label>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">العنوان (عربي)</label>
                    <input type="text" name="title_ar" class="form-control" value="{{ old('title_ar', $homePageSection->title_ar) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">العنوان (English)</label>
                    <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $homePageSection->title_en) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">الوصف / العنوان الفرعي (عربي)</label>
                    <textarea name="subtitle_ar" class="form-control" rows="3">{{ old('subtitle_ar', $homePageSection->subtitle_ar) }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">الوصف / العنوان الفرعي (English)</label>
                    <textarea name="subtitle_en" class="form-control" rows="3">{{ old('subtitle_en', $homePageSection->subtitle_en) }}</textarea>
                </div>
            </div>

            <div id="heroFields" class="section-specific {{ $homePageSection->type === 'hero' ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">رابط الفيديو (YouTube Embed URL)</label>
                        <input type="text" name="video_url" class="form-control" value="{{ old('video_url', $homePageSection->video_url) }}">
                    </div>
                </div>
            </div>

            <div id="mediaFields" class="section-specific {{ $homePageSection->type === 'about' ? '' : 'd-none' }}">
                 <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">الصورة</label>
                        @if($homePageSection->image)
                            <div class="mb-2 text-center">
                                <img src="{{ $homePageSection->image }}" class="current-image img-thumbnail" alt="Current Image" style="max-height: 150px;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
            </div>

            <div id="buttonFields" class="section-specific {{ in_array($homePageSection->type, ['hero', 'about']) ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">نص الزر (عربي)</label>
                        <input type="text" name="button_text_ar" class="form-control" value="{{ old('button_text_ar', $homePageSection->button_text_ar) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">نص الزر (English)</label>
                        <input type="text" name="button_text_en" class="form-control" value="{{ old('button_text_en', $homePageSection->button_text_en) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">رابط الزر</label>
                        <input type="text" name="button_link" class="form-control" value="{{ old('button_link', $homePageSection->button_link) }}">
                    </div>
                </div>
            </div>

            @if(in_array($homePageSection->type, ['features', 'stats']))
            <div id="jsonFields" class="mt-4">
                <h6>محتوى القائمة (JSON) - {{ $homePageSection->type === 'features' ? 'المميزات' : 'الإحصائيات' }}</h6>
                <div id="items-container">
                    @php 
                        $itemsAr = $homePageSection->content_ar ?? [];
                        $itemsEn = $homePageSection->content_en ?? [];
                    @endphp
                    @foreach($itemsAr as $index => $itemAr)
                    <div class="item-row border p-3 mb-3 rounded bg-light position-relative">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label class="small">Icon (FontAwesome)</label>
                                <input type="text" name="content_ar[{{ $index }}][icon]" class="form-control form-control-sm" value="{{ $itemAr['icon'] ?? '' }}">
                                <input type="hidden" name="content_en[{{ $index }}][icon]" value="{{ $itemAr['icon'] ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="small">العنوان (عربي)</label>
                                <input type="text" name="content_ar[{{ $index }}][title]" class="form-control form-control-sm" value="{{ $itemAr['title'] ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="small">Title (English)</label>
                                <input type="text" name="content_en[{{ $index }}][title]" class="form-control form-control-sm" value="{{ $itemsEn[$index]['title'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="small">الوصف (عربي)</label>
                                <textarea name="content_ar[{{ $index }}][text]" class="form-control form-control-sm" rows="2">{{ $itemAr['text'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="small">Description (English)</label>
                                <textarea name="content_en[{{ $index }}][text]" class="form-control form-control-sm" rows="2">{{ $itemsEn[$index]['text'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-5">
                    <i class="fas fa-save me-1"></i>حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
