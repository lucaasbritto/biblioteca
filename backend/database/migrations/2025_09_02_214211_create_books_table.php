<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('Codl');
            $table->string('Titulo', 40);
            $table->string('Editora', 40)->nullable();
            $table->integer('Edicao')->nullable();
            $table->string('AnoPublicacao', 4)->nullable();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
