<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersRelations extends Model
{
    protected $fillable = [
        'vendor_id', 'shop_id', 'has_access', 'can_message', 'can_see_prices'
    ];
}
