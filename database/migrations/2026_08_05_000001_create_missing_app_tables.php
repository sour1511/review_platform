<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'lname')) {
                $table->string('lname')->nullable();
            }
            if (!Schema::hasColumn('users', 'nickname')) {
                $table->string('nickname')->nullable();
            }
            if (!Schema::hasColumn('users', 'dob')) {
                $table->string('dob')->nullable();
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender')->nullable();
            }
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->integer('role_id')->default(2);
            }
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable();
            }
            if (!Schema::hasColumn('users', 'user_pic')) {
                $table->string('user_pic')->nullable();
            }
            if (!Schema::hasColumn('users', 'is_delete')) {
                $table->smallInteger('is_delete')->default(0);
            }
            if (!Schema::hasColumn('users', 'terms')) {
                $table->smallInteger('terms')->default(0);
            }
            if (!Schema::hasColumn('users', 'country_name')) {
                $table->string('country_name')->nullable();
            }
            if (!Schema::hasColumn('users', 'avatar_pic')) {
                $table->string('avatar_pic')->nullable();
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'es_category_title')) {
                $table->string('es_category_title')->nullable();
            }
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('sub_categories', 'es_sub_category_title')) {
                $table->string('es_sub_category_title')->nullable();
            }
        });

        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'profile_id')) {
                $table->bigInteger('profile_id')->nullable();
            }
            if (!Schema::hasColumn('reviews', 'post_time')) {
                $table->string('post_time')->nullable();
            }
            if (!Schema::hasColumn('reviews', 'type')) {
                $table->string('type')->nullable();
            }
            if (!Schema::hasColumn('reviews', 'from_date')) {
                $table->string('from_date')->nullable();
            }
            if (!Schema::hasColumn('reviews', 'to_date')) {
                $table->string('to_date')->nullable();
            }
            if (!Schema::hasColumn('reviews', 'doc_name')) {
                $table->string('doc_name')->nullable();
            }
            if (!Schema::hasColumn('reviews', 'nickname')) {
                $table->string('nickname')->nullable();
            }
            if (!Schema::hasColumn('reviews', 'updated_img')) {
                $table->string('updated_img')->nullable();
            }
            if (!Schema::hasColumn('reviews', 'show_realname')) {
                $table->smallInteger('show_realname')->default(0);
            }
        });

        if (!Schema::hasTable('profiles')) {
            Schema::create('profiles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('profile_name')->nullable();
                $table->string('profile_pic')->nullable();
                $table->string('cover_pic')->nullable();
                $table->bigInteger('category_id')->nullable();
                $table->bigInteger('sub_category_id')->nullable();
                $table->string('subject_name')->nullable();
                $table->string('location')->nullable();
                $table->string('address_latitude')->nullable();
                $table->string('address_longitude')->nullable();
                $table->bigInteger('user_id')->nullable();
                $table->string('user_email')->nullable();
                $table->string('mobile_number')->nullable();
                $table->string('country')->nullable();
                $table->smallInteger('is_delete')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('custom_ads')) {
            Schema::create('custom_ads', function (Blueprint $table) {
                $table->increments('id');
                $table->string('heading')->nullable();
                $table->string('sub_heading')->nullable();
                $table->string('banner_img')->nullable();
                $table->string('sp_heading')->nullable();
                $table->string('sp_sub_heading')->nullable();
                $table->string('sp_banner_img')->nullable();
                $table->smallInteger('is_delete')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('ad_settings')) {
            Schema::create('ad_settings', function (Blueprint $table) {
                $table->increments('id');
                $table->smallInteger('is_hide')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('custom_gender')) {
            Schema::create('custom_gender', function (Blueprint $table) {
                $table->increments('id');
                $table->string('gender_title')->nullable();
                $table->string('es_gender_title')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('password_request')) {
            Schema::create('password_request', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->nullable();
                $table->string('email_id')->nullable();
                $table->smallInteger('is_expired')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('password_request');
        Schema::dropIfExists('custom_gender');
        Schema::dropIfExists('ad_settings');
        Schema::dropIfExists('custom_ads');
        Schema::dropIfExists('profiles');
    }
};
