<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(InternshipTypeSeeder::class);
        $this->call(PositionTypeSeeder::class);
        $this->call(SubjectSeeder::class);
    }
}
