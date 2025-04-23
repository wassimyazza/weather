<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Painter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'info',
        'born_in',
        'image_profile',
    ];

    protected $casts = [
        'born_in' => 'date',
    ];

    /**
     * Get the tableaux that belong to the painter.
     */
    public function tableaux()
    {
        return $this->hasMany(Tableau::class, 'user_id');
    }

    /**
     * Get the latest painter with their tableaux.
     */
    public static function getLatestWithTableaux($tableauxLimit = 3)
    {
        return self::latest()
            ->with(['tableaux' => function ($query) use ($tableauxLimit) {
                $query->take($tableauxLimit);
            }])
            ->first();
    }
}