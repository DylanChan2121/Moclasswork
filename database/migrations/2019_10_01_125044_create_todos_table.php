<?php
# @Date:   2019-10-01T13:50:44+01:00
# @Last modified time: 2019-10-01T16:03:26+01:00




use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {//creating updating columns
            $table->bigIncrements('id');//data
            $table->string('title')->unique();
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()//for reversing columns
    {
        Schema::dropIfExists('todos');
    }
}
