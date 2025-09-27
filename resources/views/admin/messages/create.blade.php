@extends('layouts.admin')

@section('title', 'إرسال رسالة جديدة - هدية')

@section('page-title', 'إرسال رسالة جديدة')
@section('page-description', 'إرسال رسالة إلى المستخدمين')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-envelope me-2"></i>نموذج الرسالة
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.messages.store') }}" id="messageForm" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Recipient Selection -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="receiver_id" class="form-label fw-bold">
                                    <i class="fas fa-user me-2 text-primary"></i>المستقبل
                                </label>
                                <select class="form-select @error('receiver_id') is-invalid @enderror" id="receiver_id" name="receiver_id" required>
                                    <option value="">اختر المستقبل</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('receiver_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} - {{ $user->role === 'admin' ? 'إدارة' : 'مستخدم' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('receiver_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="order_id" class="form-label fw-bold">
                                    <i class="fas fa-shopping-cart me-2 text-primary"></i>الطلب (اختياري)
                                </label>
                                <select class="form-select @error('order_id') is-invalid @enderror" id="order_id" name="order_id">
                                    <option value="">رسالة عامة</option>
                                    @foreach($orders as $order)
                                        <option value="{{ $order->id }}" 
                                                {{ (old('order_id') == $order->id || ($selectedOrder && $selectedOrder->id == $order->id)) ? 'selected' : '' }}>
                                            {{ $order->order_number }} - {{ $order->beneficiary_name }} ({{ $order->user->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('order_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="mb-4">
                            <label for="subject" class="form-label fw-bold">
                                <i class="fas fa-tag me-2 text-primary"></i>موضوع الرسالة
                            </label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" name="subject" value="{{ old('subject') }}" 
                                   placeholder="أدخل موضوع الرسالة (اختياري)">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Message Type -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-file-alt me-2 text-primary"></i>نوع الرسالة
                            </label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="type_text" 
                                               value="text" {{ old('type', 'text') == 'text' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_text">
                                            <i class="fas fa-font me-1"></i>نص
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="type_image" 
                                               value="image" {{ old('type') == 'image' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_image">
                                            <i class="fas fa-image me-1"></i>صورة
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="type_video" 
                                               value="video" {{ old('type') == 'video' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_video">
                                            <i class="fas fa-video me-1"></i>فيديو
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="type_file" 
                                               value="file" {{ old('type') == 'file' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_file">
                                            <i class="fas fa-file me-1"></i>ملف
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Message Content -->
                        <div class="mb-4" id="messageContentSection">
                            <label for="message" class="form-label fw-bold">
                                <i class="fas fa-comment me-2 text-primary"></i>محتوى الرسالة
                            </label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="6" 
                                      placeholder="اكتب رسالتك هنا..." required>{{ old('message') }}</textarea>
                            <div class="form-text">
                                <span id="charCount">0</span> / 1000 حرف
                            </div>
                            @error('message')
                                <div class="invalid-feedback">{{ $errors->first('message') }}</div>
                            @enderror
                        </div>

                        <!-- File Upload Section -->
                        <div class="mb-4" id="fileUploadSection" style="display: none;">
                            <label for="attachment" class="form-label fw-bold">
                                <i class="fas fa-upload me-2 text-primary"></i>رفع الملف
                            </label>
                            <input type="file" 
                                   class="form-control @error('attachment') is-invalid @enderror" 
                                   id="attachment" 
                                   name="attachment"
                                   accept="">
                            <div class="form-text" id="fileHelpText">
                                اختر الملف المناسب لنوع الرسالة
                            </div>
                            @error('attachment')
                                <div class="invalid-feedback">{{ $errors->first('attachment') }}</div>
                            @enderror
                        </div>

                        <!-- File Preview Section -->
                        <div class="mb-4" id="filePreviewSection" style="display: none;">
                            <label class="form-label fw-bold">
                                <i class="fas fa-eye me-2 text-primary"></i>معاينة الملف
                            </label>
                            <div id="filePreview" class="border rounded p-3 bg-light">
                                <!-- File preview will be shown here -->
                            </div>
                        </div>

                        <!-- Email Notification Info -->
                        <div class="alert alert-info d-flex align-items-center mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>
                                <strong>تنبيه:</strong> سيتم إرسال نسخة من هذه الرسالة إلى بريدك الإلكتروني وإلى بريد المستقبل.
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>إلغاء
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i>إرسال الرسالة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-label {
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.btn {
    border-radius: 10px;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
}

.btn:hover {
    transform: translateY(-1px);
}

.card {
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.alert {
    border-radius: 10px;
    border: none;
}

#charCount {
    color: #007bff;
    font-weight: 600;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageTextarea = document.getElementById('message');
    const charCount = document.getElementById('charCount');
    const submitBtn = document.getElementById('submitBtn');
    const fileUploadSection = document.getElementById('fileUploadSection');
    const filePreviewSection = document.getElementById('filePreviewSection');
    const fileInput = document.getElementById('attachment');
    const fileHelpText = document.getElementById('fileHelpText');
    const filePreview = document.getElementById('filePreview');
    const messageContentSection = document.getElementById('messageContentSection');
    
    // Message type radio buttons
    const typeRadios = document.querySelectorAll('input[name="type"]');
    
    // Character counter
    messageTextarea.addEventListener('input', function() {
        const count = this.value.length;
        charCount.textContent = count;
        
        if (count > 1000) {
            charCount.style.color = '#dc3545';
            this.classList.add('is-invalid');
        } else {
            charCount.style.color = '#007bff';
            this.classList.remove('is-invalid');
        }
    });
    
    // Handle message type changes
    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const selectedType = this.value;
            handleMessageTypeChange(selectedType);
        });
    });
    
    // File input change handler
    fileInput.addEventListener('change', function() {
        handleFileSelection(this.files[0]);
    });
    
    function handleMessageTypeChange(type) {
        // Reset file input
        fileInput.value = '';
        filePreviewSection.style.display = 'none';
        filePreview.innerHTML = '';
        
        switch(type) {
            case 'text':
                fileUploadSection.style.display = 'none';
                messageContentSection.style.display = 'block';
                messageTextarea.required = true;
                messageTextarea.placeholder = 'اكتب رسالتك هنا...';
                break;
                
            case 'image':
                fileUploadSection.style.display = 'block';
                messageContentSection.style.display = 'block';
                fileInput.accept = 'image/*';
                fileHelpText.textContent = 'اختر صورة (JPG, PNG, GIF, WebP)';
                messageTextarea.placeholder = 'اكتب وصف للصورة (اختياري)...';
                messageTextarea.required = false;
                break;
                
            case 'video':
                fileUploadSection.style.display = 'block';
                messageContentSection.style.display = 'block';
                fileInput.accept = 'video/*';
                fileHelpText.textContent = 'اختر فيديو (MP4, AVI, MOV, WebM)';
                messageTextarea.placeholder = 'اكتب وصف للفيديو (اختياري)...';
                messageTextarea.required = false;
                break;
                
            case 'file':
                fileUploadSection.style.display = 'block';
                messageContentSection.style.display = 'block';
                fileInput.accept = '.pdf,.doc,.docx,.txt,.xls,.xlsx,.ppt,.pptx,.zip,.rar';
                fileHelpText.textContent = 'اختر ملف (PDF, Word, Excel, PowerPoint, ZIP, RAR)';
                messageTextarea.placeholder = 'اكتب وصف للملف (اختياري)...';
                messageTextarea.required = false;
                break;
        }
    }
    
    function handleFileSelection(file) {
        if (!file) {
            filePreviewSection.style.display = 'none';
            return;
        }
        
        filePreviewSection.style.display = 'block';
        const selectedType = document.querySelector('input[name="type"]:checked').value;
        
        // Show file info
        const fileInfo = `
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-${getFileIcon(selectedType)} fa-2x text-primary"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-1">${file.name}</h6>
                    <small class="text-muted">الحجم: ${formatFileSize(file.size)}</small>
                </div>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearFile()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        filePreview.innerHTML = fileInfo;
        
        // Show preview for images
        if (selectedType === 'image' && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = `
                    <div class="mt-3">
                        <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;" alt="معاينة الصورة">
                    </div>
                `;
                filePreview.innerHTML = fileInfo + imagePreview;
            };
            reader.readAsDataURL(file);
        }
    }
    
    function getFileIcon(type) {
        switch(type) {
            case 'image': return 'image';
            case 'video': return 'video';
            case 'file': return 'file';
            default: return 'file';
        }
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Global function to clear file
    window.clearFile = function() {
        fileInput.value = '';
        filePreviewSection.style.display = 'none';
        filePreview.innerHTML = '';
    };
    
    // Initialize with default type
    const defaultType = document.querySelector('input[name="type"]:checked');
    if (defaultType) {
        handleMessageTypeChange(defaultType.value);
    }
    
    // Form submission
    document.getElementById('messageForm').addEventListener('submit', function(e) {
        const message = messageTextarea.value.trim();
        const receiver = document.getElementById('receiver_id').value;
        const selectedType = document.querySelector('input[name="type"]:checked').value;
        const hasFile = fileInput.files.length > 0;
        
        // Validation based on message type
        if (!receiver) {
            e.preventDefault();
            alert('يرجى اختيار المستقبل');
            return;
        }
        
        if (selectedType === 'text') {
            if (!message) {
                e.preventDefault();
                alert('يرجى كتابة محتوى الرسالة');
                return;
            }
        } else {
            if (!message && !hasFile) {
                e.preventDefault();
                alert('يرجى كتابة وصف أو رفع ملف');
                return;
            }
        }
        
        if (message && message.length > 1000) {
            e.preventDefault();
            alert('الرسالة طويلة جداً. الحد الأقصى 1000 حرف');
            return;
        }
        
        // File size validation (10MB limit)
        if (hasFile && fileInput.files[0].size > 10 * 1024 * 1024) {
            e.preventDefault();
            alert('حجم الملف كبير جداً. الحد الأقصى 10 ميجابايت');
            return;
        }
        
        
        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الإرسال...';
    });
});
</script>
@endsection
