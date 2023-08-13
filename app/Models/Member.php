<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    /**
     * @return BelongsToMany
     */
    public function institution(): BelongsToMany
    {
        return $this
            ->belongsToMany(Institution::class, 'tbl_point', 'member_id', 'institution_id')
            ->withPivot('points_earned');
    }
}
