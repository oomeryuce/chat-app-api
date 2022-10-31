<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Messages extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function room() {
        return $this->belongsTo(Rooms::class, 'room_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
