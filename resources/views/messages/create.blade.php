@extends('layouts.user')

@section('title', 'إرسال رسالة جديدة - هدية')
@section('page-title', 'إرسال رسالة جديدة')
@section('page-description', 'تواصل مع فريق العمل أو الإدارة')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="hd-form-section">
            <div class="hd-form-section__header">
                <div class="hd-form-section__header-icon"><i class="fas fa-paper-plane"></i></div>
                <div>
                    <div class="hd-form-section__header-title">نموذج الرسالة</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.75);">أرسل رسالتك إلى فريق الدعم</div>
                </div>
            </div>
            <div class="hd-form-section__body">

                <form method="POST" action="{{ route('messages.store') }}" id="messageForm" enctype="multipart/form-data">
                    @csrf

                    {{-- Recipient & Order --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="hd-form-group">
                                <label class="hd-label hd-label--required"><i class="fas fa-user"></i> المستقبل</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-user"></i>
                                    <select name="receiver_id" id="receiver_id"
                                            class="hd-input hd-select @error('receiver_id') hd-input--error @enderror" required>
                                        <option value="">اختر المستقبل</option>
                                        @foreach($companyUsers as $user)
                                            <option value="{{ $user->id }}" {{ old('receiver_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} — {{ $user->role === 'admin' ? 'إدارة' : 'موظف' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('receiver_id')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="hd-form-group">
                                <label class="hd-label"><i class="fas fa-shopping-cart"></i> الطلب (اختياري)</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-shopping-cart"></i>
                                    <select name="order_id" id="order_id"
                                            class="hd-input hd-select @error('order_id') hd-input--error @enderror">
                                        <option value="">رسالة عامة</option>
                                        @foreach($orders as $order)
                                            <option value="{{ $order->id }}"
                                                    {{ (old('order_id') == $order->id || ($selectedOrder && $selectedOrder->id == $order->id)) ? 'selected' : '' }}>
                                                {{ $order->order_number }} — {{ $order->beneficiary_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('order_id')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Subject --}}
                    <div class="hd-form-group">
                        <label class="hd-label"><i class="fas fa-tag"></i> موضوع الرسالة (اختياري)</label>
                        <div class="hd-input-wrap">
                            <i class="hd-input-icon fas fa-tag"></i>
                            <input type="text" name="subject"
                                   class="hd-input @error('subject') hd-input--error @enderror"
                                   value="{{ old('subject') }}" placeholder="أدخل موضوع الرسالة">
                        </div>
                        @error('subject')<div class="hd-error-msg">{{ $message }}</div>@enderror
                    </div>

                    {{-- Message Type --}}
                    <div class="hd-form-group">
                        <label class="hd-label"><i class="fas fa-file-alt"></i> نوع الرسالة</label>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach(['text'=>['icon'=>'font','label'=>'نص'],'image'=>['icon'=>'image','label'=>'صورة'],'video'=>['icon'=>'video','label'=>'فيديو'],'file'=>['icon'=>'file','label'=>'ملف']] as $val=>$info)
                            <label style="cursor:pointer;display:flex;align-items:center;gap:.4rem;padding:.5rem 1rem;border-radius:10px;border:2px solid #e2e8f0;font-size:.875rem;font-weight:600;color:#64748b;transition:.2s;"
                                   class="msg-type-label">
                                <input type="radio" name="type" value="{{ $val }}"
                                       {{ old('type','text')===$val?'checked':'' }}
                                       style="display:none;" onchange="handleTypeChange('{{ $val }}')">
                                <i class="fas fa-{{ $info['icon'] }}"></i> {{ $info['label'] }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Message Content --}}
                    <div class="hd-form-group" id="messageContentSection">
                        <label class="hd-label hd-label--required"><i class="fas fa-comment"></i> محتوى الرسالة</label>
                        <div class="hd-input-wrap">
                            <i class="hd-input-icon fas fa-comment"></i>
                            <textarea name="message" id="message" rows="5"
                                      class="hd-input @error('message') hd-input--error @enderror"
                                      placeholder="اكتب رسالتك هنا...">{{ old('message') }}</textarea>
                        </div>
                        <div style="font-size:.75rem;color:#94a3b8;margin-top:.3rem;">
                            <span id="charCount" style="color:var(--hd-primary);font-weight:600;">0</span> / 1000 حرف
                        </div>
                        @error('message')<div class="hd-error-msg">{{ $errors->first('message') }}</div>@enderror
                    </div>

                    {{-- File Upload --}}
                    <div class="hd-form-group d-none" id="fileUploadSection">
                        <label class="hd-label"><i class="fas fa-upload"></i> رفع الملف</label>
                        <div class="hd-upload-zone" onclick="document.getElementById('attachment').click()">
                            <div class="hd-upload-zone__icon"><i class="fas fa-cloud-upload-alt"></i></div>
                            <div class="hd-upload-zone__title" id="uploadTitle">اضغط لرفع ملف</div>
                            <div class="hd-upload-zone__hint" id="uploadHint">اختر الملف المناسب</div>
                        </div>
                        <input type="file" id="attachment" name="attachment" class="d-none" onchange="handleFileSelection(this)">
                        <div id="filePreview" class="mt-2 d-none">
                            <div style="background:#f8fafc;border-radius:10px;padding:.75rem 1rem;border:1px solid #e2e8f0;" id="filePreviewContent"></div>
                        </div>
                        @error('attachment')<div class="hd-error-msg">{{ $errors->first('attachment') }}</div>@enderror
                    </div>

                    {{-- Info --}}
                    <div style="background:#eff6ff;border-radius:12px;padding:.875rem 1rem;margin-bottom:1.25rem;font-size:.82rem;color:#3b82f6;display:flex;align-items:center;gap:.5rem;">
                        <i class="fas fa-info-circle"></i>
                        <span>سيتم إرسال نسخة من هذه الرسالة إلى بريدك الإلكتروني وإلى بريد المستقبل.</span>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="hd-btn hd-btn--primary" id="submitBtn">
                            <i class="fas fa-paper-plane"></i> إرسال الرسالة
                        </button>
                        <a href="{{ route('messages.index') }}" class="hd-btn hd-btn--secondary">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
// Highlight active type label
function updateTypeLabels() {
    document.querySelectorAll('.msg-type-label').forEach(label => {
        const radio = label.querySelector('input[type=radio]');
        if (radio.checked) {
            label.style.borderColor = 'var(--hd-primary)';
            label.style.color = 'var(--hd-primary)';
            label.style.background = '#eff0fe';
        } else {
            label.style.borderColor = '#e2e8f0';
            label.style.color = '#64748b';
            label.style.background = '';
        }
    });
}

function handleTypeChange(type) {
    updateTypeLabels();
    const fileSection = document.getElementById('fileUploadSection');
    const msgSection  = document.getElementById('messageContentSection');
    const msgArea     = document.getElementById('message');
    const uploadHint  = document.getElementById('uploadHint');
    const attach      = document.getElementById('attachment');

    // reset file
    attach.value = '';
    document.getElementById('filePreview').classList.add('d-none');

    const hints = { image:'JPG, PNG, GIF, WebP', video:'MP4, AVI, MOV, WebM', file:'PDF, Word, Excel, ZIP, RAR' };
    const accepts = { image:'image/*', video:'video/*', file:'.pdf,.doc,.docx,.txt,.xls,.xlsx,.ppt,.pptx,.zip,.rar' };

    if (type === 'text') {
        fileSection.classList.add('d-none');
        msgArea.required = true;
    } else {
        fileSection.classList.remove('d-none');
        uploadHint.textContent = hints[type] || '';
        attach.accept = accepts[type] || '';
        msgArea.required = false;
    }
}

function handleFileSelection(input) {
    const file = input.files[0];
    const preview = document.getElementById('filePreview');
    const content = document.getElementById('filePreviewContent');
    if (!file) { preview.classList.add('d-none'); return; }
    preview.classList.remove('d-none');
    content.innerHTML = `<div class="d-flex align-items-center gap-2">
        <i class="fas fa-file-alt" style="font-size:1.4rem;color:var(--hd-primary);"></i>
        <div class="flex-grow-1">
            <div style="font-weight:700;font-size:.875rem;">${file.name}</div>
            <div style="font-size:.75rem;color:#94a3b8;">${(file.size/1024).toFixed(1)} KB</div>
        </div>
        <button type="button" onclick="clearFile()" style="background:none;border:none;color:#ef4444;font-size:1.1rem;">
            <i class="fas fa-times"></i>
        </button>
    </div>`;

    const type = document.querySelector('input[name="type"]:checked')?.value;
    if (type === 'image' && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
            content.innerHTML += `<div class="mt-2 text-center"><img src="${e.target.result}" style="max-height:150px;border-radius:8px;"></div>`;
        };
        reader.readAsDataURL(file);
    }
}

window.clearFile = function() {
    document.getElementById('attachment').value = '';
    document.getElementById('filePreview').classList.add('d-none');
};

document.addEventListener('DOMContentLoaded', function() {
    updateTypeLabels();

    // Character counter
    document.getElementById('message').addEventListener('input', function() {
        const count = this.value.length;
        const el = document.getElementById('charCount');
        el.textContent = count;
        el.style.color = count > 1000 ? '#ef4444' : 'var(--hd-primary)';
    });

    // Submit spinner
    document.getElementById('messageForm').addEventListener('submit', function(e) {
        const type = document.querySelector('input[name="type"]:checked')?.value;
        const msg = document.getElementById('message').value.trim();
        const receiver = document.getElementById('receiver_id').value;
        const hasFile = document.getElementById('attachment').files.length > 0;

        if (!receiver) { e.preventDefault(); alert('يرجى اختيار المستقبل'); return; }
        if (type === 'text' && !msg) { e.preventDefault(); alert('يرجى كتابة محتوى الرسالة'); return; }
        if (type !== 'text' && !msg && !hasFile) { e.preventDefault(); alert('يرجى كتابة وصف أو رفع ملف'); return; }
        if (msg.length > 1000) { e.preventDefault(); alert('الرسالة طويلة جداً'); return; }

        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...';
    });
});
</script>
@endsection
