<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_relations', function (Blueprint $table) {
            $table->bigInteger('vendor_id');
            $table->bigInteger('shop_id');
            $table->primary(['vendor_id', 'shop_id']);
            $table->boolean('has_access')->default(1);
            $table->boolean('can_message')->default(1);
            $table->boolean('can_see_prices')->default(1);
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
        Schema::dropIfExists('users_relations');
    }
}
