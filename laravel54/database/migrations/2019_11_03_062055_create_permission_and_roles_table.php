<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionAndRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        角色表roles
        Schema::create('admin_roles',function (Blueprint $blueprint){
            $blueprint->increments('id');
            $blueprint->string('name',30)->default('');
            $blueprint->string('description',100)->default('');
            $blueprint->timestamps();
        });

        //        权限表
        Schema::create('admin_permissions',function (Blueprint $blueprint){
            $blueprint->increments('id');
            $blueprint->string('name',30)->default('');
            $blueprint->string('description',100)->default('');
            $blueprint->timestamps();
        });

        //权限角色关联表
        Schema::create('admin_permission_role',function (Blueprint $blueprint){
            $blueprint->increments('id');
            $blueprint->integer('role_id')->default(0);
            $blueprint->integer('permission_id')->default(0);
        });

        //用户角色关联表
        Schema::create('admin_role_user',function (Blueprint $blueprint){
            $blueprint->increments('id');
            $blueprint->integer('role_id')->default(0);
            $blueprint->integer('user_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_roles');
        Schema::drop('admin_permissions');
        Schema::drop('admin_permission_role');
        Schema::drop('admin_role_user');
    }
}
