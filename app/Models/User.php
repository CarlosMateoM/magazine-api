<?php

namespace App\Models;

use App\Mail\ResetPasswordMailable;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'file_id',
        'is_locked_account',
    ];

    protected $attributes = [
        'is_locked_account' => false
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
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function author()
    {
        return $this->hasOne(Author::class);
    }


    public function loadRoleRelation()
    {
        switch ($this->role->name) {
            case 'writer':
                return $this->load('author');
            default:
                return $this;
        }
    }

    public function sendPasswordResetNotification($token): void
    {
        Mail::to($this->email)->queue(new ResetPasswordMailable($this, $token));
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new EmailVerificationNotification());
    }

    public function hasAnyRole(array $roles): bool
    {
        $role = $this->role->name;

        return in_array($role, $roles);
    }

    public function hasRole(string $role)
    {
        return $this->role->name === $role;
    }

    public function hasPermission(Permission $permission)
    {
        return $this->role->permissions->contains($permission);
    }


}
