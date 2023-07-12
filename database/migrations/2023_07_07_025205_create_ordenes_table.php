<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->enum('estado', ['pendiente', 'pagado','cancelado'])->default('pendiente');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->float('subtotal', 8, 2);
            $table->float('descuento', 8, 2)->nullable();
            $table->float('total', 8, 2);
            $table->string('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordenes');
    }
}
