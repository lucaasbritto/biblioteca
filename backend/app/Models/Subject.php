<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $primaryKey = 'codAs';
    public $timestamps = false;

    protected $fillable = ['Descricao'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'livro_assunto', 'Assunto_codAs', 'Livro_Codl');
    }
}