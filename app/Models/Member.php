<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'nama', 
    'email', 
    'no_telpon', 
    'alamat', 
    'jenis_kelamin'
    ])
]

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
