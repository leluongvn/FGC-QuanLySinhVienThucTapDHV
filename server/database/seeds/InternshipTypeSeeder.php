<?php

use Illuminate\Database\Seeder;

class InternshipTypeSeeder extends Seeder
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
                'name'=>'Thực tập cơ sở'
            ],
            [
                'name'=>'Thực tập chuyên nghành'
            ],
            [
                'name'=>'Thực tập tốt nghiệp'
            ]
        ];
        foreach($data as $item){
            DB::table('internship_type')->insert($item);
        }
    }
}
