<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    protected $fillable = [
        'user_id',
        'yandex_url',
        'company_id',
        'test_field'
    ];
    protected $guarded = [];
}
