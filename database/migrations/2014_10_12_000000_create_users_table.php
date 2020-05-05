<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->float('balance')->default(0);
            $table->enum('status', [0, 1])->default(1);
            $table->timestamp('suspend_time')->defult(null);
            $table->string('password');
            $table->string('bio')->nullable();
            $table->string('image', 2048)->nullable();
            $table->enum('charge_alarm', [0, 1])->default(0);
            $table->integer('comment_count')->default(0);
            $table->rememberToken();
            $table->timestamps();

            $table->unique(['username', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
