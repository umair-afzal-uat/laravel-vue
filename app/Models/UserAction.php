<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'action_type', 'description', 'ip_address'
    ];

    // Relationship to User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
