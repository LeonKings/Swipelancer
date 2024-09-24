<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employers_id');
            $table->foreign('employers_id')->references('id')->on('employers')->onDelete('cascade')->onUpdate('cascade');
            $table->string('status', 255)->nullable(false);
            $table->string('address', 255)->nullable(false);
            $table->string('project_name', 255)->nullable(false);
            $table->string('project_description', 255)->nullable(false);
            $table->string('project_type', 255)->nullable(false);
            $table->integer('salary')->nullable(false);
            $table->string('project_field', 255)->nullable(false);
            $table->string('project_section', 255)->nullable(false);
            $table->string('project_deadline', 255)->nullable(false);
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
        Schema::dropIfExists('jobs');
    }
}
