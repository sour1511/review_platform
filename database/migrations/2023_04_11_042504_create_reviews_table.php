<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('category_id');
            $table->bigInteger('sub_category_id')->nullable();
            $table->smallInteger('is_sub_category')->default('0');
            $table->smallInteger('self_consent')->default('0');
            $table->date('post_date');
            $table->text('review_description');
            $table->string('star_ratings')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('user_name');
            $table->string('user_email')->nullable();
            $table->string('user_mobile')->nullable();
            $table->text('user_address')->nullable();
            $table->string('user_state')->nullable();
            $table->string('user_country');
            $table->smallInteger('is_delete')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
