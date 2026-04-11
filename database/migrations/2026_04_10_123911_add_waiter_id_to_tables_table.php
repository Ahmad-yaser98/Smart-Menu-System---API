<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->foreignId('waiter_id')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropForeign(['waiter_id']);
            $table->dropColumn('waiter_id');
        });
    }
};