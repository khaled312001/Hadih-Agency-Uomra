@extends('layouts.admin')

@section('title', 'إدارة المستخدمين')
@section('page-title', 'إدارة المستخدمين')
@section('page-description', 'إدارة المستخدمين المسجلين في النظام')

@section('page-actions')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary hover-lift">
        <i class="fas fa-plus me-2 icon-animated"></i>إضافة مستخدم جديد
    </a>
@endsection

@section('content')
                    
                    <!-- Users Table -->
                    <div class="content-card animate-on-scroll">
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">قائمة المستخدمين</h5>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted">إجمالي المستخدمين: {{ $users->total() }}</span>
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary hover-lift">
                                        <i class="fas fa-plus me-2 icon-animated"></i>إضافة مستخدم جديد
                                    </a>
                                </div>
                </div>
                            
        <div class="table-responsive">
                                <table class="table">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>الهاتف</th>
                        <th>الدور</th>
                        <th>الحالة</th>
                        <th>تاريخ التسجيل</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="animate-on-scroll">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 icon-animated" style="width: 35px; height: 35px;">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $user->name }}</div>
                                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $user->email }}</div>
                                                @if($user->email_verified_at)
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle me-1 icon-animated"></i>مؤكد
                                                </small>
                                                @else
                                                <small class="text-warning">
                                                    <i class="fas fa-exclamation-circle me-1 icon-animated"></i>غير مؤكد
                                                </small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->phone)
                                                <div class="fw-bold">{{ $user->phone }}</div>
                                                @else
                                                <span class="text-muted">غير محدد</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }} px-3 py-2 badge-pulse">
                                {{ $user->role == 'admin' ? 'مدير' : 'مستخدم' }}
                            </span>
                        </td>
                        <td>
                                                <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }} px-3 py-2 badge-pulse">
                                {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                                            <td>
                                                <div>{{ $user->created_at->format('Y-m-d') }}</div>
                                                <small class="text-muted">{{ $user->created_at->format('H:i') }}</small>
                                            </td>
                        <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary hover-lift" title="عرض">
                                <i class="fas fa-eye icon-animated"></i>
                            </a>
                                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning hover-lift" title="تعديل">
                                <i class="fas fa-edit icon-animated"></i>
                            </a>
                                                    @if($user->id !== auth()->id())
                                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger hover-lift" title="حذف">
                                                            <i class="fas fa-trash icon-animated"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <div class="text-muted animate-on-scroll">
                                                    <i class="fas fa-users fa-3x mb-3 icon-animated"></i>
                                                    <div>لا توجد مستخدمين حالياً</div>
                                                </div>
                                            </td>
                                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
                            @if($users->hasPages())
                            <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
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
