<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * 季節に関連する商品を取得
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
