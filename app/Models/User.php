<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'google_id',
        'avatar',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Role Hierarchy Helper Methods
    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCeo()
    {
        return $this->role === 'ceo';
    }

    public function hasAdminAccess()
    {
        return in_array($this->role, ['manager', 'admin', 'ceo']);
    }

    public function hasFullAdminAccess()
    {
        return in_array($this->role, ['admin', 'ceo']);
    }

    public function hasCeoAccess()
    {
        return $this->role === 'ceo';
    }

    // Permission Methods
    public function canManageUsers()
    {
        return in_array($this->role, ['admin', 'ceo']);
    }

    public function canManageProducts()
    {
        return in_array($this->role, ['manager', 'admin', 'ceo']);
    }

    public function canManageContacts()
    {
        return in_array($this->role, ['manager', 'admin', 'ceo']);
    }

    public function canViewDashboard()
    {
        return in_array($this->role, ['manager', 'admin', 'ceo']);
    }

    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return null;
        }
        
        if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }
        
        return asset('storage/avatars/' . $this->avatar);
    }

    public function getRoleLabel()
    {
        $labels = [
            'customer' => 'Customer',
            'manager' => 'Manager',
            'admin' => 'Administrator',
            'ceo' => 'CEO'
        ];

        return $labels[$this->role] ?? 'Unknown';
    }

    public function getRoleColor()
    {
        $colors = [
            'customer' => 'secondary',
            'manager' => 'info',
            'admin' => 'warning',
            'ceo' => 'danger'
        ];

        return $colors[$this->role] ?? 'secondary';
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
