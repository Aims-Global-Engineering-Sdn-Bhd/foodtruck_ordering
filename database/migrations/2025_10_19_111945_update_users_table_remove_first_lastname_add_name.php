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
        if (Schema::hasColumn('users', 'firstname')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('firstname');
            });
        }

        if (Schema::hasColumn('users', 'lastname')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('lastname');
            });
        }

        // Add new column if it does not exist
        if (!Schema::hasColumn('users', 'name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('name')->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverse the changes if you rollback
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }

            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
        });
    }
};


/*Schema::table('users', function (Blueprint $table) {
            // Remove old columns if they exist
            if (Schema::hasColumn('users', 'firstname')) {
                $table->dropColumn('firstname');
            }
            if (Schema::hasColumn('users', 'lastname')) {
                $table->dropColumn('lastname');
            }

            // Add new name column if not already exist
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->after('id');
            }
        });*/
