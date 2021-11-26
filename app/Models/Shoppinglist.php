<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Shoppinglist extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    protected $fillable = [
        'name',
        'note',
        'user_id',
        'public'
    ];
    public static $rules = [
        'name'=> 'regex:/(^[A-Za-z0-9 ])+/|required',
        'note'=> 'regex:/(^[A-Za-z0-9 ]+$)+/|nullable',
        'user_id' => 'integer',
        'public' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_shoppinglist', 'shoppinglist_id', 'product_id')->withPivot('sort', 'count')->withTimestamps();
    }
}
