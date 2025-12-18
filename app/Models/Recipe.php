<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'image', 'description', 'ingredients', 'steps', 'user_id'];

    public function user() { return $this->belongsTo(User::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    
    // Tính điểm trung bình sao
    public function avgRating() {
        return $this->reviews()->avg('rating') ?? 0;
    }
}