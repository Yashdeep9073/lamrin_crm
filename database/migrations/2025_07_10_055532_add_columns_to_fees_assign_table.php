<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fees_assign', function (Blueprint $table) {
            //
            $table->double('fees_total_amount', 10, 2)->after('category_id'); // optionally use ->nullable() or ->default(0)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fees_assign', function (Blueprint $table) {
            $table->dropColumn('fees_total_amount');
        });
    }
};
