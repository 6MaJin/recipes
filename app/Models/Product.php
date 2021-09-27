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
    public function product_list () {
        return $this->belongsToMany(Shoppinglist::class);
    }
    public function product_category() {
        return $this->belongsToMany(Category::class);
    }
}
