<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailUser extends Model
{
    use HasFactory;

    protected $table = 'detail_user';
    protected $fillable = [
        'address', 'gender', 'no_hp', 'user_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id');
    }
}
