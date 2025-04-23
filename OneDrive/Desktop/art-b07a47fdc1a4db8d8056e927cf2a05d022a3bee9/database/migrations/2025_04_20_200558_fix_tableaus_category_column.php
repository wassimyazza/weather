// database/migrations/xxxx_xx_xx_fix_tableaus_category_column.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tableaus', function (Blueprint $table) {
            // Remove the old category column if it exists
            if (Schema::hasColumn('tableaus', 'category')) {
                $table->dropColumn('category');
            }
            
            // Add the category_id column if it doesn't exist
            if (!Schema::hasColumn('tableaus', 'category_id')) {
                $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tableaus', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->string('category')->nullable();
        });
    }
};