<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'profile_image',
        'id_scanlator',
        'role',
        'joined_scan_at',
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
        'joined_scan_at' => 'datetime',
    ];

    public static function withUserInfos()
    {
        return User::select('name', 'id', 'profile_image', 'created_at', 'role')
                    ->with(['comments' => function($q) {
                        $q->orderBy('created_at', 'desc')
                            ->limit(5);
                    }, 'comments.chapter' => function($q) {
                        $q->select('id_manga', 'chapters.id', 'order');
        }]);
    }

    public static function onlyIdRole()
    {
        return User::select('id', 'role');
    }

    public static function getPendingInvites(User $user)
    {
        return $user->invites()
                        ->with('scanlator:id,name')
                        ->where('response', null)
                        ->orderBy('created_at')
                        ->limit(3)
                        ->get();
    }

    public function deleteInvites()
    {
        Invite::where('id_invited', $this->id)
                ->delete();
    }

    public function invites()
    {
        return $this->hasMany(Invite::class, 'id_invited');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_user');
    }
}
