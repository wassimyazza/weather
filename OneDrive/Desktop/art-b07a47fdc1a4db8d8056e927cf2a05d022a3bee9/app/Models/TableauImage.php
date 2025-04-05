<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableauImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'tableau_id',
        'image_path',
        'is_primary',
        'display_order'
    ];

    /**
     * Get the tableau that owns the image.
     */
    public function tableau()
    {
        return $this->belongsTo(Tableau::class);
    }
}