@extends('layouts.admin')

@section('title', 'تعديل حزمة العمرة')
@section('page-title', 'تعديل حزمة العمرة')
@section('page-description', 'تعديل معلومات حزمة العمرة: {{ $package->name_ar }}')

@section('page-actions')
    <a href="{{ route('admin.packages.show', $package) }}" class="btn btn-outline-info hover-lift">
        <i class="fas fa-eye me-2"></i>عرض الحزمة
    </a>
    <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary hover-lift">
        <i class="fas fa-arrow-right me-2"></i>العودة للحزم
    </a>
@endsection

@section('content')
    <div class="content-card">
        <div class="p-4">
            <form method="POST" action="{{ route('admin.packages.update', $package) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name_ar" class="form-label">الاسم بالعربية <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar" value="{{ old('name_ar', $package->name_ar) }}" required>
                            @error('name_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name_en" class="form-label">الاسم بالإنجليزية</label>
                            <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en" value="{{ old('name_en', $package->name_en) }}">
                            @error('name_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="price" class="form-label">السعر <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $package->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="currency" class="form-label">العملة <span class="text-danger">*</span></label>
                            <select class="form-select @error('currency') is-invalid @enderror" id="currency" name="currency" required>
                                <option value="">اختر العملة</option>
                                <option value="SAR" {{ old('currency', $package->currency) == 'SAR' ? 'selected' : '' }}>ريال سعودي (SAR)</option>
                                <option value="USD" {{ old('currency', $package->currency) == 'USD' ? 'selected' : '' }}>دولار أمريكي (USD)</option>
                                <option value="EUR" {{ old('currency', $package->currency) == 'EUR' ? 'selected' : '' }}>يورو (EUR)</option>
                                <option value="AED" {{ old('currency', $package->currency) == 'AED' ? 'selected' : '' }}>درهم إماراتي (AED)</option>
                            </select>
                            @error('currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="duration" class="form-label">المدة</label>
                            <input type="text" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration', $package->duration) }}" placeholder="مثال: 7 أيام">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description_ar" class="form-label">الوصف بالعربية</label>
                    <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar" name="description_ar" rows="4" placeholder="اكتب وصفاً مفصلاً للحزمة">{{ old('description_ar', $package->description_ar) }}</textarea>
                    @error('description_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">ترتيب العرض</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $package->sort_order) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">الحالة</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">نشط</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Upload Section -->
                <div class="mb-4">
                    <label for="image" class="form-label">صورة الحزمة</label>

                    @if($package->image && !empty($package->image) && file_exists(public_path($package->image)))
                        <div class="mb-3">
                            <p class="text-muted mb-2">الصورة الحالية:</p>
                            <img src="{{ asset($package->image) }}" alt="صورة الحزمة الحالية" class="current-image" style="max-width:300px;max-height:200px;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.1);">
                        </div>
                    @endif

                    <div class="image-upload-container">
                        <div class="upload-area" id="uploadArea">
                            <div class="upload-content">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <p class="upload-text">{{ $package->image ? 'اختر صورة جديدة أو اسحب وأفلت' : 'اسحب وأفلت الصورة هنا أو انقر للاختيار' }}</p>
                                <p class="upload-hint">يدعم: JPG, PNG, GIF, WebP (حد أقصى 5MB)</p>
                            </div>
                            <input type="file" class="form-control d-none" id="image" name="image" accept="image/*">
                        </div>
                        <div class="image-preview d-none" id="imagePreview">
                            <img id="previewImg" src="" alt="معاينة الصورة" class="preview-image">
                            <div class="preview-actions">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeImage()">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('image')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.packages.show', $package) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadArea = document.getElementById('uploadArea');
        const imageInput = document.getElementById('image');
        const uploadContainer = document.querySelector('.image-upload-container');

        uploadArea.addEventListener('click', function() {
            imageInput.click();
        });

        uploadContainer.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadContainer.classList.add('drag-over');
        });

        uploadContainer.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadContainer.classList.remove('drag-over');
        });

        uploadContainer.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadContainer.classList.remove('drag-over');
            const files = e.dataTransfer.files;
            if (files.length > 0) handleFile(files[0]);
        });

        imageInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) handleFile(e.target.files[0]);
        });
    });

    function handleFile(file) {
        if (!file.type.startsWith('image/')) {
            alert('يرجى اختيار ملف صورة صالح');
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            alert('حجم الملف يجب أن يكون أقل من 5 ميجابايت');
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('d-none');
            document.getElementById('uploadArea').classList.add('d-none');
        };
        reader.readAsDataURL(file);
    }

    function removeImage() {
        document.getElementById('image').value = '';
        document.getElementById('imagePreview').classList.add('d-none');
        document.getElementById('uploadArea').classList.remove('d-none');
    }
</script>
@endsection
