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
        'scan_role',
        'joined_scan_at',
        'timezone',
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

    public static function withInfo()
    {
        return User::select('name', 'id', 'profile_image', 'created_at', 'role')
                    ->with(['comments' => function($q) {
                        $q->orderBy('created_at', 'desc')
                            ->limit(5);
                    },
                    'comments.chapter:id_manga,id,order',
                    'favorites' => function($q) {
                        $q->limit(4);
                    },
                    'favorites.manga:id,name,cover'
        ]);
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

    public function becomeLeader()
    {
        $scan = $this->scanlator;
        $prev_leader = $scan->leader;

        $scan->update([
            'id_leader' => $this->id
        ]);
        $this->update([
            'scan_role' => 'Leader',
            'role' => 3
        ]);
        $prev_leader->update([
            'scan_role' => null,
            'role' => 2
        ]);
    }

    public function invites()
    {
        return $this->hasMany(Invite::class, 'id_invited');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_user');
    }

    public function scanlator()
    {
        return $this->belongsTo(Scanlator::class, 'id_scanlator');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'id_user')->orderBy('id', 'desc');
    }
}
