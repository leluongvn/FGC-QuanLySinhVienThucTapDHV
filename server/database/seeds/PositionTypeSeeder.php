<?php

use Illuminate\Database\Seeder;

class PositionTypeSeeder extends Seeder
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
                'name'=>'TBM'
            ],
            [
                'name'=>'TLĐT'
            ],
            [
                'name'=>'GVHD'
            ]
        ];
        foreach($data as $item){
            DB::table('position_type')->insert($item);
        }
    }
}
