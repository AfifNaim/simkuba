<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQtyAndSummaryToCashBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_books', function (Blueprint $table) {
            $table->integer('qty')->default(1);
            $table->bigInteger('summary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_cash_books', function (Blueprint $table) {
            $table->dropColumn('qty');
            $table->dropColumn('summary');
        });
    }
}
