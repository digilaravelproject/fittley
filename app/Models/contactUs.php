<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    // Table name (optional because Laravel will guess 'contact_us')
    protected $table = 'contact_us';

    // Fillable columns
    protected $fillable = [
        'name',
        'phone_number',
        'detail',
    ];
}

