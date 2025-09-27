@extends('layouts.admin')

@section('title', 'تحديث حزمة العمرة')
@section('page-title', 'تحديث حزمة العمرة')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">تم تحديث حزمة العمرة بنجاح</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    تم تحديث حزمة العمرة بنجاح
                </div>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-right me-2"></i>العودة للقائمة
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
