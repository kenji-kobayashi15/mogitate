<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 一括割り当てを許可する項目（後の保存処理で必要になります）
    protected $fillable = ['name', 'price', 'image', 'description'];

    /**
     * 商品に関連する季節を取得
     */
    public function seasons()
    {
        return $this->belongsToMany(Season::class);
    }
}
