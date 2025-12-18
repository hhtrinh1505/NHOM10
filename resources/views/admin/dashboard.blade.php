@extends('layouts.app') 

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🛠 Bảng Điều Khiển Admin</h2>
        <span class="badge bg-danger">Admin Mode</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Danh sách món ăn đang chờ duyệt</h5>
        </div>
        <div class="card-body">
            @if($pendingRecipes->isEmpty())
                <div class="text-center py-5">
                    <p class="text-muted fs-5">Tuyệt vời! Không có bài nào cần duyệt lúc này.</p>
                </div>
            @else
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 100px;">Hình ảnh</th>
                            <th style="width: 25%;">Tên món</th>
                            <th>Mô tả ngắn</th>
                            <th>Người đăng</th>
                            <th style="width: 200px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingRecipes as $recipe)
                        <tr>
                            <td>
                                @if($recipe->image)
                                    <img src="{{ asset('storage/' . $recipe->image) }}" 
                                         alt="Ảnh món" 
                                         class="rounded" 
                                         style="width: 80px; height: 60px; object-fit: cover;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>

                            <td>
                                <strong>{{ $recipe->title }}</strong>
                                <br>
                                <small class="text-muted">Ngày đăng: {{ $recipe->created_at->format('d/m/Y') }}</small>
                            </td>

                            <td>
                                {{ Str::limit($recipe->description, 50) }}
                                <br>
                                <a href="{{ route('recipe.show', $recipe->id) }}" target="_blank" style="font-size: 0.9rem;">
                                    Xem chi tiết nội dung 🔗
                                </a>
                            </td>

                            <td>
                                <span class="badge bg-info text-dark">{{ $recipe->user->name }}</span>
                            </td>

                           <td>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.recipe.approve', $recipe->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            ✅ Duyệt
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.recipe.edit', $recipe->id) }}" class="btn btn-warning btn-sm">
                                        ✏️ Sửa Tác Giả
                                    </a>
                                    <form action="{{ route('admin.recipe.delete', $recipe->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa bài này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            🗑 Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection