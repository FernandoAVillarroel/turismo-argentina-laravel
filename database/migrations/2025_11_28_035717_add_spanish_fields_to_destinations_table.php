<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destination', function (Blueprint $table) {  // ← SINGULAR
            // Agregar columnas en español
            $table->string('nombre')->nullable()->after('name');
            $table->text('descripcion')->nullable()->after('description');
            $table->string('ubicacion')->nullable()->after('city');
            $table->string('imagen_url')->nullable()->after('featured_image');
            $table->unsignedBigInteger('categoria_id')->nullable()->after('is_active');
            
            // Foreign key para categorías
            $table->foreign('categoria_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('destination', function (Blueprint $table) {  // ← SINGULAR
            $table->dropForeign(['categoria_id']);
            $table->dropColumn(['nombre', 'descripcion', 'ubicacion', 'imagen_url', 'categoria_id']);
        });
    }
};