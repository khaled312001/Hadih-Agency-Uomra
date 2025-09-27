@extends('layouts.user')

@section('title', 'الملف الشخصي - هدية')
@section('page-title', 'الملف الشخصي')
@section('page-description', 'إدارة معلوماتك الشخصية وإعدادات الحساب')

@section('content')
<div class="row">
    <div class="col-lg-4 mb-4">
        <!-- Profile Card -->
        <div class="chart-container">
            <div class="text-center">
                <div class="mb-3">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" 
                             class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 120px; height: 120px;">
                            <i class="fas fa-user fa-3x text-white"></i>
                        </div>
                    @endif
                </div>
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                <p class="text-muted">{{ $user->country_code }} {{ $user->phone }}</p>
                
                <div class="mt-3">
                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }} fs-6">
                        {{ $user->role === 'admin' ? 'مدير' : 'مستخدم' }}
                    </span>
                </div>
                
                <div class="mt-4">
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        عضو منذ {{ $user->created_at->format('Y-m-d') }}
                    </small>
                </div>
            </div>
        </div>
        
        <!-- Account Stats -->
        <div class="chart-container">
            <h5 class="mb-3">
                <i class="fas fa-chart-bar me-2 text-primary"></i>
                إحصائيات الحساب
            </h5>
            
            <div class="row text-center">
                <div class="col-6 mb-3">
                    <div class="border-end">
                        <h4 class="text-primary mb-1">{{ $user->orders()->count() }}</h4>
                        <small class="text-muted">إجمالي الطلبات</small>
                    </div>
                </div>
                <div class="col-6 mb-3">
                    <h4 class="text-success mb-1">{{ $user->orders()->where('status', 'completed')->count() }}</h4>
                    <small class="text-muted">طلبات مكتملة</small>
                </div>
                <div class="col-6">
                    <div class="border-end">
                        <h4 class="text-info mb-1">{{ $user->receivedMessages()->count() }}</h4>
                        <small class="text-muted">الرسائل</small>
                    </div>
                </div>
                <div class="col-6">
                    <h4 class="text-warning mb-1">{{ $user->receivedMessages()->where('is_read', false)->count() }}</h4>
                    <small class="text-muted">غير مقروءة</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <!-- Edit Profile Form -->
        <div class="chart-container">
            <h5 class="mb-3">
                <i class="fas fa-user-edit me-2 text-primary"></i>
                تعديل الملف الشخصي
            </h5>
            
            <form method="POST" action="{{ route('profile.update') }}">
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
                    <div class="col-md-4 mb-3">
                        <label for="country_code" class="form-label">رمز الدولة</label>
                        <select class="form-select @error('country_code') is-invalid @enderror" 
                                id="country_code" name="country_code">
                            <option value="+966" {{ $user->country_code === '+966' ? 'selected' : '' }}>+966 (السعودية)</option>
                            <option value="+971" {{ $user->country_code === '+971' ? 'selected' : '' }}>+971 (الإمارات)</option>
                            <option value="+965" {{ $user->country_code === '+965' ? 'selected' : '' }}>+965 (الكويت)</option>
                            <option value="+973" {{ $user->country_code === '+973' ? 'selected' : '' }}>+973 (البحرين)</option>
                            <option value="+974" {{ $user->country_code === '+974' ? 'selected' : '' }}>+974 (قطر)</option>
                            <option value="+968" {{ $user->country_code === '+968' ? 'selected' : '' }}>+968 (عمان)</option>
                            <option value="+20" {{ $user->country_code === '+20' ? 'selected' : '' }}>+20 (مصر)</option>
                        </select>
                        @error('country_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-8 mb-3">
                        <label for="phone" class="form-label">رقم الهاتف</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="profile_image" class="form-label">صورة الملف الشخصي</label>
                    <input type="file" class="form-control @error('profile_image') is-invalid @enderror" 
                           id="profile_image" name="profile_image" accept="image/*">
                    @error('profile_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">يمكنك رفع صورة شخصية (اختياري)</div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>حفظ التغييرات
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>العودة للداشبورد
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Change Password -->
        <div class="chart-container">
            <h5 class="mb-3">
                <i class="fas fa-lock me-2 text-warning"></i>
                تغيير كلمة المرور
            </h5>
            
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="new_password" class="form-label">كلمة المرور الجديدة</label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                               id="new_password" name="new_password" required>
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
                    <input type="password" class="form-control" 
                           id="new_password_confirmation" name="new_password_confirmation" required>
                </div>
                
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-key me-2"></i>تغيير كلمة المرور
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
