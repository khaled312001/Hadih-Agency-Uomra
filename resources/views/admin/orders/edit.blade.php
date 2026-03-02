@extends('layouts.admin')

@section('title', 'تعديل الطلب')
@section('page-title', 'تعديل الطلب')
@section('page-description', 'تعديل معلومات الطلب رقم: {{ $order->order_number }}')

@section('page-actions')
    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-info hover-lift">
        <i class="fas fa-eye me-2"></i>عرض الطلب
    </a>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary hover-lift">
        <i class="fas fa-arrow-right me-2"></i>العودة للطلبات
    </a>
@endsection

@section('content')
    <div class="content-card">
        <div class="p-4">
            <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">حالة الطلب <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                <option value="assigned" {{ old('status', $order->status) == 'assigned' ? 'selected' : '' }}>تم التخصيص</option>
                                <option value="in_progress" {{ old('status', $order->status) == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">معلومات الطلب</label>
                            <div class="bg-light p-3 rounded">
                                <small class="text-muted d-block">رقم الطلب: <strong>{{ $order->order_number }}</strong></small>
                                <small class="text-muted d-block">الحزمة: <strong>{{ $order->umrahPackage->name_ar }}</strong></small>
                                <small class="text-muted d-block">المستخدم: <strong>{{ $order->user->name }}</strong></small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">ملاحظات</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4" placeholder="أضف ملاحظات حول الطلب">{{ old('notes', $order->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
