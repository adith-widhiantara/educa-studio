<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $table = 'tbl_member';

    protected $fillable
        = [
            'name',
            'join_date',
            'gender',
            'birth_date',
        ];

    /**
     * @return HasMany
     */
    public function points(): HasMany
    {
        return $this->hasMany(Point::class);
    }
}
