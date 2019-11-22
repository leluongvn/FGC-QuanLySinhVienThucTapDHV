<?php

use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'=>'Hệ thống thông tin'
            ],
            [
                'name'=>'Khoa học máy tính'
            ],
            [
                'name'=>'Mạng máy tính'
            ]
        ];
        foreach($data as $item){
            DB::table('subjects')->insert($item);
        }
    }
}
