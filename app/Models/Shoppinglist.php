<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoppinglist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'note'
    ];

    public function has_user()
    {
        return $this->belongsTo(User::class);
    }

    public function list_products()
    {
        return $this->belongsToMany(Product::class);
    }
}
