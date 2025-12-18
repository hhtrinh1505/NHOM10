<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RecipeSeeder extends Seeder
{
    public function run()
    {
       
        // Nếu không tìm thấy user 1, nó sẽ tạo đại một user mới để tránh lỗi
        $userId = DB::table('users')->first()->id ?? 1;

        $dishes = [
            ['Phở Bò Gia Truyền', 'Nước dùng hầm xương bò 24h, thơm mùi quế hồi, thịt bò tái mềm ngọt.'],
            ['Bún Chả Hà Nội', 'Chả nướng than hoa thơm lừng, nước mắm chua ngọt, ăn kèm rau sống tươi mát.'],
            ['Cơm Tấm Sườn Bì Chả', 'Gạo tấm dẻo thơm, sườn nướng mật ong cháy cạnh, bì chả nhà làm.'],
            ['Bánh Xèo Miền Tây', 'Vỏ bánh giòn rụm vàng ươm, nhân tôm thịt đầy đặn, cuốn bánh tráng rau rừng.'],
            ['Gỏi Cuốn Tôm Thịt', 'Món khai vị thanh đạm, tôm tươi rói, chấm mắm nêm đậm đà.'],
            ['Bún Bò Huế', 'Hương vị cay nồng đặc trưng, chân giò heo béo ngậy, chả cua dai ngon.'],
            ['Mì Quảng Ếch', 'Sợi mì vàng óng, thịt ếch rim đậm đà, nước dùng sâm sấp đậm vị miền Trung.'],
            ['Lẩu Thái Chua Cay', 'Nồi lẩu full topping hải sản, nước lẩu chua cay bùng nổ vị giác.'],
            ['Cá Kho Tộ', 'Cá lóc kho tộ màu cánh gián đẹp mắt, đưa cơm những ngày mưa.'],
            ['Canh Chua Cá Lóc', 'Vị chua thanh của me, ngọt của cá, thêm chút rau ngổ thơm lừng.'],
            ['Thịt Kho Tàu', 'Thịt ba chỉ kho mềm rục với trứng vịt, màu nước dừa cánh gián đẹp mắt.'],
            ['Gà Nướng Mật Ong', 'Gà nướng da giòn thịt mềm, thấm đẫm sốt mật ong và tỏi.'],
            ['Nem Rán (Chả Giò)', 'Vỏ giòn tan, nhân thịt mộc nhĩ miến dong truyền thống.'],
            ['Bánh Mì Chảo', 'Bữa sáng đầy năng lượng với pate, trứng ốp la, xúc xích và sốt cà chua.'],
            ['Chè Khúc Bạch', 'Món tráng miệng thanh mát, khúc bạch phô mai béo ngậy, hạnh nhân giòn tan.'],
            ['Bò Lúc Lắc', 'Thịt bò xào lửa lớn mềm ngọt, ăn kèm khoai tây chiên giòn.'],
            ['Súp Cua Óc Heo', 'Súp sệt nóng hổi, đầy ắp thịt cua và óc heo bổ dưỡng.'],
            ['Ốc Hương Rang Muối', 'Ốc tươi ngon, lớp muối ớt mặn cay kích thích vị giác.'],
            ['Lẩu Mắm Miền Tây', 'Hương vị mắm đặc trưng, rau đồng nội nhúng lẩu siêu ngon.'],
            ['Cơm Chiên Dương Châu', 'Hạt cơm tơi xốp, màu sắc bắt mắt từ rau củ và lạp xưởng.'],
        ];

        foreach ($dishes as $dish) {
            DB::table('recipes')->insert([
                'user_id' => $userId,
                'title' => $dish[0],
                'description' => $dish[1],
                'ingredients' => "500g nguyên liệu chính\n2 thìa gia vị\n1 chút tình yêu", // Nguyên liệu mẫu
                'steps' => "Bước 1: Sơ chế nguyên liệu.\nBước 2: Nấu chín.\nBước 3: Trình bày ra đĩa.", // Cách làm mẫu
                'image' => null, // Để null để tránh lỗi ảnh, hoặc điền 'default.jpg' nếu bạn đã chép ảnh vào
                'is_approved' => true, // <--- QUAN TRỌNG: Đã duyệt sẵn để hiện lên trang chủ luôn
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}