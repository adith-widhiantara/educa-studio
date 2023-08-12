<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Institution extends Model
{
    use HasFactory;

    protected $fillable
        = [
            'name',
            'city',
            'country',
        ];

    protected $table = 'tbl_institution';

    /**
     * @return HasMany
     */
    public function points(): HasMany
    {
        return $this->hasMany(Point::class);
    }

}
