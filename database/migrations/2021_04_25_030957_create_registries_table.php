<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cpf');
            $table->boolean('cpf_invalid');
            $table->boolean('private');
            $table->boolean('incomplete');
            $table->date('last_buy')->nullable();
            $table->decimal('mid_ticket', '10', '2')->nullable();
            $table->decimal('last_ticket', '10', '2')->nullable();
            $table->string('usual_store')->nullable();
            $table->boolean('usual_store_invalid');
            $table->string('last_store')->nullable();
            $table->boolean('last_store_invalid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registries');
    }
}
