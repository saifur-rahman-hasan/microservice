<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceEndpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_endpoints', function (Blueprint $table) {
            $table->id();
            $table->string('service_code', 16);
            $table->string('code', 16)->unique();
            $table->enum('method', ['get', 'post', 'put', 'patch', 'delete']);
            $table->string('endpoint');
            $table->text('description')->nullable();
            $table->text('middleware')->nullable();
            $table->boolean('enabled')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('service_code')
                ->references('code')
                ->on('services')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_endpoints');
    }
}
