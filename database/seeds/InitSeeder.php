<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'username' => 'admin',
            'password' => App\Admin::salt('admin', 'admin'),
            ]);
        DB::table('categories')->insert([
            'id' => 1,
            'text' => '轮转图',
            ]);
        DB::table('categories')->insert([
            'id' => 2,
            'text' => '学院新闻',
            ]);
        DB::table('settings')->insert([
            'key' => 'version_name',
            'value' => '0.0.0',
            ]);
        DB::table('settings')->insert([
            'key' => 'version_code',
            'value' => '0',
            ]);
    }
}
