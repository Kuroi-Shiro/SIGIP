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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
 
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
 
            $table->string('codigo', 50)->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->decimal('precio', 10, 2)->unsigned();
            $table->unsignedInteger('stock_actual')->default(0);
            $table->unsignedInteger('stock_minimo')->default(0);
            $table->boolean('activo')->default(true); 
            $table->timestamps();
 
            $table->index('nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
