<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreelancersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freelancers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('freelancer_image_link', 255)->nullable(false);
            $table->string('freelancer_name', 255)->nullable(false);
            $table->string('last_study', 255)->nullable(false);
            $table->integer('field_of_work')->nullable(false);
            $table->string('cv_link', 255)->nullable(false);
            $table->string('portfolio', 255)->nullable(false);
            $table->integer('min_salary')->nullable(false);;
            $table->integer('max_salary')->nullable(false);;
            $table->integer('section_1')->nullable(false);
            $table->integer('section_2')->nullable(false);;
            $table->integer('section_3')->nullable(false);;
            $table->string('describe_yourselves', 255)->nullable(false);
            $table->integer('created_community')->nullable(false);;
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
        Schema::dropIfExists('freelancers');
    }
}
