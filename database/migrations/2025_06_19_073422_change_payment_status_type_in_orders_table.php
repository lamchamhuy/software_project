<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangePaymentStatusTypeInOrdersTable extends Migration
{
    public function up()
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_status')->change(); // đổi sang chuỗi
        });
    }

    public function down()
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->integer('payment_status')->change(); // nếu muốn rollback
        });
    }
}
