<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;
    protected $with = [ 'participants' ];

    public function participants() {
        return $this->belongsToMany(MessageParticipants::class);
    }
}
