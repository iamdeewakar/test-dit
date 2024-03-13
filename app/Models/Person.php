<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'parent_id'];

    public function children()
    {
        return $this->hasMany(Person::class, 'parent_id', 'id');
    }
}
