<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';
    protected $guarded = false;
    public $timestamps = false;

    public function user(): hasMany
    {
        return $this->hasMany(User::class);
    }
}
