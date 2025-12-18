@extends('layouts.app')
@section('content')
<div class="col-md-6 mx-auto">
    <h3>Đăng Ký Thành Viên</h3>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3"><label>Họ tên</label><input type="text" name="name" class="form-control" required></div>
        <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-3"><label>Mật khẩu</label><input type="password" name="password" class="form-control" required></div>
        <div class="mb-3"><label>Nhập lại Mật khẩu</label><input type="password" name="password_confirmation" class="form-control" required></div>
        <button class="btn btn-success w-100">Đăng Ký</button>
    </form>
</div>
@endsection