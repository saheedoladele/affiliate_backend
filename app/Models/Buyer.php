<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'consultant_id',
        'property_id',
        'purchase_date',
        'amount_paid',
        'description','first_ref','second_ref',
        'direct_ref'
    ];
}
