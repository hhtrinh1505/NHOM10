@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header bg-warning text-dark fw-bold">
            ✏️ CHỈNH SỬA MÓN ĂN
        </div>
        <div class="card-body">
            <form action="{{ route('recipe.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Bắt buộc phải có dòng này để báo hiệu là lệnh Cập nhật --}}

                {{-- Tên món --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên món ăn</label>
                    <input type="text" name="title" class="form-control" value="{{ $recipe->title }}" required>
                </div>

                {{-- Ảnh hiện tại & Upload ảnh mới --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Hình ảnh</label>
                    <div class="mb-2">
                        <small class="text-muted">Ảnh hiện tại:</small><br>
                        @if(Str::startsWith($recipe->image, 'http'))
                            <img src="{{ $recipe->image }}" width="100" class="rounded border">
                        @else
                            <img src="{{ asset('storage/' . $recipe->image) }}" width="100" class="rounded border">
                        @endif
                    </div>
                    <input type="file" name="image" class="form-control">
                    <small class="text-danger">* Chỉ chọn nếu muốn thay ảnh mới</small>
                </div>

                {{-- Mô tả --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả ngắn</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ $recipe->description }}</textarea>
                </div>

                {{-- Nguyên liệu (Ẩn nếu không cần thiết sửa lúc này) --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Nguyên liệu</label>
                    <textarea name="ingredients" class="form-control" rows="3">{{ $recipe->ingredients }}</textarea>
                </div>

                 {{-- Cách làm --}}
                 <div class="mb-3">
                    <label class="form-label fw-bold">Cách làm</label>
                    <textarea name="steps" class="form-control" rows="3">{{ $recipe->steps }}</textarea>
                </div>

                <div class="text-end">
                    <a href="{{ route('home') }}" class="btn btn-secondary me-2">Hủy</a>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection