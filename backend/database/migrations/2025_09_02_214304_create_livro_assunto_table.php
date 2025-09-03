<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('livro_assunto', function (Blueprint $table) {
            $table->integer('Livro_Codl')->unsigned();
            $table->integer('Assunto_CodAs')->unsigned();

            $table->foreign('Livro_Codl', 'Livro_Assunto_FKIndex1')
                  ->references('Codl')
                  ->on('books')
                  ->onDelete('cascade');

            $table->foreign('Assunto_CodAs', 'Livro_Assunto_FKIndex2')
                  ->references('codAs')
                  ->on('subjects')
                  ->onDelete('cascade');

            $table->primary(['Livro_Codl', 'Assunto_CodAs']);
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('livro_assunto');
    }
};
