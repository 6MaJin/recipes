<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'note'
    ];
    public static $rules = [
        'name'=> 'string|required',
        'note'=> 'string|nullable',
    ];
    public function category_product() {
        return $this->belongsToMany(Product::class);
    }
}
