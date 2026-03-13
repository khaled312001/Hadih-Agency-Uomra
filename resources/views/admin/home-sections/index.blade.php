@extends('layouts.admin')

@section('title', 'إدارة الصفحة الرئيسية')

@section('content')
<div class="page-gradient-bar"></div>

<div class="content-card">
    <div class="content-card-header">
        <h5 class="mb-0">أقسام الصفحة الرئيسية</h5>
        <a href="{{ route('admin.home-sections.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>إضافة قسم جديد
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" id="sectionsTable">
            <thead>
                <tr>
                    <th style="width: 50px;"></th>
                    <th>الترتيب</th>
                    <th>النوع</th>
                    <th>العنوان (عربي)</th>
                    <th>الحالة</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody id="sortable-sections">
                @foreach($sections as $section)
                <tr data-id="{{ $section->id }}">
                    <td class="handle cursor-move">
                        <i class="fas fa-grip-vertical text-muted"></i>
                    </td>
                    <td><span class="badge bg-light text-dark border">{{ $section->order }}</span></td>
                    <td><span class="badge bg-info">{{ ucfirst($section->type) }}</span></td>
                    <td>{{ $section->title_ar ?? 'بدون عنوان' }}</td>
                    <td>
                        @if($section->is_active)
                            <span class="badge bg-success">نشط</span>
                        @else
                            <span class="badge bg-secondary">معطل</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.home-sections.edit', $section->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.home-sections.destroy', $section->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if($sections->isEmpty())
<div class="text-center py-5">
    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
    <p class="text-muted">لا توجد أقسام مضافة حالياً.</p>
</div>
@endif

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('sortable-sections');
        if (el) {
            new Sortable(el, {
                handle: '.handle',
                animation: 150,
                onEnd: function() {
                    const orders = [];
                    el.querySelectorAll('tr').forEach((tr, index) => {
                        orders.push({
                            id: tr.dataset.id,
                            order: index + 1
                        });
                        tr.querySelector('.badge.bg-light').textContent = index + 1;
                    });

                    fetch('{{ route("admin.home-sections.update-order") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ orders: orders })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Order updated');
                        }
                    });
                }
            });
        }
    });
</script>
<style>
    .cursor-move { cursor: move; }
    .btn-group form { display: inline; }
</style>
@endsection
