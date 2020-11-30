<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusMemberThreads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thread_members', function (Blueprint $table) {
            $table->string('role')->after('user_id')->default(2)->comment('1: admin; 2: member');
            $table->string('status')->after('role')->default(2)->comment('1: approved; 2: disapproved');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thread_members', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('status');
        });
    }
}
