@extends('layouts.app')

@section('title', 'إنشاء طلب عمرة جديد - هدية')

@section('styles')
<style>
    :root {
        --wizard-primary: #6366f1;
        --wizard-secondary: #f8fafc;
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.4);
    }

    body {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        min-height: 100vh;
    }

    .wizard-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 15px;
    }

    .wizard-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Progress Stepper */
    .stepper {
        display: flex;
        justify-content: space-between;
        padding: 30px 40px;
        background: rgba(255, 255, 255, 0.5);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .step-item {
        flex: 1;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .step-item::after {
        content: '';
        position: absolute;
        top: 20px;
        left: 50%;
        width: 100%;
        height: 2px;
        background: #e2e8f0;
        z-index: -1;
    }

    .step-item:last-child::after {
        display: none;
    }

    .step-icon {
        width: 40px;
        height: 40px;
        line-height: 40px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #e2e8f0;
        margin: 0 auto 10px;
        font-weight: 700;
        color: #94a3b8;
        transition: all 0.3s ease;
    }

    .step-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        transition: all 0.3s ease;
    }

    .step-item.active .step-icon {
        background: var(--wizard-primary);
        border-color: var(--wizard-primary);
        color: #fff;
        box-shadow: 0 0 0 5px rgba(99, 102, 241, 0.2);
    }

    .step-item.active .step-label {
        color: var(--wizard-primary);
    }

    .step-item.completed .step-icon {
        background: #10b981;
        border-color: #10b981;
        color: #fff;
    }

    .step-item.completed::after {
        background: #10b981;
    }

    /* Form Content */
    .wizard-content {
        padding: 40px;
    }

    .step-pane {
        display: none;
        animation: slideFade 0.5s ease-out;
    }

    .step-pane.active {
        display: block;
    }

    @keyframes slideFade {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Package Cards */
    .package-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }

    .package-card {
        border: 2px solid #f1f5f9;
        border-radius: 16px;
        padding: 24px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fff;
        position: relative;
    }

    .package-card:hover {
        border-color: var(--wizard-primary);
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    .package-card.selected {
        border-color: var(--wizard-primary);
        background: rgba(99, 102, 241, 0.04);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .package-card.selected::before {
        content: '\f058';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        top: 15px;
        left: 15px;
        color: var(--wizard-primary);
        font-size: 1.2rem;
    }

    .package-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--wizard-primary);
        margin-bottom: 5px;
    }

    /* Inputs */
    .form-label {
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #1e293b;
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        background: rgba(255,255,255,0.8);
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: var(--wizard-primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        background: #fff;
    }

    /* Buttons */
    .btn-wizard {
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s;
    }

    .btn-next {
        background: var(--wizard-primary);
        color: #fff;
        border: none;
    }

    .btn-next:hover {
        background: #4f46e5;
        transform: scale(1.02);
        color: #fff;
    }

    .btn-prev {
        background: #f1f5f9;
        color: #64748b;
        border: none;
    }

    .btn-prev:hover {
        background: #e2e8f0;
    }

    .summary-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        border: 1px dashed #cbd5e1;
    }

    @media (max-width: 768px) {
        .stepper { padding: 20px; }
        .step-label { display: none; }
        .wizard-content { padding: 25px; }
    }
</style>
@endsection

@section('content')
<div class="wizard-container">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-dark">طلب عمرة جديدة</h2>
        <p class="text-muted">أكمل الخطوات التالية لإرسال طلبك</p>
    </div>

    <div class="wizard-card" id="wizard">
        {{-- Stepper Progress --}}
        <div class="stepper">
            <div class="step-item active" data-step="1">
                <div class="step-icon">1</div>
                <div class="step-label">الحزمة</div>
            </div>
            @guest
            <div class="step-item" data-step="2">
                <div class="step-icon">2</div>
                <div class="step-label">بياناتك</div>
            </div>
            @endguest
            <div class="step-item" data-step="3">
                <div class="step-icon">{{ auth()->check() ? '2' : '3' }}</div>
                <div class="step-label">المستفيد</div>
            </div>
            <div class="step-item" data-step="4">
                <div class="step-icon">{{ auth()->check() ? '3' : '4' }}</div>
                <div class="step-label">تأكيد</div>
            </div>
        </div>

        <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
            @csrf
            <input type="hidden" name="umrah_package_id" id="package_id_input" required>

            <div class="wizard-content">
                {{-- Step 1: Package Selection --}}
                <div class="step-pane active" id="step1">
                    <h4 class="fw-bold mb-4"><i class="fas fa-kaaba text-primary me-2"></i> اختر حزمة العمرة</h4>
                    <div class="package-grid">
                        @foreach($packages as $package)
                        <div class="package-card" data-id="{{ $package->id }}" data-price="{{ $package->price }}" data-currency="{{ $package->currency }}" data-name="{{ $package->name_ar }}">
                            <div class="package-price">{{ number_format($package->price) }} <small>{{ $package->currency }}</small></div>
                            <h5 class="fw-bold mb-2">{{ $package->name_ar }}</h5>
                            <p class="text-muted small mb-0">{{ Str::limit($package->description_ar, 100) }}</p>
                            <div class="mt-3">
                                <span class="badge bg-light text-dark shadow-sm"><i class="far fa-clock me-1"></i> {{ $package->duration }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Step 2: Applicant Details (Only for Guests) --}}
                @guest
                <div class="step-pane" id="step2">
                    <h4 class="fw-bold mb-4"><i class="fas fa-user-tag text-primary me-2"></i> معلوماتك الشخصية</h4>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">الاسم الكامل</label>
                            <input type="text" name="customer_name" class="form-control" placeholder="أدخل اسمك الكامل">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="customer_email" class="form-control" placeholder="email@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رقم الجوال</label>
                            <input type="tel" name="customer_phone" class="form-control" placeholder="05xxxxxxxx">
                        </div>
                    </div>
                </div>
                @endguest

                {{-- Step 3: Beneficiary Details --}}
                <div class="step-pane" id="step3">
                    <h4 class="fw-bold mb-4"><i class="fas fa-heart text-primary me-2"></i> بيانات المستفيد (المهدى إليه)</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">اسم المستفيد</label>
                            <input type="text" name="beneficiary_name" class="form-control" placeholder="الاسم الذي سيُذكر في العمرة" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رقم هاتف المستفيد</label>
                            <input type="tel" name="beneficiary_phone" class="form-control" placeholder="05xxxxxxxx" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">كود واتساب</label>
                            <select name="whatsapp_country_code" class="form-select" required>
                                @foreach(['+966'=>'🇸🇦 +966','+971'=>'🇦🇪 +971','+965'=>'🇰🇼 +965','+973'=>'🇧🇭 +973','+974'=>'🇶🇦 +974','+968'=>'🇴🇲 +968','+20'=>'🇪🇬 +20'] as $code=>$label)
                                    <option value="{{ $code }}" {{ $code === '+966' ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">رقم واتساب (لإرسال فيديو الإثبات)</label>
                            <input type="tel" name="whatsapp_phone" class="form-control" placeholder="رقم الواتساب" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">حالة المستفيد</label>
                            <select name="beneficiary_type" class="form-select" required>
                                <option value="deceased">متوفى</option>
                                <option value="sick">مريض</option>
                                <option value="elderly">مسن</option>
                                <option value="disabled">معاق</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">أي تفاصيل إضافية</label>
                            <input type="text" name="beneficiary_details" class="form-control" placeholder="مثلاً: صلة القرابة">
                        </div>
                    </div>
                </div>

                {{-- Step 4: Notes & Review --}}
                <div class="step-pane" id="step4">
                    <h4 class="fw-bold mb-4"><i class="fas fa-check-circle text-primary me-2"></i> مراجعة الطلب وتأكيده</h4>
                    <div class="summary-box mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">الحزمة المختارة:</span>
                            <span class="fw-bold" id="summary-pkg-name">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">المستفيد:</span>
                            <span class="fw-bold" id="summary-ben-name">-</span>
                        </div>
                        <div class="d-flex justify-content-between pt-2 border-top">
                            <span class="text-dark fw-bold">الإجمالي:</span>
                            <span class="text-primary fw-bold fs-5" id="summary-total">-</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات إضافية (اختياري)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="أي تعليمات خاصة للمنفذ..."></textarea>
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label small" for="terms">
                            أقر بصحة البيانات المدخلة وأوافق على شروط الخدمة.
                        </label>
                    </div>
                </div>

                {{-- Navigation Buttons --}}
                <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                    <button type="button" class="btn btn-wizard btn-prev d-none" id="prevBtn">
                        <i class="fas fa-chevron-right me-2"></i> السابق
                    </button>
                    <button type="button" class="btn btn-wizard btn-next ms-auto" id="nextBtn">
                        التالي <i class="fas fa-chevron-left ms-2"></i>
                    </button>
                    <button type="submit" class="btn btn-wizard btn-next ms-auto d-none" id="submitBtn">
                        تأكيد والدفع <i class="fas fa-credit-card ms-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('orderForm');
        const steps = Array.from(document.querySelectorAll('.step-pane'));
        const stepItems = Array.from(document.querySelectorAll('.step-item'));
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');
        const packageCards = document.querySelectorAll('.package-card');
        const packageInput = document.getElementById('package_id_input');
        
        let currentStep = 0;

        // Package Selection
        packageCards.forEach(card => {
            card.addEventListener('click', () => {
                packageCards.forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                packageInput.value = card.dataset.id;
                
                // Update summary
                document.getElementById('summary-pkg-name').textContent = card.dataset.name;
                document.getElementById('summary-total').textContent = Number(card.dataset.price).toLocaleString('ar') + ' ' + card.dataset.currency;
                
                nextStep();
            });
        });

        function updateWizardUI() {
            steps.forEach((pane, i) => {
                pane.classList.toggle('active', i === currentStep);
            });

            stepItems.forEach((item, i) => {
                item.classList.toggle('active', i === currentStep);
                item.classList.toggle('completed', i < currentStep);
            });

            // Buttons
            prevBtn.classList.toggle('d-none', currentStep === 0);
            
            if (currentStep === steps.length - 1) {
                nextBtn.classList.add('d-none');
                submitBtn.classList.remove('d-none');
            } else {
                nextBtn.classList.remove('d-none');
                submitBtn.classList.add('d-none');
            }

            // scroll to top of wizard
            document.getElementById('wizard').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function validateStep() {
            const currentPane = steps[currentStep];
            const inputs = currentPane.querySelectorAll('[required]');
            let valid = true;

            inputs.forEach(input => {
                if (!input.value || (input.type === 'checkbox' && !input.checked)) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (currentStep === 0 && !packageInput.value) {
                alert('الرجاء اختيار حزمة أولاً');
                valid = false;
            }

            return valid;
        }

        function nextStep() {
            if (validateStep() && currentStep < steps.length - 1) {
                // Update summary names on beneficiary step
                if (currentStep === 2 || ({{ auth()->check() ? 'true' : 'false' }} && currentStep === 1)) {
                    document.getElementById('summary-ben-name').textContent = form.querySelector('[name="beneficiary_name"]').value;
                }
                
                currentStep++;
                updateWizardUI();
            }
        }

        nextBtn.addEventListener('click', nextStep);

        prevBtn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                updateWizardUI();
            }
        });

        form.addEventListener('submit', function(e) {
            if (!validateStep()) {
                e.preventDefault();
                return;
            }
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جاري التحويل للدفع...';
        });
    });
</script>
@endsection
