<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = \App\Model\Role::where('name', 'Admin')->first();
        $data = [
            [
                'name' => 'Admin',
                'password' => '$2y$12$huAVN4bz120uA2./fELj/eXh6RFa9HPaxPHhlbRGUE4Xmx5fHElby',
                'email' => 'admin@gmail.com',
                'id_role' => $role->id
            ]
        ];
        foreach ($data as $item) {
            DB::table('users')->insert($item);
        }
    }
}
