<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // Tạo 1 tài khoản Admin mẫu
    \App\Models\User::factory()->create([
        'name' => 'Admin User',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('12345679'), // Mật khẩu là 12345679
        'role' => 'admin', // <--- QUAN TRỌNG NHẤT: Đánh dấu là admin
    ]);


}
}
