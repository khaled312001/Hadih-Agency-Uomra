@extends('layouts.user')

@section('title', 'الملف الشخصي - هدية')
@section('page-title', 'الملف الشخصي')
@section('page-description', 'إدارة معلوماتك الشخصية وإعدادات الحساب')

@section('content')

<div class="row g-3">

    {{-- ===== LEFT COLUMN ===== --}}
    <div class="col-12 col-lg-4">

        {{-- Profile card --}}
        <div class="hd-profile-card mb-3">
            <div class="hd-profile-card__cover"></div>
            <div class="hd-profile-card__body">
                <div class="hd-profile-card__avatar">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/'.$user->profile_image) }}" alt="{{ $user->name }}">
                    @else
                        {{ mb_substr($user->name, 0, 1) }}
                    @endif
                </div>
                <div class="mt-3">
                    <div style="font-size:1.15rem;font-weight:800;color:#1e293b;">{{ $user->name }}</div>
                    <div style="font-size:.82rem;color:#94a3b8;margin:.2rem 0 .5rem;">{{ $user->email }}</div>
                    @if($user->phone)
                        <div style="font-size:.82rem;color:#64748b;" dir="ltr">{{ $user->country_code }} {{ $user->phone }}</div>
                    @endif
                    <div class="mt-2">
                        <span class="hd-badge hd-badge--{{ $user->role === 'admin' ? 'admin' : 'user' }}">
                            <i class="fas fa-{{ $user->role === 'admin' ? 'shield-alt' : 'user' }}"></i>
                            {{ $user->role === 'admin' ? 'مدير النظام' : 'مستخدم' }}
                        </span>
                    </div>
                    <div style="font-size:.78rem;color:#94a3b8;margin-top:.75rem;">
                        <i class="fas fa-calendar-alt me-1"></i>
                        عضو منذ {{ $user->created_at->format('Y/m/d') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Account Stats --}}
        <div class="hd-card">
            <div class="hd-card-header">
                <div class="hd-card-header__left">
                    <div class="hd-card-header__icon" style="background:var(--hd-grad-primary);">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <span class="hd-card-header__title">إحصائيات الحساب</span>
                </div>
            </div>
            <div class="hd-card-body--sm">
                <div class="row g-2 text-center">
                    <div class="col-6">
                        <div style="background:#f8fafc;border-radius:12px;padding:1rem .75rem;border:1px solid #f1f5f9;">
                            <div style="font-size:1.5rem;font-weight:800;color:#667eea;">{{ $user->orders()->count() }}</div>
                            <div style="font-size:.75rem;color:#94a3b8;font-weight:600;">إجمالي الطلبات</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="background:#f0fdf4;border-radius:12px;padding:1rem .75rem;border:1px solid #dcfce7;">
                            <div style="font-size:1.5rem;font-weight:800;color:#22c55e;">{{ $user->orders()->where('status','completed')->count() }}</div>
                            <div style="font-size:.75rem;color:#94a3b8;font-weight:600;">مكتملة</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="background:#eff6ff;border-radius:12px;padding:1rem .75rem;border:1px solid #dbeafe;">
                            <div style="font-size:1.5rem;font-weight:800;color:#3b82f6;">{{ $user->receivedMessages()->count() }}</div>
                            <div style="font-size:.75rem;color:#94a3b8;font-weight:600;">الرسائل</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="background:#fffbeb;border-radius:12px;padding:1rem .75rem;border:1px solid #fde68a;">
                            <div style="font-size:1.5rem;font-weight:800;color:#f59e0b;">{{ $user->receivedMessages()->where('is_read',false)->count() }}</div>
                            <div style="font-size:.75rem;color:#94a3b8;font-weight:600;">غير مقروءة</div>
                        </div>
                    </div>
                </div>

                {{-- Quick Nav --}}
                <div class="hd-divider"></div>
                <div class="d-grid gap-2">
                    <a href="{{ route('orders.index') }}" class="hd-btn hd-btn--outline-primary hd-btn--full">
                        <i class="fas fa-shopping-cart"></i> طلباتي
                    </a>
                    <a href="{{ route('messages.index') }}" class="hd-btn hd-btn--ghost hd-btn--full">
                        <i class="fas fa-envelope"></i> الرسائل
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== RIGHT COLUMN ===== --}}
    <div class="col-12 col-lg-8">

        {{-- Edit Profile --}}
        <div class="hd-form-section mb-3">
            <div class="hd-form-section__header">
                <div class="hd-form-section__header-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <div class="hd-form-section__header-title">تعديل الملف الشخصي</div>
                    <div style="font-size:.75rem;color:#94a3b8;">تحديث معلوماتك الأساسية</div>
                </div>
            </div>
            <div class="hd-form-section__body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="hd-form-group">
                                <label class="hd-label hd-label--required"><i class="fas fa-user"></i> الاسم الكامل</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-user"></i>
                                    <input type="text" name="name" class="hd-input @error('name') hd-input--error @enderror"
                                           value="{{ old('name',$user->name) }}" placeholder="أدخل اسمك الكامل" required>
                                </div>
                                @error('name')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="hd-form-group">
                                <label class="hd-label hd-label--required"><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-envelope"></i>
                                    <input type="email" name="email" class="hd-input @error('email') hd-input--error @enderror"
                                           value="{{ old('email',$user->email) }}" placeholder="example@email.com" required>
                                </div>
                                @error('email')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-5 col-md-4">
                            <div class="hd-form-group">
                                <label class="hd-label"><i class="fas fa-flag"></i> رمز الدولة</label>
                                <select name="country_code" class="hd-input hd-select">
                                    @foreach(['+966'=>'🇸🇦 +966','+971'=>'🇦🇪 +971','+965'=>'🇰🇼 +965','+973'=>'🇧🇭 +973','+974'=>'🇶🇦 +974','+968'=>'🇴🇲 +968','+20'=>'🇪🇬 +20','+962'=>'🇯🇴 +962'] as $code=>$label)
                                        <option value="{{ $code }}" {{ $user->country_code===$code?'selected':'' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="hd-form-group">
                                <label class="hd-label"><i class="fas fa-phone"></i> رقم الهاتف</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-phone"></i>
                                    <input type="tel" name="phone" class="hd-input @error('phone') hd-input--error @enderror"
                                           value="{{ old('phone',$user->phone) }}" placeholder="501234567">
                                </div>
                                @error('phone')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="hd-form-group">
                                <label class="hd-label"><i class="fas fa-image"></i> صورة الملف الشخصي</label>
                                <div class="hd-upload-zone" onclick="document.getElementById('profile_image').click()">
                                    <div class="hd-upload-zone__icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <div class="hd-upload-zone__title">اضغط لرفع صورة</div>
                                    <div class="hd-upload-zone__hint">PNG, JPG, GIF حتى 2MB</div>
                                </div>
                                <input type="file" id="profile_image" name="profile_image" accept="image/*" class="d-none" onchange="previewImage(this)">
                                <div id="imgPreview" class="mt-2 text-center d-none">
                                    <img id="previewImg" src="" style="max-height:100px;border-radius:12px;" alt="معاينة">
                                </div>
                                @error('profile_image')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap mt-1">
                        <button type="submit" class="hd-btn hd-btn--primary">
                            <i class="fas fa-save"></i> حفظ التغييرات
                        </button>
                        <a href="{{ route('home') }}" class="hd-btn hd-btn--secondary">
                            <i class="fas fa-arrow-right"></i> العودة
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Change Password --}}
        <div class="hd-form-section">
            <div class="hd-form-section__header" style="background:linear-gradient(135deg,#f97316,#fbbf24);">
                <div class="hd-form-section__header-icon">
                    <i class="fas fa-key"></i>
                </div>
                <div>
                    <div class="hd-form-section__header-title">تغيير كلمة المرور</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.75);">يُنصح بتغيير كلمة المرور دورياً</div>
                </div>
            </div>
            <div class="hd-form-section__body">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="hd-form-group">
                                <label class="hd-label"><i class="fas fa-lock"></i> كلمة المرور الحالية</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-lock"></i>
                                    <input type="password" id="cur_pass" name="current_password"
                                           class="hd-input hd-input--with-action @error('current_password') hd-input--error @enderror"
                                           placeholder="••••••••" required>
                                    <i class="hd-input-action fas fa-eye" onclick="togglePass('cur_pass',this)"></i>
                                </div>
                                @error('current_password')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="hd-form-group">
                                <label class="hd-label"><i class="fas fa-lock"></i> كلمة المرور الجديدة</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-lock"></i>
                                    <input type="password" id="new_pass" name="new_password"
                                           class="hd-input hd-input--with-action @error('new_password') hd-input--error @enderror"
                                           placeholder="••••••••" required>
                                    <i class="hd-input-action fas fa-eye" onclick="togglePass('new_pass',this)"></i>
                                </div>
                                @error('new_password')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="hd-form-group">
                                <label class="hd-label"><i class="fas fa-lock"></i> تأكيد كلمة المرور</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-lock"></i>
                                    <input type="password" id="confirm_pass" name="new_password_confirmation"
                                           class="hd-input hd-input--with-action"
                                           placeholder="••••••••" required>
                                    <i class="hd-input-action fas fa-eye" onclick="togglePass('confirm_pass',this)"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="hd-btn hd-btn--warning">
                        <i class="fas fa-key"></i> تغيير كلمة المرور
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
function togglePass(id, icon) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'text'
        ? 'hd-input-action fas fa-eye-slash'
        : 'hd-input-action fas fa-eye';
}
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imgPreview').classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
