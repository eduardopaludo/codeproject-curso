<?php

use Illuminate\Database\Seeder;

class OAuthClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'id' => 'app01',
            'secret' => 'secret',
            'name' => 'AngularAPP',
        ]);
    }
}
