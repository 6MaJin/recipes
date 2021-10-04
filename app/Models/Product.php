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
        return $this->belongsToMany(Shoppinglist::class)->withTimestamps();
    }

    public function sortedProducts() {
        return $this->belongsToMany('App\Models\Shoppinglist')
            ->wherePivot('sort', $this->id)
            ->orderBy('sort');
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
