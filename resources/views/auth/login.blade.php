@extends('layouts.app')
@section('content')
<div class="col-md-6 mx-auto">
    <h3>Đăng Nhập</h3>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-3"><label>Mật khẩu</label><input type="password" name="password" class="form-control" required></div>
        <button class="btn btn-primary w-100">Đăng Nhập</button>
    </form>
</div>
@endsection