<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'group',
        'subgroup',
        'kcal',
        'kj',
        'water',
        'dietary_fiber',
        'carbohydrates',
        'proteins',
        'total_lipids',
        'saturated_lipids',
        'monosaturated_lipids',
        'polysaturated_lipids',
        'cholesterol',
        'calcium',
        'phosphorus',
        'iron',
        'magnesium',
        'sodium',
        'potassium',
        'zinc',
        'potassium',
        'zinc',
        'vitamin_a',
        'ascorbic_acid',
        'thiamin',
        'riboflavin',
        'niacin',
        'pyridoxine',
        'folic_acid',
        'cobalamin',
        'edible_percentage',
    ];

    /**
     * Relationships
     */
    public function menu()
    {
        return $this->belongsToMany(Menu::class)
            ->withPivot('weight', 'kind_of_food');
    }
}
