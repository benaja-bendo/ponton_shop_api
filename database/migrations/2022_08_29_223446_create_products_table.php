<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('small_description');
            $table->longText('long_description')->nullable();
            $table->float('price')->nullable();
            $table->boolean('disponible')->default(true);// pour admin possibilité de bloquer le produit
            $table->enum('status', ['stock', 'rupture', 'recommande'])->nullable(); // pour vendeur définir le status de son produit
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
        Schema::dropIfExists('products');
    }
};
