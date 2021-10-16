<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('root_id')->nullable()->default(null);
            $table->bigInteger('parent_id')->nullable()->default(null);
            $table->bigInteger('menuable_id')->nullable()->default(null);
            $table->string('menuable_type')->nullable()->default(null);
            $table->string('name', 75);
            $table->string('url', 2048)->nullable()->default(null);
            // $table->string('icon')->nullable();
            $table->unsignedTinyInteger('order')->nullable()->default(null);
            $table->boolean('redirect')->default(false);
            $table->boolean('active_top')->default(0);
            $table->boolean('active_footer')->default(0);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
