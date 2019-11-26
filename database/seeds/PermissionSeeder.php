<?php

use App\Models\Project;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow('user')->toOwn(Project::class);
        Bouncer::ownedVia('owner_id');
        Bouncer::allow('user')->to('create project');
    }
}
