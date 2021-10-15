<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Nullable;

class Shoppinglist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'note',
        'user_id',
        'public'
    ];
    public static $rules = [
        'name'=> 'string|required',
        'note'=> 'string|nullable',
        'user_id' => 'integer',
        'public' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_shoppinglist', 'shoppinglist_id', 'product_id')->withTimestamps()->withPivot('sort');
    }
}
