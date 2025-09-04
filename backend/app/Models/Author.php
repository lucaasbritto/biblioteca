<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'CodAu';
    public $timestamps = false;

    protected $fillable = ['Nome'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'livro_autor', 'Autor_CodAu', 'Livro_Codl');
    }
}

