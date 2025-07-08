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
            Schema::table('orders', function (Blueprint $table) {
                $table->string('email')->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('phone')->nullable();
            });
        }

        public function down(): void
        {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn([
                    'email',
                    'first_name',
                    'last_name',
                    'address',
                    'city',
                    'postal_code',
                    'phone'
                ]);
            });
        }
};
