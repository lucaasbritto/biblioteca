<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('codAs');
            $table->string('Descricao', 20);
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
};
