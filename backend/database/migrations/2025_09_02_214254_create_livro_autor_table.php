<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('livro_autor', function (Blueprint $table) {
            $table->integer('Livro_Codl')->unsigned();
            $table->integer('Autor_CodAu')->unsigned();

            $table->foreign('Livro_Codl', 'Livro_Autor_FKIndex1')
                  ->references('Codl')
                  ->on('books')
                  ->onDelete('cascade');

            $table->foreign('Autor_CodAu', 'Livro_Autor_FKIndex2')
                  ->references('CodAu')
                  ->on('authors')
                  ->onDelete('cascade');

            $table->primary(['Livro_Codl', 'Autor_CodAu']);
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('livro_autor');
    }
};
