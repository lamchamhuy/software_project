<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('cod', 'bank_transfer', 'qr_payment', 'momo', 'vnpay', 'stripe', 'paypal')");
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('cod', 'bank_transfer', 'momo', 'vnpay', 'stripe', 'paypal')");
    }
};
