<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nutritionist extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'professional_license',
        'user_id'
    ];
    /**
     * Relationships
     */
    public function patient()
    {
        return $this->hasMany(Patient::class);
    }
}
