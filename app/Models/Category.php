<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $guarded = [];
    protected $fillable = ['name', 'slug'];

    use HasFactory;

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
