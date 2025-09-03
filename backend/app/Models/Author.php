<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $primaryKey = 'CodAu';
    public $timestamps = false;

    protected $fillable = ['Nome'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'livro_autor', 'Autor_CodAu', 'Livro_Codl');
    }
}

