<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'referer_id',
        'email',
        'password',
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
    /*protected $casts = [
        'email_verified_at' => 'datetime',
    ];*/

    public static function createUser(array $data)
    {
        $referer = User::findByReferer($data);
        $result = User::create([
            'referer_id' => $referer['id'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
        if($result){
            Reward::createReward($referer['id']);
        }
    }

    public static function findByReferer(array $data)
    {
        return User::where('email', '=', $data['referer_id'])->get()->first();
    }

    public static function getUsersById(int $id)
    {
        return User::select("id","email") ->where('referer_id', '=', $id)-> get();
    }
}
