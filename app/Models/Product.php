<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'note'
    ];
    public static $rules = [
        'name'=> 'string|required',
        'note'=> 'string|nullable'
    ];
    public function shoppinglists () {
        return $this->belongsToMany(Shoppinglist::class, 'product_shoppinglist', 'product_id', 'shoppinglist_id')->withTimestamps();
    }


    public function sortedProducts() {
        return $this->belongsToMany(Shoppinglist::class)
            ->wherePivot('sort', $this->id)
            ->orderBy('sort');
    }

}
