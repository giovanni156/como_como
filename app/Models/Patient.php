<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'weight',
        'height',
        'date_of_birth',
        'gender',
        'psychical_activity',
        'caloric_requirement',
        'waist_size',
        'legs_size',
        'wrist_size',
        'user_id',
        'nutritionist_id'
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nutritionist()
    {
        return $this->belongsTo(Nutritionist::class);
    }
}
