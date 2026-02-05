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
        Schema::table('stores', function (Blueprint $table) {
            $table->string('code',6)->unique();
            $table->string('postal_code',7);
            $table->string('prefecture')->index();
            $table->string('city');
            $table->string('address_line');
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropIndex('stores_prefecture_index');
            $table->dropUnique('stores_code_unique');

            $table->dropColumn([
                'code',
                'postal_code',
                'prefecture',
                'city',
                'address_line',
                'is_active'
                ]);
        });
    }
};
