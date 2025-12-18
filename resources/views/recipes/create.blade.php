@extends('layouts.app')
@section('content')
<div class="card p-4">
    <h3>Chia sẻ công thức mới</h3>
    <form action="{{ route('recipe.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Tên món ăn</label>
                <input type="text" name="title" class="form-control" placeholder="Ví dụ: Phở Bò" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Hình ảnh đại diện</label>
                <input type="file" name="image" class="form-control" required>
            </div>
        </div>
        <div class="mb-3">
            <label>Mô tả ngắn</label>
            <textarea name="description" class="form-control" rows="2" required></textarea>
        </div>
        <div class="mb-3">
            <label>Nguyên liệu</label>
            <textarea name="ingredients" class="form-control" rows="3" placeholder="Mỗi dòng 1 nguyên liệu..." required></textarea>
        </div>
        <div class="mb-3">
            <label>Cách chế biến</label>
            <textarea name="steps" class="form-control" rows="5" placeholder="Bước 1..." required></textarea>
        </div>
        <button class="btn btn-custom w-100">Đăng Công Thức</button>
    </form>
</div>
@endsection