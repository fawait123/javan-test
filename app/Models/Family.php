<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function child()
    {
        return $this->hasMany(Family::class,'parentID');
    }

    public function grandChild()
    {
        return $this->hasMany(Family::class,'parentID');
    }
}
