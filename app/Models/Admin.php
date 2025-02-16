<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;

class Admin extends Authenticatable implements FilamentUser
{
    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password'];

    public function canAccessFilament(): bool
    {
        return true; // هنا يمكن إضافة صلاحيات معينة لاحقًا
    }
}

