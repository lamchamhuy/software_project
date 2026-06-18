<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('customer', 'admin', 'shipper') NOT NULL DEFAULT 'customer'");

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'shipper_id')) {
                $table->unsignedBigInteger('shipper_id')->nullable()->after('user_id');
                $table->foreign('shipper_id')->references('id')->on('users')->nullOnDelete();
                $table->index('shipper_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'shipper_id')) {
                $table->dropForeign(['shipper_id']);
                $table->dropIndex(['shipper_id']);
                $table->dropColumn('shipper_id');
            }
        });

        DB::table('users')->where('role', 'shipper')->update(['role' => 'customer']);

        DB::statement("ALTER TABLE users MODIFY role ENUM('customer', 'admin') NOT NULL DEFAULT 'customer'");
    }
};
