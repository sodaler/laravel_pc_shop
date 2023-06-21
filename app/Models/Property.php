<?php

namespace App\Models;

use App\Collections\PropertyCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function newCollection(array $models = []): PropertyCollection
    {
        return new PropertyCollection($models);
    }
}
