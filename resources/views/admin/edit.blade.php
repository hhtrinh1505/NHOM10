@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">✏️ Sửa thông tin bài viết</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.recipe.update', $recipe->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Tên món ăn:</label>
                    <input type="text" class="form-control" value="{{ $recipe->title }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Chọn người sở hữu bài viết:</label>
                    <select name="user_id" class="form-select">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" 
                                {{ $recipe->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }}) 
                                {{ $user->isAdmin() ? '- [ADMIN]' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Chọn "Admin" nếu bạn muốn bài này thành của mình.</small>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection