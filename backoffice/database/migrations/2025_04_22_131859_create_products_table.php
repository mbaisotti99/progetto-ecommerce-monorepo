<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("nome");
            $table->longText("descrizione");
            $table->enum("categoria", ["tshirt", "felpa", "pantalone", "giacca", "maglione"]);
            $table->json("taglie");
            $table->string("img");
            $table->bigInteger("prezzo");
            $table->boolean("scontato")->default(0);
            $table->integer("sconto")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
