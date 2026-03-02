@extends('layouts.app')

@section('title', 'تسجيل الدخول - هدية')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <!-- Card Header -->
                <div class="card-header text-center py-4 border-0" style="background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);">
                    <img src="{{ asset('images/logo.jpg') }}" alt="هدية" style="height: 55px; width: auto; border-radius: 10px;" class="mb-3" onerror="this.style.display='none'">
                    <h4 class="text-white mb-1 fw-bold">أهلاً وسهلاً</h4>
                    <p class="text-white-50 mb-0 small">سجل دخولك للمتابعة</p>
                </div>

                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-1 text-primary"></i> البريد الإلكتروني
                            </label>
                            <input type="email"
                                   class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   id="email" name="email"
                                   value="{{ old('email') }}"
                                   required autocomplete="email" autofocus
                                   placeholder="example@email.com"
                                   style="border-radius: 12px; border: 2px solid #e9ecef;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-1 text-primary"></i> كلمة المرور
                            </label>
                            <input type="password"
                                   class="form-control form-control-lg @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   required autocomplete="current-password"
                                   placeholder="••••••••"
                                   style="border-radius: 12px; border: 2px solid #e9ecef;">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">تذكرني</label>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold" style="border-radius: 12px; background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%); border: none;">
                                <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                ليس لديك حساب؟
                                <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">
                                    إنشاء حساب جديد
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Trust badges -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="fas fa-shield-alt me-1 text-success"></i> بياناتك محمية وآمنة
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
