@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-8">
        <img src="{{ asset('storage/' . $recipe->image) }}" class="w-100 rounded mb-3">
        <h2>{{ $recipe->title }}</h2>
        <p class="text-muted">Đăng bởi: {{ $recipe->user->name }} | Ngày: {{ $recipe->created_at->format('d/m/Y') }}</p>
        <hr>
        <h5>Mô tả:</h5> <p>{{ $recipe->description }}</p>
        <h5>Nguyên liệu:</h5> <p style="white-space: pre-line">{{ $recipe->ingredients }}</p>
        <h5>Cách làm:</h5> <p style="white-space: pre-line">{{ $recipe->steps }}</p>
    </div>

    <div class="col-md-4">
        <div class="card p-3 mb-3">
            <h4>Đánh giá ({{ number_format($recipe->avgRating(), 1) }}/5 ⭐)</h4>
            
            @auth
            <form action="{{ route('review.store', $recipe->id) }}" method="POST" class="mb-3">
                @csrf
                <select name="rating" class="form-select mb-2">
                    <option value="5">5 Sao - Xuất sắc</option>
                    <option value="4">4 Sao - Ngon</option>
                    <option value="3">3 Sao - Tạm được</option>
                    <option value="2">2 Sao - Không ngon</option>
                    <option value="1">1 Sao - Tệ</option>
                </select>
                <textarea name="comment" class="form-control mb-2" placeholder="Nhập bình luận..." required></textarea>
                <button class="btn btn-primary btn-sm w-100">Gửi đánh giá</button>
            </form>
            @else
                <p><a href="{{ route('login') }}">Đăng nhập</a> để đánh giá.</p>
            @endauth

            <div class="reviews-list">
                @foreach($recipe->reviews as $review)
                    <div class="border-bottom py-2">
                        <strong>{{ $review->user->name }}</strong> <span class="text-warning">{{ $review->rating }} ⭐</span>
                        <p class="mb-0 text-muted small">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection