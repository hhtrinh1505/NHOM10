@extends('layouts.app')

@section('content')
<div class="row">
    @foreach($recipes as $recipe)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <img src="{{ asset('storage/' . $recipe->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title">{{ $recipe->title }}</h5>
                <p class="text-muted small">Đăng bởi: {{ $recipe->user->name }}</p>
                <div class="mb-2">
                    <span class="text-warning">★ {{ number_format($recipe->avgRating(), 1) }}</span>
                    <span class="text-muted">({{ $recipe->reviews->count() }} đánh giá)</span>
                </div>
                <a href="{{ route('recipe.show', $recipe->id) }}" class="btn btn-outline-primary w-100">Xem Chi Tiết</a>
                
                @auth
                    @if(Auth::user()->isAdmin() || Auth::id() == $recipe->user_id)
                        <form action="{{ route('recipe.destroy', $recipe->id) }}" method="POST" class="mt-2">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger w-100" onclick="return confirm('Xóa bài này?')">Xóa bài</button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection