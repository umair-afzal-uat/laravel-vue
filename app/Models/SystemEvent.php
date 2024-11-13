<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type', 'event_description', 'event_data'
    ];
}
