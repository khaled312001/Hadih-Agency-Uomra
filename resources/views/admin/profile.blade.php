@extends('layouts.admin')

@section('title', 'الملف الشخصي')
@section('page-title', 'الملف الشخصي')
@section('page-description', 'إدارة معلوماتك الشخصية وكلمة المرور')

@section('content')
    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-8 mb-4">
            <div class="content-card animate-on-scroll">
                <div class="profile-header">
                    <h3 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>
                        المعلومات الشخصية
                    </h3>
                    <p class="mb-0 mt-2">تحديث معلوماتك الشخصية</p>
                </div>
                <div class="p-4">
                    <form method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">الاسم الكامل</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">رقم الهاتف</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">الدور</label>
                                <input type="text" class="form-control" value="{{ $user->role == 'admin' ? 'مدير النظام' : 'مستخدم' }}" readonly>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="created_at" class="form-label">تاريخ التسجيل</label>
                                <input type="text" class="form-control" value="{{ $user->created_at->format('Y-m-d H:i') }}" readonly>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="last_login" class="form-label">آخر تسجيل دخول</label>
                                <input type="text" class="form-control" value="{{ $user->updated_at->format('Y-m-d H:i') }}" readonly>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary hover-lift">
                                <i class="fas fa-save me-2"></i>حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Profile Stats & Password -->
        <div class="col-lg-4 mb-4">
            <!-- Profile Stats -->
            <div class="content-card animate-on-scroll mb-4">
                <div class="profile-header">
                    <h3 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        إحصائيات الحساب
                    </h3>
                </div>
                <div class="p-4">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="stats-icon users">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="stats-number">{{ $user->orders()->count() }}</div>
                            <div class="stats-label">الطلبات</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="stats-icon orders">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="stats-number">{{ $user->messages()->count() }}</div>
                            <div class="stats-label">الرسائل</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Change Password -->
            <div class="content-card animate-on-scroll">
                <div class="profile-header">
                    <h3 class="mb-0">
                        <i class="fas fa-lock me-2"></i>
                        تغيير كلمة المرور
                    </h3>
                </div>
                <div class="p-4">
                    <form method="POST" action="{{ route('admin.profile.password') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور الجديدة</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning hover-lift">
                                <i class="fas fa-key me-2"></i>تغيير كلمة المرور
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Account Security -->
    <div class="row">
        <div class="col-12">
            <div class="content-card animate-on-scroll">
                <div class="profile-header">
                    <h3 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        أمان الحساب
                    </h3>
                    <p class="mb-0 mt-2">إعدادات الأمان والخصوصية</p>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="security-item">
                                <div class="d-flex align-items-center">
                                    <div class="security-icon me-3">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">البريد الإلكتروني</h6>
                                        <small class="text-muted">
                                            @if($user->email_verified_at)
                                                <span class="text-success">
                                                    <i class="fas fa-check-circle me-1"></i>مؤكد
                                                </span>
                                            @else
                                                <span class="text-warning">
                                                    <i class="fas fa-exclamation-circle me-1"></i>غير مؤكد
                                                </span>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="security-item">
                                <div class="d-flex align-items-center">
                                    <div class="security-icon me-3">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">الدور</h6>
                                        <small class="text-muted">
                                            <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }}">
                                                {{ $user->role == 'admin' ? 'مدير النظام' : 'مستخدم' }}
                                            </span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="security-item">
                                <div class="d-flex align-items-center">
                                    <div class="security-icon me-3">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">آخر نشاط</h6>
                                        <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .security-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .security-item:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }
    
    .security-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }
    
    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin: 0 auto 1rem;
    }
    
    .stats-icon.users { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stats-icon.orders { background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%); }
    
    .stats-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }
    
    .stats-label {
        color: #7f8c8d;
        font-size: 0.9rem;
        font-weight: 500;
    }
</style>
@endsection
