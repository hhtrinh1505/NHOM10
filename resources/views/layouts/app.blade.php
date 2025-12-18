<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Ngũ Công Chúa - Chia sẻ công thức</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom { background-color: #6f42c1; } 
        .btn-custom { background-color: #ffc107; color: #000; font-weight: bold; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">👑 NGŨ CÔNG CHÚA</a>
            <div class="d-flex">
                @auth
                    <span class="navbar-text text-white me-3">Xin chào, {{ Auth::user()->name }} 
                        @if(Auth::user()->isAdmin()) (ADMIN) @endif
                    </span>
                    <a href="{{ route('recipe.create') }}" class="btn btn-custom btn-sm me-2">+ Chia sẻ Món mới</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf <button class="btn btn-outline-light btn-sm">Thoát</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-custom btn-sm">Đăng ký</a>
                @endauth
            </div>
          <div class="search-box d-none d-md-block position-relative">
    <form action="{{ route('home') }}" method="GET" id="searchForm">
        <input type="text" 
               name="keyword" 
               id="searchInput"
               class="form-control search-input" 
               placeholder="Tìm công thức, nguyên liệu..."
               value="{{ request('keyword') }}"
               autocomplete="off"> <button type="submit" class="search-btn">
            <i class="fas fa-search"></i>
        </button>
    </form>

    <ul id="suggestionList" class="list-group position-absolute w-100 shadow-sm" 
        style="top: 100%; left: 0; z-index: 1000; display: none; max-height: 300px; overflow-y: auto;">
        </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const suggestionList = document.getElementById('suggestionList');
        const searchForm = document.getElementById('searchForm');
        let timeout = null;

        // 1. Bắt sự kiện khi người dùng gõ phím
        searchInput.addEventListener('input', function() {
            const keyword = this.value;

            // Xóa timeout cũ để tránh gọi server liên tục (Debounce)
            clearTimeout(timeout);

            if (keyword.length < 2) { // Chỉ tìm khi gõ trên 1 ký tự
                suggestionList.style.display = 'none';
                return;
            }

            // Đợi 300ms sau khi ngừng gõ mới gửi request
            timeout = setTimeout(() => {
                fetch(`{{ route('ajax.search') }}?keyword=${keyword}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestionList.innerHTML = ''; // Xóa gợi ý cũ

                        if (data.length > 0) {
                            suggestionList.style.display = 'block';
                            
                            data.forEach(recipe => {
                                // Tạo đường dẫn ảnh
                                let imgUrl = recipe.image.startsWith('http') ? recipe.image : `/storage/${recipe.image}`;
                                
                                // Tạo thẻ <li> cho từng món
                                const li = document.createElement('li');
                                li.className = 'list-group-item list-group-item-action d-flex align-items-center cursor-pointer';
                                li.style.cursor = 'pointer';
                                li.innerHTML = `
                                    <img src="${imgUrl}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                    <span class="fw-bold text-dark">${recipe.title}</span>
                                `;

                                // 2. Khi click vào gợi ý
                                li.addEventListener('click', function() {
                                    searchInput.value = recipe.title; // Điền tên món vào ô tìm kiếm
                                    suggestionList.style.display = 'none'; // Ẩn danh sách
                                    searchForm.submit(); // Tự động Submit form để lọc đúng món đó
                                });

                                suggestionList.appendChild(li);
                            });
                        } else {
                            suggestionList.style.display = 'none';
                        }
                    });
            }, 300);
        });

        // 3. Ẩn danh sách khi click ra ngoài
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionList.contains(e.target)) {
                suggestionList.style.display = 'none';
            }
        });
    });
</script>
        </button>
    </form>
</div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>