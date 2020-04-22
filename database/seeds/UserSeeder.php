<?php
use App\Models\DvlaApplication;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    public function run() {
		factory(User::class, 1)
		->create()
		->each(function ($usr) {
		    $usr->dvlaApplications()->createMany(factory(DvlaApplication::class, 1)->make()->toArray());
		});
	}
}
