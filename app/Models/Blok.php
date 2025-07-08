<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blok extends Model
{
    use HasFactory;


    protected $table = 'bloks'; 

    public function rumah()
    {
        return $this->hasMany(Rumah::class, 'blok_id');
    }
    
}

