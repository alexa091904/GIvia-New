<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Check if column exists before adding
            if (!Schema::hasColumn('orders', 'total')) {
                $table->decimal('total', 10, 2)->after('id')->default(0);
            }
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->after('total')->default(0);
            }
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('pending')->after('subtotal');
            }
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->unique()->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'shipping_address')) {
                $table->text('shipping_address')->nullable()->after('status');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('status');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['total', 'subtotal', 'status', 'order_number', 'shipping_address', 'payment_status']);
        });
    }
}