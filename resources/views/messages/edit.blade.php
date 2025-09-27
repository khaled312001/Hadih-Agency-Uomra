@extends('layouts.user')

@section('title', 'تعديل الرسالة - هدية')
@section('page-title', 'تعديل الرسالة')
@section('page-description', 'تعديل محتوى الرسالة')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center">
                <img src="{{ asset('images/logo.jpg') }}" alt="هدية" style="height: 60px; width: auto;" class="mb-3">
                <h5 class="card-title mb-0">تعديل الرسالة</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('messages.update', $message) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="subject" class="form-label">موضوع الرسالة</label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                               id="subject" name="subject" value="{{ old('subject', $message->subject) }}" 
                               placeholder="أدخل موضوع الرسالة (اختياري)">
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="message" class="form-label">محتوى الرسالة</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                  id="message" name="message" rows="5">{{ old('message', $message->message) }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $errors->first('message') }}</div>
                        @enderror
                    </div>

                    <!-- Current Attachment Display -->
                    @if($message->attachment)
                        <div class="mb-3">
                            <label class="form-label">المرفق الحالي</label>
                            <div class="p-3 bg-light rounded">
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
                    <div class="mb-3">
                        <label for="attachment" class="form-label">مرفق جديد (اختياري)</label>
                        <input type="file" 
                               class="form-control @error('attachment') is-invalid @enderror" 
                               id="attachment" 
                               name="attachment"
                               accept="">
                        @error('attachment')
                            <div class="invalid-feedback">{{ $errors->first('attachment') }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            يمكنك رفع صورة، فيديو، أو ملف. إذا لم تختار مرفق جديد، سيتم الاحتفاظ بالمرفق الحالي.
                        </div>
                    </div>

                    <!-- New File Preview Section -->
                    <div class="mb-3" id="newFilePreviewSection" style="display: none;">
                        <label class="form-label">معاينة الملف الجديد</label>
                        <div id="newFilePreview" class="border rounded p-3 bg-light">
                            <!-- New file preview will be shown here -->
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>حفظ التغييرات
                        </button>
                        <a href="{{ route('messages.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('attachment');
    const newFilePreviewSection = document.getElementById('newFilePreviewSection');
    const newFilePreview = document.getElementById('newFilePreview');
    const messageType = '{{ $message->type }}';
    
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
            break;
        case 'video':
            fileInput.accept = 'video/*';
            break;
        case 'file':
            fileInput.accept = '.pdf,.doc,.docx,.txt,.xls,.xlsx,.ppt,.pptx,.zip,.rar';
            break;
        default:
            fileInput.accept = 'image/*,video/*,.pdf,.doc,.docx,.txt,.xls,.xlsx,.ppt,.pptx,.zip,.rar';
            break;
    }
    
    // Form validation
    const form = document.querySelector('form');
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
