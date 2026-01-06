<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void {
        Schema::table('products', function (Blueprint $table) {
        if (!Schema::hasColumn('products', 'product_image')) {
                $table->string('product_image')->nullable()->after('price');
            }
        });

    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'product_image')) {
                $table->dropColumn('product_image');
            }
        });
    }
};
