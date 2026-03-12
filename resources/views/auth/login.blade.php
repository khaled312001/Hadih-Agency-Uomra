<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - هدية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        * { font-family: 'Cairo', sans-serif; }
        body { background: #f0f2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; }

        .auth-wrapper {
            width: 100%;
            max-width: 460px;
            padding: 1.5rem;
        }

        .auth-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 48px rgba(0,0,0,.12);
            overflow: hidden;
        }

        .auth-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .auth-header::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 140px; height: 140px;
            background: rgba(102,126,234,.15);
            border-radius: 50%;
        }
        .auth-header::after {
            content: '';
            position: absolute;
            bottom: -30px; left: -30px;
            width: 100px; height: 100px;
            background: rgba(118,75,162,.15);
            border-radius: 50%;
        }
        .auth-logo {
            position: relative; z-index: 1;
            width: 72px; height: 72px;
            background: rgba(255,255,255,.1);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            border: 2px solid rgba(255,255,255,.15);
        }
        .auth-logo img { height: 50px; width: auto; border-radius: 12px; }
        .auth-logo i { font-size: 2rem; color: #a78bfa; }
        .auth-header h3 { color: #fff; font-weight: 800; margin: 0; font-size: 1.4rem; position: relative; z-index: 1; }
        .auth-header p { color: rgba(255,255,255,.55); margin: .35rem 0 0; font-size: .88rem; position: relative; z-index: 1; }

        .auth-body { padding: 2rem; }

        .input-group-icon {
            position: relative;
        }
        .input-group-icon .form-control {
            padding-right: 2.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: .9rem;
            height: 48px;
            transition: all .2s;
        }
        .input-group-icon .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,.12);
        }
        .input-group-icon .input-icon {
            position: absolute;
            right: .9rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: .9rem;
            pointer-events: none;
        }
        .input-group-icon .input-icon-left {
            position: absolute;
            left: .9rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: .9rem;
            cursor: pointer;
            transition: color .2s;
        }
        .input-group-icon .input-icon-left:hover { color: #667eea; }
        .input-group-icon .form-control.has-left { padding-left: 2.75rem; }

        .form-label { font-weight: 700; font-size: .82rem; color: #374151; margin-bottom: .4rem; }

        .btn-auth {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 14px;
            color: white;
            font-size: 1rem;
            font-weight: 700;
            transition: all .25s;
            box-shadow: 0 4px 18px rgba(102,126,234,.4);
            cursor: pointer;
            font-family: 'Cairo', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }
        .btn-auth:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(102,126,234,.5); filter: brightness(1.06); }
        .btn-auth:active { transform: scale(.98); }

        .divider-text { text-align: center; position: relative; margin: 1.25rem 0; }
        .divider-text::before {
            content: '';
            position: absolute;
            top: 50%; left: 0; right: 0;
            height: 1px;
            background: #e2e8f0;
        }
        .divider-text span { background: #fff; position: relative; padding: 0 .75rem; font-size: .8rem; color: #94a3b8; }

        .trust-badge { text-align: center; margin-top: 1.5rem; font-size: .8rem; color: #94a3b8; }
        .trust-badge i { color: #22c55e; }

        .alert { border-radius: 12px; font-size: .875rem; }

        @media (max-width: 480px) {
            .auth-wrapper { padding: 1rem; }
            .auth-body { padding: 1.5rem; }
            .auth-header { padding: 2rem 1.5rem 1.5rem; }
        }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <!-- Back to home -->
    <div class="text-center mb-3">
        <a href="{{ url('/') }}" style="font-size:.85rem;color:#64748b;text-decoration:none;display:inline-flex;align-items:center;gap:.35rem;">
            <i class="fas fa-arrow-right"></i> العودة للرئيسية
        </a>
    </div>

    <div class="auth-card">
        <!-- Header -->
        <div class="auth-header">
            <div class="auth-logo">
                <img src="{{ asset('images/logo.jpg') }}" alt="هدية" onerror="this.style.display='none';this.parentElement.innerHTML='<i class=\'fas fa-kaaba\'></i>'">
            </div>
            <h3>أهلاً وسهلاً</h3>
            <p>سجّل دخولك للمتابعة إلى منصة هدية</p>
        </div>

        <!-- Body -->
        <div class="auth-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label">
                        البريد الإلكتروني
                    </label>
                    <div class="input-group-icon">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="example@email.com"
                               required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">
                        كلمة المرور
                    </label>
                    <div class="input-group-icon">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password"
                               class="form-control has-left @error('password') is-invalid @enderror"
                               placeholder="أدخل كلمة المرور"
                               required autocomplete="current-password">
                        <i class="fas fa-eye input-icon-left" id="togglePass" onclick="togglePassword('password','togglePass')"></i>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember" style="font-size:.85rem;color:#64748b;cursor:pointer;">تذكرني</label>
                    </div>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:.85rem;color:#667eea;text-decoration:none;font-weight:600;">نسيت كلمة المرور؟</a>
                    @endif
                </div>

                <button type="submit" class="btn-auth">
                    <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
                </button>

                <div class="divider-text">
                    <span>أو</span>
                </div>

                <div class="text-center" style="font-size:.9rem;color:#64748b;">
                    ليس لديك حساب؟
                    <a href="{{ route('register') }}" style="color:#667eea;font-weight:700;text-decoration:none;">إنشاء حساب جديد</a>
                </div>
            </form>
        </div>
    </div>

    <div class="trust-badge">
        <i class="fas fa-shield-alt"></i> بياناتك محمية وآمنة تماماً
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash input-icon-left';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye input-icon-left';
    }
}
</script>
</body>
</html>
