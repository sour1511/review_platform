<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('password_request') && !Schema::hasColumn('password_request', 'token')) {
            Schema::table('password_request', function (Blueprint $table) {
                $table->string('token', 64)->nullable()->unique()->after('email_id');
                $table->timestamp('expires_at')->nullable()->after('is_expired');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('password_request') && Schema::hasColumn('password_request', 'token')) {
            Schema::table('password_request', function (Blueprint $table) {
                $table->dropColumn(['token', 'expires_at']);
            });
        }
    }
};
