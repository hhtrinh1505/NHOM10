<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    // Helper check Admin
    public function isAdmin() {
        return $this->role === 'admin';
    }
}