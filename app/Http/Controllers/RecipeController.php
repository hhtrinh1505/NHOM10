<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    // CẬP NHẬT: Hàm index nhận Request để xử lý tìm kiếm
    public function index(Request $request) {
        // 1. Khởi tạo query và load quan hệ user
        $query = Recipe::with('user');

        // 2. Kiểm tra và lọc theo từ khóa (nếu có)
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('ingredients', 'like', '%' . $keyword . '%');
            });
        }

      
        $recipes = $query->latest()->paginate(8); 

        return view('home', compact('recipes'));
    }

    public function create() { return view('recipes.create'); }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'ingredients' => 'required',
            'steps' => 'required',
        ]);

        $path = $request->file('image')->store('recipes', 'public');

        Recipe::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'image' => $path,
            'description' => $request->description,
            'ingredients' => $request->ingredients,
            'steps' => $request->steps,
        ]);

        return redirect()->route('home')->with('success', 'Đã đăng công thức!');
    }

    public function show($id) {
        $recipe = Recipe::with(['reviews.user', 'user'])->findOrFail($id);
        return view('recipes.show', compact('recipe'));
    }

    // Lưu bình luận & đánh giá
    public function storeReview(Request $request, $id) {
        $request->validate(['rating' => 'required|integer|min:1|max:5', 'comment' => 'required']);
        Review::create([
            'user_id' => Auth::id(),
            'recipe_id' => $id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);
        return back();
    }
    
    // Admin xóa bài
    public function destroy($id) {
        $recipe = Recipe::findOrFail($id);
        // Chỉ admin hoặc chủ bài viết mới được xóa
        if(Auth::user()->isAdmin() || Auth::id() == $recipe->user_id) {
            $recipe->delete();
            return redirect()->route('home')->with('success', 'Đã xóa bài viết');
        }
        return abort(403);
    }

    // 1. Mở trang sửa
    public function edit($id)
    {
        $recipe = Recipe::findOrFail($id);
        
        // Kiểm tra quyền: Chỉ Admin hoặc Chủ bài viết mới được sửa
        if(Auth::user()->role !== 'admin' && Auth::id() !== $recipe->user_id) {
            abort(403, 'Bạn không có quyền sửa bài này');
        }

        return view('recipes.edit', compact('recipe'));
    }

    // 2. Lưu cập nhật
    public function update(Request $request, $id)
    {
        $recipe = Recipe::findOrFail($id);

        // Validate dữ liệu
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image', // Ảnh không bắt buộc
        ]);

        // Cập nhật thông tin chữ
        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->ingredients = $request->ingredients;
        $recipe->steps = $request->steps;

  
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('recipes', 'public');
            $recipe->image = $path;
        }

        $recipe->save();

        return redirect()->route('home')->with('success', 'Đã cập nhật món ăn thành công!');
    }
    // Thêm vào cuối class RecipeController

public function getSuggestions(Request $request) {
    $keyword = $request->keyword;
    
    if($keyword) {
        // Tìm 5 món ăn có tên gần giống nhất
        $recipes = Recipe::where('title', 'like', '%' . $keyword . '%')
                        ->take(5) // Chỉ lấy 5 kết quả gọn nhẹ
                        ->get(['id', 'title', 'image']); // Chỉ lấy thông tin cần thiết

        return response()->json($recipes);
    }
    
    return response()->json([]);
}
}