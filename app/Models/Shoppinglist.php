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
        'public',
        'is_recipe'
    ];
    public static $rules = [
        'name'=> 'string|required',
        'note'=> 'string|nullable',
        'user_id' => 'integer',
        'public' => 'boolean',
        'is_recipe' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('sort', 'count')->withTimestamps();
    }
}
