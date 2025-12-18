@extends('layouts.app')

@section('content')
<div class="container">
    {{-- 1. Chỉ hiển thị dòng này nếu là Admin --}}
    @if(Auth::check() && Auth::user()->role === 'admin')
        <div class="alert alert-info text-center mb-4">
            <strong>Bạn là Admin!</strong> 
            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-sm ml-2">⚙️ Vào trang quản trị</a>
        </div>
    @endif
    
    {{-- 2. Hiển thị thông báo thành công nếu có (Ví dụ: Đã xóa bài) --}}
    @if(session('success'))
        <div class="alert alert-success text-center mb-4">{{ session('success') }}</div>
    @endif

    {{-- [MỚI] 3. Hiển thị thông báo đang tìm kiếm từ khóa nào --}}
    @if(request('keyword'))
        <div class="alert alert-warning mb-4 d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-search"></i> Kết quả tìm kiếm cho: <strong>"{{ request('keyword') }}"</strong>
            </span>
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-dark">✕ Xóa tìm kiếm</a>
        </div>
    @endif

    <div class="row">
        {{-- 4. Kiểm tra nếu không có công thức nào --}}
        @if($recipes->isEmpty())
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-4">Không tìm thấy công thức nào phù hợp.</p>
                <a href="{{ route('home') }}" class="btn btn-secondary">Quay lại trang chủ</a>
            </div>
            
        @else
            {{-- 5. Vòng lặp hiển thị danh sách món ăn --}}
            @foreach($recipes as $recipe)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm hover-shadow transition">
                    {{-- Hiển thị ảnh thông minh (Online hoặc Local) --}}
                    <div style="height: 200px; overflow: hidden; position: relative;">
                        @if(Str::startsWith($recipe->image, 'http'))
                            <img src="{{ $recipe->image }}" class="card-img-top" alt="{{ $recipe->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img src="{{ asset('storage/' . $recipe->image) }}" class="card-img-top" alt="{{ $recipe->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>

                    <div class="card-body">
                        <h5 class="card-title text-truncate" title="{{ $recipe->title }}">
                            <a href="{{ route('recipe.show', $recipe->id) }}" class="text-decoration-none text-dark">{{ $recipe->title }}</a>
                        </h5>
                        <p class="text-muted small mb-2">👨‍🍳 Bếp trưởng: <strong>{{ $recipe->user->name }}</strong></p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-warning fw-bold">★ {{ number_format($recipe->avgRating(), 1) }}</span>
                            <span class="text-muted small">({{ $recipe->reviews->count() }} đánh giá)</span>
                        </div>

                        <a href="{{ route('recipe.show', $recipe->id) }}" class="btn btn-outline-primary w-100">Xem Chi Tiết</a>
                        
                        {{-- Nút sửa/xóa cho Admin hoặc Chính chủ --}}
                        @auth
                            @if(Auth::user()->isAdmin() || Auth::id() == $recipe->user_id)
                                <div class="mt-2">
                                    <a href="{{ route('recipe.edit', $recipe->id) }}" class="btn btn-sm btn-warning w-100 mb-1">
                                        ✏️ Sửa ảnh / Nội dung
                                    </a>
                                    
                                    <form action="{{ route('recipe.destroy', $recipe->id) }}" method="POST">
                                         @csrf 
                                         @method('DELETE')
                                         <button class="btn btn-sm btn-light text-danger w-100 border-0" onclick="return confirm('Xóa bài này nhé?')">🗑 Xóa bài</button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    {{-- 6. Thanh phân trang --}}
    <div class="d-flex justify-content-center mt-4 mb-5">
        {{ $recipes->appends(['keyword' => request('keyword')])->links() }} 
        {{-- Lưu ý: thêm appends để khi chuyển trang vẫn giữ từ khóa tìm kiếm --}}
    </div>

</div>
@endsection