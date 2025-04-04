<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tableau extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'price',
        'image',
        'user_id'
    ];

    // Categories for filtering
    public static $categories = [
        'traditionnel' => 'Traditionnel',
        'moderne' => 'Moderne',
        'calligraphie' => 'Calligraphie',
        'abstrait' => 'Abstrait',
        'paysage' => 'Paysage',
        'portrait' => 'Portrait',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function painter()
    {
        return $this->belongsTo(Painter::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(TableauImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(TableauImage::class)->where('is_primary', true)->withDefault([
            'image_path' => $this->image 
        ]);
    }
}