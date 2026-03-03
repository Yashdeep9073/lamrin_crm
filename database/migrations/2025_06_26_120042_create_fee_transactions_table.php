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
        Schema::create('fee_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assigned_fee_id');
            $table->integer('category_id')->unsigned();
            $table->unsignedBigInteger('student_enroll_id');
            $table->decimal('paid_amount', 10, 2);
            $table->decimal('fine_amount', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->date('payment_date');
            $table->integer('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default('0')->comment('0 Unpaid, 1 Paid, 2 Cancel');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('assigned_fee_id')->references('id')->on('assigned_fees')->onDelete('cascade');
            $table->foreign('student_enroll_id')->references('id')->on('student_enrolls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_transactions');
    }
};
