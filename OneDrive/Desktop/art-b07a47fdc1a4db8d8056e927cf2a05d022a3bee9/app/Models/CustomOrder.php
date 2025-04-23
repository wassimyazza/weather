<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'size',
        'paint_type',
        'custom_size',
        'colors',
        'reference_image',
        'customer_name',
        'customer_phone',
        'customer_address',
        'status',
        'custom_orders',
        'confirmation_token',
    ];

    public static $sizes = [
        'small' => 'Petit (30x40 cm)',
        'medium' => 'Moyen (50x70 cm)',
        'large' => 'Grand (70x100 cm)',
        'xlarge' => 'Très grand (100x150 cm)',
        'custom' => 'Taille personnalisée'
    ];
    
    public static $paintTypes = [
        'oil' => 'Peinture à l\'huile',
        'acrylic' => 'Peinture acrylique',
        'watercolor' => 'Aquarelle',
        'pen' => 'Stylo/Encre'
    ];

    public static $statuses = [
        'pending' => 'En attente',
        'in_progress' => 'En cours de réalisation',
        'completed' => 'Terminé',
        'cancelled' => 'Annulé'
    ];
}