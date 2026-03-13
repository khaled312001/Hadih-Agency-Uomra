@extends('layouts.admin')

@section('title', 'إضافة قسم جديد')

@section('content')
<div class="page-gradient-bar"></div>

<div class="content-card">
    <div class="content-card-header">
        <h5 class="mb-0">إضافة قسم جديد للصفحة الرئيسية</h5>
        <a href="{{ route('admin.home-sections.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-right me-1"></i>رجوع
        </a>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.home-sections.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">نوع القسم <span class="text-danger">*</span></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required id="sectionType">
                        <option value="">اختر النوع</option>
                        <option value="hero">Hero (قسم البداية)</option>
                        <option value="about">About (من نحن)</option>
                        <option value="stats">Stats (الإحصائيات)</option>
                        <option value="features">Features (المميزات)</option>
                        <option value="testimonials">Testimonials (أراء العملاء)</option>
                        <option value="contact">Contact (اتصل بنا)</option>
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">الحالة</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                        <label class="form-check-label">نشط</label>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">العنوان (عربي)</label>
                    <input type="text" name="title_ar" class="form-control" value="{{ old('title_ar') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">العنوان (English)</label>
                    <input type="text" name="title_en" class="form-control" value="{{ old('title_en') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">الوصف / العنوان الفرعي (عربي)</label>
                    <textarea name="subtitle_ar" class="form-control" rows="3">{{ old('subtitle_ar') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">الوصف / العنوان الفرعي (English)</label>
                    <textarea name="subtitle_en" class="form-control" rows="3">{{ old('subtitle_en') }}</textarea>
                </div>
            </div>

            <div id="heroFields" class="section-specific d-none">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">رابط الفيديو (YouTube Embed URL)</label>
                        <input type="text" name="video_url" class="form-control" placeholder="https://www.youtube.com/embed/...">
                    </div>
                </div>
            </div>

            <div id="mediaFields" class="section-specific d-none">
                 <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">الصورة</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
            </div>

            <div id="buttonFields" class="section-specific d-none">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">نص الزر (عربي)</label>
                        <input type="text" name="button_text_ar" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">نص الزر (English)</label>
                        <input type="text" name="button_text_en" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">رابط الزر</label>
                        <input type="text" name="button_link" class="form-control">
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-5">
                    <i class="fas fa-save me-1"></i>حفظ القسم
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('sectionType').addEventListener('change', function() {
        const type = this.value;
        document.querySelectorAll('.section-specific').forEach(el => el.classList.add('d-none'));
        
        if (type === 'hero') {
            document.getElementById('heroFields').classList.remove('d-none');
            document.getElementById('buttonFields').classList.remove('d-none');
        } else if (type === 'about') {
            document.getElementById('mediaFields').classList.remove('d-none');
        } else if (type === 'features' || type === 'stats' || type === 'testimonials') {
            // These will use JSON content, which we'll handle with a dynamic list later if needed
        }
    });
</script>
@endsection
