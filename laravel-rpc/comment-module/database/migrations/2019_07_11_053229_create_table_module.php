<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'modules',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('module_name')->comment('模块名');
                $table->tinyInteger('state')->default(1)->comment('是否上线');
                $table->string('asset_file')->default('')->comment('静态文件地址');
                $table->string('desc')->default('')->comment('描述');
                $table->timestamps();
            }
        );
        Schema::create(
            'members',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
        Schema::dropIfExists('members');
    }
}
