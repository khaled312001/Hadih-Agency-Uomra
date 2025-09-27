@extends('layouts.admin')

@section('title', 'تعديل الرسالة - هدية')

@section('page-title', 'تعديل الرسالة')
@section('page-description', 'تعديل محتوى الرسالة')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 mb-1 text-primary">
                        <i class="fas fa-edit me-2"></i>تعديل الرسالة
                    </h2>
                    <p class="text-muted mb-0">تعديل محتوى الرسالة</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-outline-info btn-lg">
                        <i class="fas fa-eye me-2"></i>عرض الرسالة
                    </a>
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-arrow-right me-2"></i>العودة للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>نموذج تعديل الرسالة
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.messages.update', $message) }}" id="messageForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Message Info Display -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="info-card p-3 bg-light rounded">
                                    <h6 class="text-muted mb-2">
                                        <i class="fas fa-user me-2"></i>المرسل
                                    </h6>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3">
                                            @if($message->sender->role === 'admin')
                                                <div class="avatar-title bg-warning text-white rounded-circle">
                                                    <i class="fas fa-crown"></i>
                                                </div>
                                            @else
                                                <div class="avatar-title bg-primary text-white rounded-circle">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 {{ $message->sender->role === 'admin' ? 'text-warning' : 'text-primary' }}">
                                                {{ $message->sender->name }}
                                                @if($message->sender->role === 'admin')
                                                    <i class="fas fa-crown ms-1" title="إدارة"></i>
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-card p-3 bg-light rounded">
                                    <h6 class="text-muted mb-2">
                                        <i class="fas fa-user me-2"></i>المستقبل
                                    </h6>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3">
                                            @if($message->receiver->role === 'admin')
                                                <div class="avatar-title bg-warning text-white rounded-circle">
                                                    <i class="fas fa-crown"></i>
                                                </div>
                                            @else
                                                <div class="avatar-title bg-primary text-white rounded-circle">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 {{ $message->receiver->role === 'admin' ? 'text-warning' : 'text-primary' }}">
                                                {{ $message->receiver->name }}
                                                @if($message->receiver->role === 'admin')
                                                    <i class="fas fa-crown ms-1" title="إدارة"></i>
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Subject Field -->
                        <div class="mb-4">
                            <label for="subject" class="form-label fw-bold">
                                <i class="fas fa-tag me-2 text-primary"></i>موضوع الرسالة (اختياري)
                            </label>
                            <input type="text" 
                                   class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" 
                                   name="subject" 
                                   value="{{ old('subject', $message->subject) }}"
                                   placeholder="أدخل موضوع الرسالة">
                            @error('subject')
                                <div class="invalid-feedback">{{ $errors->first('subject') }}</div>
                            @enderror
                        </div>
                        
                        <!-- Message Content -->
                        <div class="mb-4">
                            <label for="message" class="form-label fw-bold">
                                <i class="fas fa-comment me-2 text-primary"></i>محتوى الرسالة
                            </label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" 
                                      name="message" 
                                      rows="8" 
                                      required
                                      placeholder="أدخل محتوى الرسالة">{{ old('message', $message->message) }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $errors->first('message') }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                يمكنك استخدام النص العادي أو HTML البسيط لتنسيق الرسالة
                            </div>
                        </div>

                        <!-- Message Type -->
                        <div class="mb-4">
                            <label for="type" class="form-label fw-bold">
                                <i class="fas fa-cog me-2 text-primary"></i>نوع الرسالة
                            </label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="text" {{ old('type', $message->type) == 'text' ? 'selected' : '' }}>
                                    <i class="fas fa-font"></i> نص
                                </option>
                                <option value="image" {{ old('type', $message->type) == 'image' ? 'selected' : '' }}>
                                    <i class="fas fa-image"></i> صورة
                                </option>
                                <option value="video" {{ old('type', $message->type) == 'video' ? 'selected' : '' }}>
                                    <i class="fas fa-video"></i> فيديو
                                </option>
                                <option value="file" {{ old('type', $message->type) == 'file' ? 'selected' : '' }}>
                                    <i class="fas fa-file"></i> ملف
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $errors->first('type') }}</div>
                            @enderror
                        </div>

                        <!-- Current Attachment Display -->
                        @if($message->attachment)
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-paperclip me-2 text-primary"></i>المرفق الحالي
                                </label>
                                <div class="attachment-display p-3 bg-light rounded">
                                    @if($message->type === 'image')
                                        <img src="{{ asset('storage/' . $message->attachment) }}" alt="مرفق" class="img-fluid rounded mb-2" style="max-height: 200px;">
                                    @elseif($message->type === 'video')
                                        <video controls class="img-fluid rounded mb-2" style="max-height: 200px;">
                                            <source src="{{ asset('storage/' . $message->attachment) }}" type="video/mp4">
                                            متصفحك لا يدعم تشغيل الفيديو.
                                        </video>
                                    @else
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file fa-2x text-muted me-3"></i>
                                            <div>
                                                <h6 class="mb-1">{{ basename($message->attachment) }}</h6>
                                                <small class="text-muted">ملف مرفق</small>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $message->attachment) }}" class="btn btn-outline-primary btn-sm" download>
                                            <i class="fas fa-download me-1"></i>تحميل المرفق
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- New Attachment Upload -->
                        <div class="mb-4">
                            <label for="attachment" class="form-label fw-bold">
                                <i class="fas fa-upload me-2 text-primary"></i>مرفق جديد (اختياري)
                            </label>
                            <input type="file" 
                                   class="form-control @error('attachment') is-invalid @enderror" 
                                   id="attachment" 
                                   name="attachment"
                                   accept="">
                            @error('attachment')
                                <div class="invalid-feedback">{{ $errors->first('attachment') }}</div>
                            @enderror
                            <div class="form-text" id="fileHelpText">
                                <i class="fas fa-info-circle me-1"></i>
                                يمكنك رفع صورة، فيديو، أو ملف. إذا لم تختار مرفق جديد، سيتم الاحتفاظ بالمرفق الحالي.
                            </div>
                        </div>

                        <!-- New File Preview Section -->
                        <div class="mb-4" id="newFilePreviewSection" style="display: none;">
                            <label class="form-label fw-bold">
                                <i class="fas fa-eye me-2 text-primary"></i>معاينة الملف الجديد
                            </label>
                            <div id="newFilePreview" class="border rounded p-3 bg-light">
                                <!-- New file preview will be shown here -->
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>إلغاء
                            </a>
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-save me-2"></i>حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

