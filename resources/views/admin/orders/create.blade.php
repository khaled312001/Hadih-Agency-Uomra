@extends('layouts.admin')

@section('title', 'إضافة طلب جديد')
@section('page-title', 'إضافة طلب جديد')
@section('page-description', 'أضف طلب جديد إلى النظام')

@section('page-actions')
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary hover-lift">
        <i class="fas fa-arrow-right me-2"></i>العودة للطلبات
    </a>
@endsection

@section('content')
    <div class="content-card">
        <div class="p-4">
            <form method="POST" action="{{ route('admin.orders.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="umrah_package_id" class="form-label">حزمة العمرة <span class="text-danger">*</span></label>
                            <select class="form-select @error('umrah_package_id') is-invalid @enderror" id="umrah_package_id" name="umrah_package_id" required>
                                <option value="">اختر حزمة العمرة</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->id }}" {{ old('umrah_package_id') == $package->id ? 'selected' : '' }}>
                                        {{ $package->name_ar }} - {{ number_format($package->price) }} {{ $package->currency }}
                                    </option>
                                @endforeach
                            </select>
                            @error('umrah_package_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">المستخدم <span class="text-danger">*</span></label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">اختر المستخدم</option>
                                @foreach(\App\Models\User::where('role', 'user')->get() as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="beneficiary_name" class="form-label">اسم المستفيد <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('beneficiary_name') is-invalid @enderror" id="beneficiary_name" name="beneficiary_name" value="{{ old('beneficiary_name') }}" required>
                            @error('beneficiary_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="beneficiary_phone" class="form-label">هاتف المستفيد <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('beneficiary_phone') is-invalid @enderror" id="beneficiary_phone" name="beneficiary_phone" value="{{ old('beneficiary_phone') }}" required>
                            @error('beneficiary_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- WhatsApp Phone Section -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fab fa-whatsapp text-success"></i>
                        رقم واتساب للتواصل وإرسال فيديو الإثبات <span class="text-danger">*</span>
                    </label>
                    <div class="row">
                        <div class="col-md-4">
                            <select class="form-select @error('whatsapp_country_code') is-invalid @enderror" id="whatsapp_country_code" name="whatsapp_country_code" required>
                                <option value="">كود الدولة</option>
                                <option value="+966" {{ old('whatsapp_country_code') == '+966' ? 'selected' : '' }}>🇸🇦 السعودية (+966)</option>
                                <option value="+971" {{ old('whatsapp_country_code') == '+971' ? 'selected' : '' }}>🇦🇪 الإمارات (+971)</option>
                                <option value="+965" {{ old('whatsapp_country_code') == '+965' ? 'selected' : '' }}>🇰🇼 الكويت (+965)</option>
                                <option value="+973" {{ old('whatsapp_country_code') == '+973' ? 'selected' : '' }}>🇧🇭 البحرين (+973)</option>
                                <option value="+974" {{ old('whatsapp_country_code') == '+974' ? 'selected' : '' }}>🇶🇦 قطر (+974)</option>
                                <option value="+968" {{ old('whatsapp_country_code') == '+968' ? 'selected' : '' }}>🇴🇲 عمان (+968)</option>
                                <option value="+20" {{ old('whatsapp_country_code') == '+20' ? 'selected' : '' }}>🇪🇬 مصر (+20)</option>
                                <option value="+212" {{ old('whatsapp_country_code') == '+212' ? 'selected' : '' }}>🇲🇦 المغرب (+212)</option>
                                <option value="+213" {{ old('whatsapp_country_code') == '+213' ? 'selected' : '' }}>🇩🇿 الجزائر (+213)</option>
                                <option value="+216" {{ old('whatsapp_country_code') == '+216' ? 'selected' : '' }}>🇹🇳 تونس (+216)</option>
                                <option value="+218" {{ old('whatsapp_country_code') == '+218' ? 'selected' : '' }}>🇱🇾 ليبيا (+218)</option>
                                <option value="+249" {{ old('whatsapp_country_code') == '+249' ? 'selected' : '' }}>🇸🇩 السودان (+249)</option>
                                <option value="+964" {{ old('whatsapp_country_code') == '+964' ? 'selected' : '' }}>🇮🇶 العراق (+964)</option>
                                <option value="+963" {{ old('whatsapp_country_code') == '+963' ? 'selected' : '' }}>🇸🇾 سوريا (+963)</option>
                                <option value="+961" {{ old('whatsapp_country_code') == '+961' ? 'selected' : '' }}>🇱🇧 لبنان (+961)</option>
                                <option value="+962" {{ old('whatsapp_country_code') == '+962' ? 'selected' : '' }}>🇯🇴 الأردن (+962)</option>
                                <option value="+1" {{ old('whatsapp_country_code') == '+1' ? 'selected' : '' }}>🇺🇸 الولايات المتحدة (+1)</option>
                                <option value="+44" {{ old('whatsapp_country_code') == '+44' ? 'selected' : '' }}>🇬🇧 المملكة المتحدة (+44)</option>
                            </select>
                            @error('whatsapp_country_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <input type="tel" class="form-control @error('whatsapp_phone') is-invalid @enderror" id="whatsapp_phone" name="whatsapp_phone" value="{{ old('whatsapp_phone') }}" placeholder="أدخل رقم الواتساب بدون كود الدولة" required>
                            @error('whatsapp_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle"></i>
                        يجب توافر رقم واتساب لإرسال فيديو الإثبات والتواصل عليه
                    </small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="beneficiary_type" class="form-label">نوع المستفيد <span class="text-danger">*</span></label>
                            <select class="form-select @error('beneficiary_type') is-invalid @enderror" id="beneficiary_type" name="beneficiary_type" required>
                                <option value="">اختر نوع المستفيد</option>
                                <option value="deceased" {{ old('beneficiary_type') == 'deceased' ? 'selected' : '' }}>متوفى</option>
                                <option value="sick" {{ old('beneficiary_type') == 'sick' ? 'selected' : '' }}>مريض</option>
                                <option value="elderly" {{ old('beneficiary_type') == 'elderly' ? 'selected' : '' }}>مسن</option>
                                <option value="disabled" {{ old('beneficiary_type') == 'disabled' ? 'selected' : '' }}>معاق</option>
                            </select>
                            @error('beneficiary_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">حالة الطلب</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                <option value="assigned" {{ old('status') == 'assigned' ? 'selected' : '' }}>تم التخصيص</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="beneficiary_address" class="form-label">عنوان المستفيد</label>
                    <textarea class="form-control @error('beneficiary_address') is-invalid @enderror" id="beneficiary_address" name="beneficiary_address" rows="3" placeholder="أدخل عنوان المستفيد">{{ old('beneficiary_address') }}</textarea>
                    @error('beneficiary_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="beneficiary_details" class="form-label">تفاصيل إضافية</label>
                    <textarea class="form-control @error('beneficiary_details') is-invalid @enderror" id="beneficiary_details" name="beneficiary_details" rows="3" placeholder="أدخل أي تفاصيل إضافية حول المستفيد">{{ old('beneficiary_details') }}</textarea>
                    @error('beneficiary_details')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">ملاحظات</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="أدخل أي ملاحظات حول الطلب">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>إنشاء الطلب
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const whatsappPhoneInput = document.getElementById('whatsapp_phone');
        const whatsappCountryCodeSelect = document.getElementById('whatsapp_country_code');

        if (whatsappPhoneInput && whatsappCountryCodeSelect) {
            whatsappPhoneInput.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                const maxLengths = { '+966': 9, '+971': 9, '+965': 8, '+973': 8, '+974': 8, '+968': 8, '+20': 10, '+1': 10, '+44': 10 };
                const selectedCode = whatsappCountryCodeSelect.value;
                const maxLength = maxLengths[selectedCode] || 15;
                this.value = value.substring(0, maxLength);
            });

            whatsappCountryCodeSelect.addEventListener('change', function() {
                const placeholders = { '+966': 'مثال: 501234567', '+971': 'مثال: 501234567', '+965': 'مثال: 12345678', '+20': 'مثال: 1012345678', '+1': 'مثال: 1234567890', '+44': 'مثال: 1234567890' };
                whatsappPhoneInput.placeholder = placeholders[this.value] || 'أدخل رقم الواتساب بدون كود الدولة';
            });
        }
    });
</script>
@endsection
