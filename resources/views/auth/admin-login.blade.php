<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول الإدارة - هدية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        * { font-family: 'Cairo', sans-serif; }
        body {
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .auth-wrapper {
            width: 100%;
            max-width: 440px;
            padding: 1.5rem;
            position: relative;
            z-index: 1;
        }
        .auth-card {
            background: rgba(255,255,255,.97);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,.4);
            overflow: hidden;
        }
        .auth-header {
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 100%);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .auth-header::before {
            content:'';position:absolute;top:-50px;right:-50px;
            width:180px;height:180px;
            background:rgba(167,139,250,.12);border-radius:50%;
        }
        .admin-badge {
            display:inline-flex;align-items:center;gap:.4rem;
            background:rgba(167,139,250,.15);
            border:1px solid rgba(167,139,250,.3);
            border-radius:50px;
            padding:.3rem .9rem;
            font-size:.75rem;font-weight:700;color:#a78bfa;
            margin-bottom:1rem;
            position:relative;z-index:1;
        }
        .auth-logo {
            width:76px;height:76px;
            background:rgba(255,255,255,.08);
            border-radius:20px;
            display:inline-flex;align-items:center;justify-content:center;
            margin-bottom:1rem;
            border:2px solid rgba(255,255,255,.12);
            position:relative;z-index:1;
        }
        .auth-logo img { height:52px;border-radius:12px; }
        .auth-logo i { font-size:2.2rem;color:#a78bfa; }
        .auth-header h3 { color:#fff;font-weight:800;margin:0;font-size:1.35rem;position:relative;z-index:1; }
        .auth-header p { color:rgba(255,255,255,.5);margin:.3rem 0 0;font-size:.85rem;position:relative;z-index:1; }

        .auth-body { padding: 2rem; }

        .input-wrap { position:relative; }
        .input-wrap .form-control {
            padding-right:2.6rem;
            border:2px solid #e2e8f0;
            border-radius:12px;font-size:.9rem;height:48px;transition:all .2s;
        }
        .input-wrap .form-control:focus { border-color:#667eea;box-shadow:0 0 0 3px rgba(102,126,234,.12); }
        .input-wrap .ico { position:absolute;right:.9rem;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:.9rem;pointer-events:none; }
        .input-wrap .ico-left { position:absolute;left:.9rem;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:.9rem;cursor:pointer;transition:color .2s; }
        .input-wrap .ico-left:hover { color:#667eea; }
        .input-wrap .form-control.pl { padding-left:2.6rem; }
        .form-label { font-weight:700;font-size:.8rem;color:#374151;margin-bottom:.35rem; }

        .btn-admin {
            width:100%;height:50px;
            background:linear-gradient(135deg,#0f0c29,#302b63);
            border:none;border-radius:14px;color:white;
            font-size:1rem;font-weight:700;transition:all .25s;
            box-shadow:0 4px 18px rgba(48,43,99,.5);cursor:pointer;
            font-family:'Cairo',sans-serif;
            display:flex;align-items:center;justify-content:center;gap:.5rem;
        }
        .btn-admin:hover { filter:brightness(1.2);transform:translateY(-2px);box-shadow:0 6px 24px rgba(48,43,99,.65); }
        .btn-admin:active { transform:scale(.98); }

        .separator { text-align:center;margin:1.25rem 0;position:relative; }
        .separator::before { content:'';position:absolute;top:50%;left:0;right:0;height:1px;background:#e2e8f0; }
        .separator span { background:#fff;position:relative;padding:0 .75rem;font-size:.8rem;color:#94a3b8; }

        .security-note {
            background:#faf5ff;border:1px solid #ede9fe;border-radius:12px;
            padding:.85rem 1rem;margin-bottom:1.25rem;
            display:flex;align-items:center;gap:.6rem;
            font-size:.82rem;color:#5b21b6;font-weight:600;
        }
        .security-note i { color:#8b5cf6;font-size:1rem;flex-shrink:0; }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card">
        <!-- Header -->
        <div class="auth-header">
            <div class="admin-badge">
                <i class="fas fa-shield-alt"></i> منطقة الإدارة المحمية
            </div>
            <br>
            <div class="auth-logo">
                <img src="{{ asset('images/logo.jpg') }}" alt="هدية" onerror="this.style.display='none';this.parentElement.innerHTML='<i class=\'fas fa-user-shield\'></i>'">
            </div>
            <h3>تسجيل دخول الإدارة</h3>
            <p>للمسؤولين المخوّلين فقط</p>
        </div>

        <!-- Body -->
        <div class="auth-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" style="border-radius:12px;font-size:.875rem;" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="security-note">
                <i class="fas fa-lock"></i>
                هذه الصفحة مخصصة للمدراء المخوّلين فقط. يتم تسجيل جميع محاولات الدخول.
            </div>

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label">البريد الإلكتروني للمدير</label>
                    <div class="input-wrap">
                        <i class="fas fa-user-shield ico"></i>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="admin@hadiah.com"
                               required autocomplete="email" autofocus>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">كلمة المرور</label>
                    <div class="input-wrap">
                        <i class="fas fa-key ico"></i>
                        <input type="password" id="password" name="password"
                               class="form-control pl @error('password') is-invalid @enderror"
                               placeholder="أدخل كلمة مرور الإدارة"
                               required autocomplete="current-password">
                        <i class="fas fa-eye ico-left" id="togglePass" onclick="togglePassword()"></i>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember" style="font-size:.85rem;color:#64748b;cursor:pointer;">تذكرني</label>
                    </div>
                </div>

                <button type="submit" class="btn-admin">
                    <i class="fas fa-sign-in-alt"></i> دخول لوحة الإدارة
                </button>

                <div class="separator"><span>أو</span></div>

                <div class="text-center">
                    <a href="{{ route('login') }}" style="font-size:.875rem;color:#667eea;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:.35rem;">
                        <i class="fas fa-user"></i> تسجيل دخول المستخدم العادي
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mt-3">
        <small style="color:rgba(255,255,255,.35);font-size:.78rem;">
            <i class="fas fa-shield-alt me-1"></i> الدخول غير المصرح به ممنوع قانونياً
        </small>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('togglePass');
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'text' ? 'fas fa-eye-slash ico-left' : 'fas fa-eye ico-left';
}
</script>
</body>
</html>
