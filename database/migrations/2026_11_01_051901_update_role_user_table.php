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
        Schema::table('role_user', function (Blueprint $table) {
            // Adds the foreign keys if they aren't already there
            // foreignId(...) automatically links to 'id' on 'users' and 'roles' tables
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');

            // Optional: makes the combination of user_id and role_id unique
            $table->primary(['user_id', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::table('role_user', function (Blueprint $table) {
            // Drops constraints and columns if rolled back
            $table->dropForeign(['user_id']);
            $table->dropForeign(['role_id']);
            $table->dropColumn(['user_id', 'role_id']);
        });
    }
};
