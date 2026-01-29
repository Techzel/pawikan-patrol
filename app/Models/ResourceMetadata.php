<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceMetadata extends Model
{
    protected $table = 'resource_metadata';
    protected $fillable = ['filename', 'title', 'description', 'published_date', 'base64_data'];

    protected $casts = [
        'published_date' => 'date',
    ];
}
