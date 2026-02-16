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
        Schema::table('users', function (Blueprint $table) {

            // 1️⃣ Add company_id
            $table->foreignId('company_id')
                  ->after('id')
                  ->constrained()
                  ->cascadeOnDelete();

            // 2️⃣ Drop global email unique index
            $table->dropUnique(['email']);

            // 3️⃣ Add tenant-based unique constraint
            $table->unique(['company_id', 'email']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropUnique(['company_id', 'email']);

            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');

            $table->unique('email');
        });

    }
};
