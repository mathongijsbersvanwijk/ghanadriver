<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder {

	public function run() {
	    DB::table('roles')->    insert([
	        [
	            'id'            => 1,
	            'name'          => 'ADMIN',
	        ],
	        [
	            'id'            => 2,
	            'name'          => 'MEMBER'
	        ]
	    ]);
	}
}
