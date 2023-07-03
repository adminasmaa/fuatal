<?php

namespace App\Models;

use App\Base\SluggableModel;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends SluggableModel
{
    use HasFactory;

     protected $fillable = [
        'title', 
        'title_ar', 
        'description',
        'description_ar',
        'nutritional_info',
        'nutritional_info_ar',
        'color_code',
        'sku',
        'offer',
        'video'
     ];  
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Article::class)->published();
    }

    public function lotteries()
    {
        return $this->hasMany(\App\Models\Lottery::class, 'product_id', 'id');
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function getLinkAttribute(): string
    {
        return route('subcategory', ['cSlug' => $this->slug]);
    }
}
