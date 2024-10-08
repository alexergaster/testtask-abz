<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $guarded = false;
    public $timestamps = false;

    public function position() : belongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
