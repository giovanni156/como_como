<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'food_id',
        'food_weight',
        'kind_of_food',
        'menu_type',
        'it_is_ideal',
        'owner_id',
        'times_downloaded'
    ];

    /**
     * Relationships
     */
    public function foods()
    {
        return $this->belongsToMany(Food::class)
            ->withPivot('weight', 'kind_of_food');
    }
}
