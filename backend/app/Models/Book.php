<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Book extends Model
{
    use HasFactory, SoftDeletes;

   protected $primaryKey = 'Codl';
    public $timestamps = false;
    protected $fillable = ['Titulo', 'Editora', 'Edicao', 'AnoPublicacao'];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'livro_autor', 'Livro_Codl', 'Autor_CodAu');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'livro_assunto', 'Livro_Codl', 'Assunto_CodAs');
    }
}
