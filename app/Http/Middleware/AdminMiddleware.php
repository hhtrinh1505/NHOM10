<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    // Kiểm tra: Nếu đã đăng nhập VÀ là admin
    if (Auth::check() && Auth::user()->isAdmin()) {
        return $next($request);
    }

    // Nếu không phải admin thì chặn lại, báo lỗi 403 hoặc đá về trang chủ
    abort(403, 'Bạn không có quyền truy cập trang này');
}
}
