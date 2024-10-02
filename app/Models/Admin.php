<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    // use HasFactory;

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array<int, string>
    //  */
    // protected $fillable = [
    //     'user_id',
    // ];

    // /**
    //  * Get the user that owns the admin.
    //  */
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // /**
    //  * Upgrade a user to an expert.
    //  */
    // public function upgradeToExpert(User $user, string $expertise)
    // {
    //     return Expert::create([
    //         'user_id' => $user->id,
    //         'expertise' => $expertise,
    //     ]);
    // }
}