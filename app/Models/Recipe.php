<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'note',
        'user_id'
    ];
    public static $rules = [
        'name'=> 'string|required',
        'note'=> 'string|nullable',
        'user_id' => 'integer'
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_recipe', 'recipe_id', 'product_id')->withTimestamps();
    }
    public function create_shoppinglist() {
        $shoppinglist = new Shoppinglist([
            'name' => $this['name'],
            'note' => $this['note'],
            'user_id' => auth()->id()
        ]);
    }
}
