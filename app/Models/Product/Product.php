<?php

namespace App\Models\Product;

use App\Models\User;
use App\Models\Shop\Shop;
use Illuminate\Support\Str;
use App\Models\Product\Base\Size;
use App\Models\General\Brand\Brand;
use App\Models\Product\Base\Weight;
use App\Models\Product\ProductMedia;
use App\Models\Product\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use App\Models\General\Category\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['shop_id', 'user_id', 'name', 'slug', 'sku', 'category_id', 'brand_id', 'stocks', 'total_stocks', 'price', 'currency_type',  'discount', 'discount_type', 'offer', 'tag', 'warranty', 'guarantee', 'return_policy', 'thumbnail', 'description', 'audio', 'video_url', 'can_bargain', 'delivery_offer', 'delivery_offer_type', 'vat', 'alert', 'product_type'];
    // protected $fillable = [
    //     'ref', 'name', 'slug', 'sku', 'shop_id', 'user_id', 'brand_id', 'thumbnail',
    //     'can_bargain', 'product_type', 'return_policy', 'warranty', 'guarantee', 'currency_type', 'discount', 'discount_type', 'description',
    //     'offers', 'price', 'stocks', 'total_stocks', 'tag', 'alert', 'video_url', 'delivery_offer',
    // ];
    protected $dates = ['deleted_at'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::of($value)->slug('-');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productCategory()
    {
        return $this->hasOne(ProductCategory::class);
    }

    public function productMedia()
    {
        return $this->hasMany(ProductMedia::class);
    }

    public function productImage()
    {
        return $this->productMedia()->where('type', 'ímage');
    }

    public function productAudio()
    {
        return $this->productMedia()->where('type', 'audio');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, (new ProductSize())->getTable())
            ->withPivot('price', 'stocks')
            ->withTimestamps();
    }

    public function weights()
    {
        return $this->belongsToMany(Weight::class, (new ProductWeight())->getTable())
            ->withPivot('price', 'stocks')
            ->withTimestamps();
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function lowSizePrice(){
        return $this->hasOne(ProductSize::class)->orderBy('price', 'asc');
    }

    public function highSizePrice(){
        return $this->hasOne(ProductSize::class)->orderBy('price', 'desc');
    }

    public function lowWeightPrice(){
        return $this->hasOne(ProductWeight::class)->orderBy('price', 'asc');
    }

    public function highWeightPrice(){
        return $this->hasOne(ProductWeight::class)->orderBy('price', 'desc');
    }

    public function productWeights()
    {
        return $this->hasMany(ProductWeight::class);
    }

    public function features()
    {
        return $this->hasMany(ProductFeature::class);
    }

    public function discountPrice()
    {
        if ($this->discount_type === 'Percent') {
            $dis = $this->price - ($this->price * $this->discount) / 100;
            return round($dis, 2);
        } else {
            return $this->price - $this->discount;
        }
    }

    public function totalStocks()
    {
        if($this->product_type === 'simple')
        {
            return $this->stocks;

        } else if($this->product_type == 'size_base')
        {
            return $this->productSizes->sum('stocks');
        }else {
            return $this->productWeights()->sum('stocks');
        }
    }

}
