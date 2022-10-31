<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageParticipants extends Model
{
    use HasFactory;
    protected $table = 'group_participants';
    protected $with = [ 'user' ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
