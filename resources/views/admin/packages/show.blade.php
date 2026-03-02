@extends('layouts.admin')

@section('title', 'تفاصيل حزمة العمرة')
@section('page-title', 'تفاصيل حزمة العمرة')
@section('page-description', '{{ $package->name_ar }}')

@section('page-actions')
    <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-warning hover-lift">
        <i class="fas fa-edit me-2"></i>تعديل الحزمة
    </a>
    <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary hover-lift">
        <i class="fas fa-arrow-right me-2"></i>العودة للحزم
    </a>
@endsection

@section('content')
    <!-- Package Image Section -->
    <div class="content-card mb-4">
        <div class="p-4">
            <h5 class="mb-4">
                <i class="fas fa-image me-2 text-primary"></i>صورة الحزمة
            </h5>
            <div class="package-image-container">
                @if($package->image && !empty($package->image) && file_exists(public_path($package->image)))
                    <img src="{{ asset($package->image) }}" alt="صورة حزمة {{ $package->name_ar }}" class="package-image">
                    <div class="image-actions">
                        <button type="button" class="image-action-btn" onclick="openImageModal('{{ asset($package->image) }}')" title="عرض الصورة">
                            <i class="fas fa-expand"></i>
                        </button>
                        <a href="{{ asset($package->image) }}" download class="image-action-btn" title="تحميل الصورة">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                    <div class="image-overlay">
                        <h6 class="mb-2">{{ $package->name_ar }}</h6>
                        <p class="mb-0 opacity-75">صورة حزمة العمرة</p>
                    </div>
                @else
                    <div class="image-placeholder">
                        <i class="fas fa-image"></i>
                        <h5>لا توجد صورة</h5>
                        <p>لم يتم رفع صورة لهذه الحزمة</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Package Details -->
        <div class="col-md-8 mb-3">
            <div class="content-card">
                <div class="p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-info-circle me-2 text-primary"></i>معلومات الحزمة
                    </h5>
                    <div class="info-table">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th>الاسم بالعربية:</th>
                                <td>{{ $package->name_ar }}</td>
                            </tr>
                            @if($package->name_en)
                            <tr>
                                <th>الاسم بالإنجليزية:</th>
                                <td>{{ $package->name_en }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>السعر:</th>
                                <td>
                                    <span class="fw-bold text-success">{{ number_format($package->price, 2) }}</span>
                                    <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage($package->currency) }}" alt="{{ $package->currency }}" class="currency-icon me-1" style="width:20px;height:20px;">
                                    {{ $package->currency }}
                                </td>
                            </tr>
                            <tr>
                                <th>المدة:</th>
                                <td>{{ $package->duration ?? 'غير محدد' }}</td>
                            </tr>
                            <tr>
                                <th>الحالة:</th>
                                <td>
                                    <span class="badge bg-{{ $package->is_active ? 'success' : 'secondary' }} px-3 py-2">
                                        {{ $package->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>ترتيب العرض:</th>
                                <td>{{ $package->sort_order }}</td>
                            </tr>
                            <tr>
                                <th>تاريخ الإنشاء:</th>
                                <td>{{ $package->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <th>آخر تحديث:</th>
                                <td>{{ $package->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    @if($package->description_ar)
                    <div class="mt-4">
                        <h6 class="text-muted mb-3">الوصف:</h6>
                        <p class="text-muted">{{ $package->description_ar }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions & Stats -->
        <div class="col-md-4 mb-3">
            <div class="content-card">
                <div class="p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-cogs me-2 text-primary"></i>الإجراءات
                    </h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>تعديل الحزمة
                        </a>
                        <form method="POST" action="{{ route('admin.packages.destroy', $package) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذه الحزمة؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-2"></i>حذف الحزمة
                            </button>
                        </form>
                        <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>العودة للحزم
                        </a>
                    </div>
                </div>
            </div>

            <div class="content-card mt-3">
                <div class="p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>إحصائيات الحزمة
                    </h5>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ $package->orders()->count() }}</h4>
                                <small class="text-muted">إجمالي الطلبات</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-1">{{ $package->orders()->where('status', 'completed')->count() }}</h4>
                            <small class="text-muted">طلبات مكتملة</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">صورة الحزمة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="صورة الحزمة" class="img-fluid rounded">
                </div>
                <div class="modal-footer">
                    <a id="downloadImage" href="" download class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>تحميل الصورة
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('downloadImage').href = imageSrc;
        new bootstrap.Modal(document.getElementById('imageModal')).show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const imageContainer = document.querySelector('.package-image-container');
        const packageImage = document.querySelector('.package-image');
        if (imageContainer && packageImage) {
            imageContainer.style.cursor = 'pointer';
            imageContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('package-image')) {
                    openImageModal(packageImage.src);
                }
            });
        }
    });
</script>
@endsection
