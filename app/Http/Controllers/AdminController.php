<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe; // Nhớ dòng này để gọi món ăn
use App\Models\User;   // Nhớ dòng này để gọi user
use App\Models\Review; // Nhớ dòng này nếu có xóa review

class AdminController extends Controller
{
    // 1. Hàm index: Hiển thị trang Dashboard
    public function index()
    {
        // Lấy danh sách bài CHƯA duyệt (is_approved = 0)
        $pendingRecipes = Recipe::where('is_approved', false)->with('user')->get();
        
        // Trả về giao diện dashboard kèm dữ liệu
        return view('admin.dashboard', compact('pendingRecipes'));
    }

    // 2. Hàm duyệt bài
    public function approveRecipe($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->is_approved = true; // Đổi sang đã duyệt
        $recipe->save();

        return redirect()->back()->with('success', 'Đã duyệt bài viết thành công!');
    }

    // 3. Hàm xóa bài
    public function deleteRecipe($id)
    {
        Recipe::destroy($id);
        return redirect()->back()->with('success', 'Đã xóa bài viết!');
    }
    
    // 4. Hàm xóa người dùng (nếu cần)
    public function deleteUser($id) {
        $user = User::findOrFail($id);
        if (!$user->isAdmin()) {
            $user->delete();
            return redirect()->back()->with('success', 'Đã xóa người dùng!');
        }
        return redirect()->back()->with('error', 'Không thể xóa Admin!');
    }
    // 1. Mở trang sửa (lấy thông tin bài viết và danh sách user)
public function edit($id)
{
    $recipe = Recipe::findOrFail($id);
    $users = User::all(); // Lấy danh sách người dùng để chọn
    return view('admin.edit', compact('recipe', 'users'));
}

public function update(Request $request, $id)
{
    $recipe = Recipe::findOrFail($id);
    // Cập nhật người đăng mới
    $recipe->user_id = $request->user_id;
    $recipe->save();

    return redirect()->route('admin.dashboard')->with('success', 'Đã đổi tác giả thành công!');
}
}