<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل حزمة العمرة - هدية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }
        
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
            position: fixed;
            top: 0;
            right: 0;
            width: 250px;
            z-index: 1000;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 15px 20px;
            border-radius: 10px;
            margin: 5px 10px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(-5px);
        }
        
        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #fff;
            border-radius: 2px;
        }
        
        .main-content {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            margin-right: 250px;
            padding: 0;
        }
        
        .content-wrapper {
            padding: 30px;
        }
        
        .content-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border: none;
            overflow: hidden;
        }
        
        .info-table {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }
        
        .info-table tr {
            border-bottom: 1px solid #e9ecef;
        }
        
        .info-table tr:last-child {
            border-bottom: none;
        }
        
        .info-table th {
            font-weight: 600;
            color: #495057;
            width: 30%;
            padding: 15px 0;
        }
        
        .info-table td {
            padding: 15px 0;
            color: #212529;
        }
        
        .btn {
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .currency-icon {
            width: 20px;
            height: 20px;
        }
        
        .package-image-container {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .package-image-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }
        
        .package-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        
        .package-image-container:hover .package-image {
            transform: scale(1.05);
        }
        
        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            color: white;
            padding: 1.5rem;
            transform: translateY(100%);
            transition: all 0.3s ease;
        }
        
        .package-image-container:hover .image-overlay {
            transform: translateY(0);
        }
        
        .image-placeholder {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        
        .image-placeholder i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.7;
        }
        
        .image-placeholder h5 {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .image-placeholder p {
            opacity: 0.8;
            margin: 0;
        }
        
        .image-actions {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: flex;
            gap: 0.5rem;
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .package-image-container:hover .image-actions {
            opacity: 1;
        }
        
        .image-action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .image-action-btn:hover {
            background: white;
            transform: scale(1.1);
            color: #764ba2;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-right: 0;
            }
            
            .content-wrapper {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="p-4">
            <div class="text-center mb-4">
                <img src="/images/logo.jpg" alt="هدية" style="height: 40px; width: auto;" class="mb-3" onerror="this.style.display='none'">
                <h4 class="text-white mb-0">هدية</h4>
                <small class="text-white-50">لوحة تحكم الإدارة</small>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>لوحة التحكم
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users me-2"></i>المستخدمين
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-cart me-2"></i>الطلبات
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}" href="{{ route('admin.packages.index') }}">
                        <i class="fas fa-box me-2"></i>حزم العمرة
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog me-2"></i>الإعدادات
                    </a>
                </li>
            </ul>
            
            <hr class="text-white-50">
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome') }}">
                        <i class="fas fa-home me-2"></i>الموقع الرئيسي
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-white p-0 w-100 text-start">
                            <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-wrapper">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">تفاصيل حزمة العمرة</h2>
                    <p class="text-muted mb-0">{{ $package->name_ar }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>تعديل الحزمة
                    </a>
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>العودة للحزم
                    </a>
                </div>
            </div>

            <!-- Package Image Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="content-card">
                        <div class="p-4">
                            <h5 class="mb-4">
                                <i class="fas fa-image me-2 text-primary"></i>
                                صورة الحزمة
                            </h5>
                            
                            <div class="package-image-container">
                                @if($package->image && !empty($package->image) && file_exists(public_path($package->image)))
                                    <img src="{{ asset($package->image) }}" alt="صورة حزمة {{ $package->name_ar }}" class="package-image">
                                    
                                    <!-- Image Actions -->
                                    <div class="image-actions">
                                        <button type="button" class="image-action-btn" onclick="openImageModal('{{ asset($package->image) }}')" title="عرض الصورة">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <a href="{{ asset($package->image) }}" download class="image-action-btn" title="تحميل الصورة">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                    
                                    <!-- Image Overlay -->
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
                </div>
            </div>

            <div class="row">
                <!-- Package Details -->
                <div class="col-md-8">
                    <div class="content-card">
                        <div class="p-4">
                            <h5 class="mb-4">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                معلومات الحزمة
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
                                            <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage($package->currency) }}" alt="{{ $package->currency }}" class="currency-icon me-1">
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
                <div class="col-md-4">
                    <div class="content-card">
                        <div class="p-4">
                            <h5 class="mb-4">
                                <i class="fas fa-cogs me-2 text-primary"></i>
                                الإجراءات
                            </h5>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>تعديل الحزمة
                                </a>
                                
                                <form method="POST" action="{{ route('admin.packages.destroy', $package) }}" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الحزمة؟')">
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

                    <!-- Package Stats -->
                    <div class="content-card mt-3">
                        <div class="p-4">
                            <h5 class="mb-4">
                                <i class="fas fa-chart-bar me-2 text-primary"></i>
                                إحصائيات الحزمة
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
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">صورة الحزمة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openImageModal(imageSrc) {
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            const modalImage = document.getElementById('modalImage');
            const downloadLink = document.getElementById('downloadImage');
            
            modalImage.src = imageSrc;
            downloadLink.href = imageSrc;
            
            modal.show();
        }
        
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading animation to image
            const packageImage = document.querySelector('.package-image');
            if (packageImage) {
                packageImage.addEventListener('load', function() {
                    this.style.opacity = '0';
                    this.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        this.style.opacity = '1';
                    }, 100);
                });
            }
            
            // Add click to open modal functionality
            const imageContainer = document.querySelector('.package-image-container');
            if (imageContainer && packageImage) {
                imageContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('package-image')) {
                        openImageModal(packageImage.src);
                    }
                });
                
                // Add cursor pointer
                imageContainer.style.cursor = 'pointer';
            }
        });
    </script>
</body>
</html>