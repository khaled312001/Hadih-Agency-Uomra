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
        
        /* Animated Gradient Background */
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(-45deg, #1e1b4b, #312e81, #4338ca, #3730a3);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            position: relative;
            overflow: hidden;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Abstract Shapes */
        .shape {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.6;
        }
        .shape-1 {
            width: 400px; height: 400px;
            background: #818cf8;
            top: -100px; left: -100px;
            border-radius: 50%;
            animation: float 8s ease-in-out infinite alternate;
        }
        .shape-2 {
            width: 500px; height: 500px;
            background: #c084fc;
            bottom: -150px; right: -100px;
            border-radius: 50%;
            animation: float 10s ease-in-out infinite alternate-reverse;
        }

        @keyframes float {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(-30px) scale(1.1); }
        }

        /* Glassmorphism Auth Card */
        .auth-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 1rem;
            position: relative;
            z-index: 10;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 28px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes slideUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header Re-styled */
        .auth-header {
            padding: 1.5rem 1.5rem 1rem;
            text-align: center;
            position: relative;
        }
        
        .admin-badge {
            display: inline-flex; align-items: center; gap: .4rem;
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            padding: .3rem .85rem;
            border-radius: 50px;
            font-size: .72rem; font-weight: 800;
            margin-bottom: 0.75rem;
            border: 1px solid rgba(79, 70, 229, 0.2);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
        }

        .auth-logo {
            width: 64px; height: 64px;
            background: #ffffff;
            border-radius: 18px;
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: 0.75rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 2px solid #f3f4f6;
        }
        .auth-logo img { height: 44px; border-radius: 12px; object-fit: contain; }

        .auth-header h3 { color: #1e1b4b; font-weight: 900; margin: 0; font-size: 1.35rem; letter-spacing: -0.5px; }
        .auth-header p { color: #6b7280; margin: .3rem 0 0; font-size: .82rem; font-weight: 500; }

        .auth-body { padding: 0 1.5rem 1.5rem; }

        /* Modern Input Fields */
        .input-wrap { position: relative; }
        .input-wrap .form-control {
            background: #f9fafb;
            border: 2px solid transparent;
            padding: 0.7rem 1rem 0.7rem 2.8rem;
            border-radius: 14px;
            font-size: .9rem;
            height: 48px;
            color: #1f2937;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }
        .input-wrap .form-control:focus { 
            background: #ffffff;
            border-color: #6366f1; 
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15); 
        }
        .input-wrap .ico { 
            position: absolute; right: 1.1rem; top: 50%; transform: translateY(-50%); 
            color: #9ca3af; font-size: 1.1rem; pointer-events: none; 
            transition: color 0.3s;
        }
        .input-wrap .form-control:focus ~ .ico { color: #6366f1; }
        
        .input-wrap .ico-left { 
            position: absolute; left: 1.1rem; top: 50%; transform: translateY(-50%); 
            color: #9ca3af; font-size: 1.1rem; cursor: pointer; transition: color .2s; 
        }
        .input-wrap .ico-left:hover { color: #6366f1; }
        
        .form-label { font-weight: 700; font-size: .8rem; color: #374151; margin-bottom: .25rem; }

        /* Premium Gradient Button */
        .btn-admin {
            width: 100%; height: 48px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border: none; border-radius: 14px; color: white;
            font-size: 1rem; font-weight: 800; transition: all .3s ease;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3); 
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: .6rem;
            position: relative; overflow: hidden;
        }
        .btn-admin::after {
            content: ''; position: absolute; top: 0; left: -100%; width: 50%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: .5s;
        }
        .btn-admin:hover::after { left: 100%; }
        .btn-admin:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(99, 102, 241, 0.4); filter: brightness(1.1); }
        .btn-admin:active { transform: scale(.98); }

        .separator { text-align: center; margin: 1rem 0; position: relative; }
        .separator::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #e5e7eb; }
        .separator span { background: #ffffff; position: relative; padding: 0 1rem; font-size: .85rem; color: #9ca3af; font-weight: 600; }

        .security-note {
            background: rgba(243, 244, 246, 0.6);
            border: 1px solid #e5e7eb; border-radius: 12px;
            padding: .65rem .85rem; margin-bottom: 1rem;
            display: flex; align-items: center; gap: .7rem;
            font-size: .78rem; color: #4b5563; font-weight: 600;
        }
        .security-note i { color: #10b981; font-size: 1rem; flex-shrink: 0; }
        
        .copyright {
            color: rgba(255,255,255,0.6);
            font-size: .8rem;
            font-weight: 500;
            margin-top: 1.5rem;
            display: flex; gap: .3rem; align-items: center; justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Animated Shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="auth-wrapper">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <div class="admin-badge">
                    <i class="fas fa-shield-alt"></i> منطقة الإدارة المحمية
                </div>
                <div class="auth-logo">
                    <img src="{{ asset('images/logo.jpg') }}" alt="هدية" onerror="this.style.display='none';this.parentElement.innerHTML='<i class=\'fas fa-user-shield\' style=\'font-size: 2rem; color: #4f46e5;\'></i>'">
                </div>
                <h3>تسجيل دخول الإدارة</h3>
                <p>للمسؤولين المخوّلين فقط</p>
            </div>

            <!-- Body -->
            <div class="auth-body">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" style="border-radius:12px;font-size:.875rem; background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b;" role="alert">
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
                            <input type="email" id="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="admin@hadiah.com"
                                   required autocomplete="email" autofocus>
                            <i class="fas fa-user-shield ico"></i>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">كلمة المرور</label>
                        <div class="input-wrap">
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="أدخل كلمة مرور الإدارة"
                                   required autocomplete="current-password">
                            <i class="fas fa-key ico"></i>
                            <i class="fas fa-eye ico-left" id="togglePass" onclick="togglePassword()"></i>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember" style="font-size:.85rem;color:#4b5563;cursor:pointer;font-weight:600;">تذكر دخولي</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-admin">
                        <i class="fas fa-sign-in-alt"></i> دخول لوحة الإدارة
                    </button>

                    <div class="separator"><span>أو</span></div>

                    <div class="text-center">
                        <a href="{{ route('login') }}" style="font-size:.9rem;color:#4f46e5;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem; transition: color 0.3s;">
                            <i class="fas fa-user"></i> تسجيل دخول المستخدم العادي
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="copyright">
            <i class="fas fa-shield-alt"></i> الدخول غير المصرح به ممنوع قانونياً &copy; {{ date('Y') }}
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
