<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'identifier',
        'email',
        'password',
        'email_verified_at',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function nutritionist()
    {
        return $this->belongsTo(Nutritionist::class);
    }

    public function administrator()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    /**
     * Functions
     */
    public function role()
    {
        return $this->roles->first()->name;
    }

    public function isAdmin()
    {
        return $this->roles->first()->name === 'admin';
    }

    public function isNutritionist()
    {
        return $this->roles->first()->name === 'nutritionist';
    }

    public function isPatient()
    {
        return $this->roles->first()->name === 'patient';
    }

    public function menuCounter()
    {
        return $this->menus->count();
    }

    public function activeLicense()
    {
        return $this->licenses->where('is_active', true)
            ->orWhere('expiration_date', '<', Carbon::now())
            ->first();
    }

    public function caloricRequirement(
        $weight,
        $height,
        $dateOfBirth,
        $psychical_activity = 'sedentary',
        $genre = 'woman',
    )
    {
        $age = Carbon::parse($dateOfBirth)->age;
        $dif = $genre === 'woman'
                    ? -161
                    : 5;

        $GEB = (10 * $weight) + (6.25 * $height) - (5 * $age) + $dif;
        $ETA = $GEB * 0.10;
        $FAF = match ($psychical_activity) {
            'sedentary' => 0,
            'light' => $genre === 'woman'
                    ? 0.12
                    : 0.14,
            'moderate' => 0.27,
            'intense' => 0.54,
            default => 0
        };

        return $GEB + $ETA + $GEB * $FAF;
    }

    public function automaticCalculation($id)
    {
        return $this->menus()->where('id', $id)->first()
            ->automatic_calculation;
    }

    public function fullName()
    {
        return $this->name . ' ' . $this->last_name;
    }
}
