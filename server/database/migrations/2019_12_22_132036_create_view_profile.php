<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateViewProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW  view_instructor
            AS 
            SELECT sr.id, u.id as teacher_id, sr.id_internship_time, u.name as teacher_name
            FROM student_reg sr
            join instructor i on sr.id = i.id_student_reg
            join teachers t on i.id_teacher = t.id 
            join users u on u.id = t.id_user");
        DB::statement(" 
            CREATE OR REPLACE VIEW view_company
            AS
            SELECT cr.id_student_reg as id, u.id as company_id, u.name as company_name
            FROM users u
            JOIN companies c ON u.id = c.id_user
            JOIN internship_company ic ON c.id = ic.id_company
            JOIN company_reg cr ON ic.id = cr.id_internship_company");
        DB::statement("
            CREATE OR REPLACE VIEW view_profile
            AS
            SELECT i.id, i.id_internship_time, i.teacher_id, i.teacher_name, c.company_id, c.company_name
            FROM view_instructor i 
            LEFT JOIN view_company c ON  i.id = c.id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS view_profile');
        DB::statement('DROP VIEW IF EXISTS view_instructor');
        DB::statement('DROP VIEW IF EXISTS view_company');
    }
}
