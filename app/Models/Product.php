<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'products';
    protected $primaryKey = 'id';

     /**
     * Ensure Scout uses a string ID.
     */
    public function getScoutKey(): string
    {
        return (string) $this->getKey();
    }

    /**
     * Prepare the data array for indexing.
     */
    public function toSearchableArray(): array
    {
        return [
            'id'            => (string) $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'price'         => $this->price,
            'category_name' => $this->category?->name, // include related field
        ];
    }

    protected $fillable = [
        'code',
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function getActiveProducts()
    {
        return $this->where('active', 1)->get();
    }
    public function getInactiveProducts()
    {
        return $this->where('active', 0)->get();
    }
    public function getProductsByCategory($categoryId)
    {
        return $this->where('category_id', $categoryId)->get();
    }
}
