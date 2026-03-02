@extends('layouts.app')

@section('title', 'إنشاء حساب - هدية')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <!-- Card Header -->
                <div class="card-header text-center py-4 border-0" style="background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);">
                    <img src="{{ asset('images/logo.jpg') }}" alt="هدية" style="height: 55px; width: auto; border-radius: 10px;" class="mb-3" onerror="this.style.display='none'">
                    <h4 class="text-white mb-1 fw-bold">إنشاء حساب جديد</h4>
                    <p class="text-white-50 mb-0 small">انضم إلى منصة هدية للعمرة</p>
                </div>

                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">
                                        <i class="fas fa-user me-1 text-primary"></i> الاسم
                                    </label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name"
                                           value="{{ old('name') }}"
                                           required autocomplete="name" autofocus
                                           placeholder="الاسم الكامل"
                                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope me-1 text-primary"></i> البريد الإلكتروني
                                    </label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email"
                                           value="{{ old('email') }}"
                                           required autocomplete="email"
                                           placeholder="example@email.com"
                                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="country_code" class="form-label fw-semibold">
                                        <i class="fas fa-flag me-1 text-primary"></i> رمز الدولة
                                    </label>
                                    <select class="form-select @error('country_code') is-invalid @enderror"
                                            id="country_code" name="country_code"
                                            required
                                            style="border-radius: 10px; border: 2px solid #e9ecef;">
                                        <option value="+966" {{ old('country_code', '+966') == '+966' ? 'selected' : '' }}>🇸🇦 +966</option>
                                        <option value="+971" {{ old('country_code') == '+971' ? 'selected' : '' }}>🇦🇪 +971</option>
                                        <option value="+965" {{ old('country_code') == '+965' ? 'selected' : '' }}>🇰🇼 +965</option>
                                        <option value="+973" {{ old('country_code') == '+973' ? 'selected' : '' }}>🇧🇭 +973</option>
                                        <option value="+974" {{ old('country_code') == '+974' ? 'selected' : '' }}>🇶🇦 +974</option>
                                        <option value="+968" {{ old('country_code') == '+968' ? 'selected' : '' }}>🇴🇲 +968</option>
                                        <option value="+20" {{ old('country_code') == '+20' ? 'selected' : '' }}>🇪🇬 +20</option>
                                    </select>
                                    @error('country_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-semibold">
                                        <i class="fas fa-phone me-1 text-primary"></i> رقم الهاتف
                                    </label>
                                    <input type="text"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone"
                                           value="{{ old('phone') }}"
                                           required
                                           placeholder="501234567"
                                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="fas fa-lock me-1 text-primary"></i> كلمة المرور
                                    </label>
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password"
                                           required autocomplete="new-password"
                                           placeholder="••••••••"
                                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label fw-semibold">
                                        <i class="fas fa-lock me-1 text-primary"></i> تأكيد كلمة المرور
                                    </label>
                                    <input type="password"
                                           class="form-control"
                                           id="password-confirm" name="password_confirmation"
                                           required autocomplete="new-password"
                                           placeholder="••••••••"
                                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                                </div>
                            </div>
                        </div>

                        <!-- Hidden role field -->
                        <input type="hidden" name="role" value="user">

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold" style="border-radius: 12px; background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%); border: none;">
                                <i class="fas fa-user-plus me-2"></i>إنشاء الحساب
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                لديك حساب بالفعل؟
                                <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">
                                    تسجيل الدخول
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="fas fa-shield-alt me-1 text-success"></i> بياناتك محمية وآمنة
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