.info-card {
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.info-card:hover {
    background-color: #f8f9fa !important;
    border-color: #007bff;
}

.attachment-display {
    border: 2px dashed #dee2e6;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.card {
    border-radius: 15px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.form-control, .form-select {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-label {
    color: #495057;
    margin-bottom: 0.75rem;
}

.form-text {
    color: #6c757d;
    font-size: 0.875rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('message');
    const fileInput = document.getElementById('attachment');
    const newFilePreviewSection = document.getElementById('newFilePreviewSection');
    const newFilePreview = document.getElementById('newFilePreview');
    const fileHelpText = document.getElementById('fileHelpText');
    const messageType = '{{ $message->type }}';
    
    // Auto-resize textarea
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
    
    // File input change handler
    fileInput.addEventListener('change', function() {
        handleFileSelection(this.files[0]);
    });
    
    function handleFileSelection(file) {
        if (!file) {
            newFilePreviewSection.style.display = 'none';
            return;
        }
        
        newFilePreviewSection.style.display = 'block';
        
        // Show file info
        const fileInfo = `
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-${getFileIcon(file.type)} fa-2x text-primary"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-1">${file.name}</h6>
                    <small class="text-muted">الحجم: ${formatFileSize(file.size)}</small>
                </div>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearNewFile()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        newFilePreview.innerHTML = fileInfo;
        
        // Show preview for images
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = `
                    <div class="mt-3">
                        <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;" alt="معاينة الصورة">
                    </div>
                `;
                newFilePreview.innerHTML = fileInfo + imagePreview;
            };
            reader.readAsDataURL(file);
        }
    }
    
    function getFileIcon(fileType) {
        if (fileType.startsWith('image/')) return 'image';
        if (fileType.startsWith('video/')) return 'video';
        return 'file';
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Global function to clear new file
    window.clearNewFile = function() {
        fileInput.value = '';
        newFilePreviewSection.style.display = 'none';
        newFilePreview.innerHTML = '';
    };
    
    // Set appropriate accept attribute based on message type
    switch(messageType) {
        case 'image':
            fileInput.accept = 'image/*';
            fileHelpText.innerHTML = '<i class="fas fa-info-circle me-1"></i>اختر صورة جديدة (JPG, PNG, GIF, WebP)';
            break;
        case 'video':
            fileInput.accept = 'video/*';
            fileHelpText.innerHTML = '<i class="fas fa-info-circle me-1"></i>اختر فيديو جديد (MP4, AVI, MOV, WebM)';
            break;
        case 'file':
            fileInput.accept = '.pdf,.doc,.docx,.txt,.xls,.xlsx,.ppt,.pptx,.zip,.rar';
            fileHelpText.innerHTML = '<i class="fas fa-info-circle me-1"></i>اختر ملف جديد (PDF, Word, Excel, PowerPoint, ZIP, RAR)';
            break;
        default:
            fileInput.accept = 'image/*,video/*,.pdf,.doc,.docx,.txt,.xls,.xlsx,.ppt,.pptx,.zip,.rar';
            break;
    }
    
    // Form validation
    const form = document.getElementById('messageForm');
    form.addEventListener('submit', function(e) {
        const message = document.getElementById('message').value.trim();
        const hasFile = fileInput.files.length > 0;
        const hasExistingAttachment = '{{ $message->attachment }}' !== '';
        
        if (!message && !hasFile && !hasExistingAttachment) {
            e.preventDefault();
            alert('يرجى إدخال محتوى الرسالة أو رفع ملف');
            return false;
        }
        
        // File size validation (10MB limit)
        if (hasFile && fileInput.files[0].size > 10 * 1024 * 1024) {
            e.preventDefault();
            alert('حجم الملف كبير جداً. الحد الأقصى 10 ميجابايت');
            return false;
        }
    });
});
</script>
@endsection
