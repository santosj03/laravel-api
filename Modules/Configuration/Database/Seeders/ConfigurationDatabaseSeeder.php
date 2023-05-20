<?php

namespace Modules\Configuration\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Configuration\Database\Seeders\ContentMappingSeederTableSeeder;

class ConfigurationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(ContentMappingSeederTableSeeder::class);
    }
}
