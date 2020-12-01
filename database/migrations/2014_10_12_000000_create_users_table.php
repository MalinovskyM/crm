<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('phone')->nullable();
            $table->string('position')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('email_verified')->default(0);
            $table->string('email_verification_token')->default(0);
            $table->string('password');
            $table->integer('company_id');
            $table->smallInteger('status')->default(1);
            $table->integer('role_id');
            $table->string('img')->nullable();
            $table->integer('telegram_chat_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Vlad',
            'email' => 'vlad.simoroz@gmail.com',
            'password' => bcrypt('bwGJk1G4'),
            'company_id' => '1',
            'role_id'=>1,
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);

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
