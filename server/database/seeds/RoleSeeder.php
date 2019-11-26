<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
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
                'name'=>'Admin'
            ],
            [
                'name'=>'Trợ lý đào tạo'
            ],
            [
                'name'=>'Trưởng bộ môn'
            ],
            [
                'name'=>'Giảng viên'
            ],
            [
                'name'=>'Doanh nghiệp' 
            ],
            [
                'name'=>'Sinh viên'
            ]
        ];
        foreach($data as $item){
            DB::table('roles')->insert($item);
        }
    }
}
