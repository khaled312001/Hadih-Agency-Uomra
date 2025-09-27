@extends('layouts.admin')

@section('title', 'إدارة حزم العمرة')
@section('page-title', 'إدارة حزم العمرة')
@section('page-description', 'إدارة حزم العمرة المتاحة في النظام')

@section('page-actions')
    <a href="{{ route('admin.packages.create') }}" class="btn btn-primary hover-lift">
        <i class="fas fa-plus me-2 icon-animated"></i>إضافة حزمة جديدة
    </a>
@endsection

@section('content')
                    
                    <!-- Packages Table -->
                    <div class="content-card animate-on-scroll">
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">قائمة حزم العمرة</h5>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted">إجمالي الحزم: {{ $packages->total() }}</span>
                                    <a href="{{ route('admin.packages.create') }}" class="btn btn-primary hover-lift">
                                        <i class="fas fa-plus me-2 icon-animated"></i>إضافة حزمة جديدة
                                    </a>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>الاسم</th>
                                            <th>السعر</th>
                                            <th>المدة</th>
                                            <th>الحالة</th>
                                            <th>ترتيب العرض</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($packages as $package)
                                        <tr class="animate-on-scroll">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 icon-animated" style="width: 35px; height: 35px;">
                                                        <i class="fas fa-kaaba"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $package->name_ar }}</div>
                                                        @if($package->name_en)
                                                        <small class="text-muted">{{ $package->name_en }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-success">
                                                    {{ number_format($package->price) }}
                                                    <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage($package->currency) }}" alt="{{ $package->currency }}" class="currency-icon me-1 hover-scale" style="width: 16px; height: 16px;">
                                                    {{ $package->currency }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info badge-pulse">{{ $package->duration ?? 'غير محدد' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $package->is_active ? 'success' : 'secondary' }} px-3 py-2">
                                                    {{ $package->is_active ? 'نشط' : 'غير نشط' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $package->sort_order }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.packages.show', $package) }}" class="btn btn-sm btn-outline-primary hover-lift" title="عرض">
                                                        <i class="fas fa-eye icon-animated"></i>
                                                    </a>
                                                    <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-sm btn-outline-warning hover-lift" title="تعديل">
                                                        <i class="fas fa-edit icon-animated"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.packages.destroy', $package) }}" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الحزمة؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger hover-lift" title="حذف">
                                                            <i class="fas fa-trash icon-animated"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="text-muted animate-on-scroll">
                                                    <i class="fas fa-box fa-3x mb-3 icon-animated"></i>
                                                    <div>لا توجد حزم عمرة حالياً</div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($packages->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $packages->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/animations.js') }}"></script>
    <script>
        // Add loading states to form submissions
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                }
            });
        });

        // Add hover effects to table rows
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(74, 144, 226, 0.05)';
                this.style.transform = 'scale(1.01)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
                this.style.transform = 'scale(1)';
            });
        });

        // Add click effects to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                // Create ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                    z-index: 1000;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>
@endsection
