<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable =[
        'property_name',
        'location',
        'description',
        'actual_price',
        'promo_price',
        'survey_price',
        'deed_of_assignment',
        'c_of_o',
        'promo_details',
        'developmental_levy',
        'property_images'
    ];
}
