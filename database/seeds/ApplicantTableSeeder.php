<?php

use App\Batch;
use App\Course;
use App\Applicant;
use App\Trainee;
use Illuminate\Database\Seeder;

class ApplicantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $batch1 = Batch::create([
            'year' => '2018',
            'batch_no' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $batch2 = Batch::create([
            'year' => '2018',
            'batch_no' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $batch3 = Batch::create([
            'year' => '2019',
            'batch_no' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $batch4 = Batch::create([
            'year' => '2019',
            'batch_no' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $course1 = Course::create([
            'course_name' => 'Mechanics',
            'course_duration' => '18',
            'nvq_level' => '4',
            'registration_fee' => '500',
            'course_fee' => '120000',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $course2 = Course::create([
            'course_name' => 'Room Service',
            'course_duration' => '6',
            'nvq_level' => '3',
            'registration_fee' => '500',
            'course_fee' => '5000',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $course3 = Course::create([
            'course_name' => 'Cookery',
            'course_duration' => '6',
            'nvq_level' => '4',
            'registration_fee' => '500',
            'course_fee' => '100000',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $course4 = Course::create([
            'course_name' => 'Constructor',
            'course_duration' => '12',
            'nvq_level' => '6',
            'registration_fee' => '500',
            'course_fee' => '200000',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $applicant1 = Applicant::create([
            'batch_id' => $batch4->id,
            'full_name' => 'Tharuka Sandaru',
            'name_with_initials' => 'T.J Sandaru',
            'gender' => 'male',
            'ethnicity' => 'sinhala',
            'nic' => '987452108v',
            'email' => 'tharu@vta.lk',
            'phone_number' => '0715190849',
            'address' => 'No10, Samanpura road, Oluganthota',
            'city' => 'Balangoda',
            'qualification' => 'A/L',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('applicant_course')->insert([
            'applicant_id' => $applicant1->id,
            'course_id' => $course1->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('applicant_course')->insert([
            'applicant_id' => $applicant1->id,
            'course_id' => $course2->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $applicant2 = Applicant::create([
            'batch_id' => $batch4->id,
            'full_name' => 'Opshanka Prabath',
            'name_with_initials' => 'T.N Prabath',
            'gender' => 'male',
            'ethnicity' => 'tamil',
            'nic' => '954878208v',
            'email' => 'op@vta.lk',
            'phone_number' => '0715542301',
            'address' => 'No40/2, Malsiripura,Kurunegala',
            'city' => 'Kurunegala',
            'qualification' => 'O/L',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('applicant_course')->insert([
            'applicant_id' => $applicant2->id,
            'course_id' => $course2->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('applicant_course')->insert([
            'applicant_id' => $applicant2->id,
            'course_id' => $course4->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $applicant3 = Applicant::create([
            'batch_id' => $batch4->id,
            'full_name' => 'Chandika Peiris',
            'name_with_initials' => 'S.N.C Peieris',
            'gender' => 'male',
            'ethnicity' => 'sinhala',
            'nic' => '948521908v',
            'email' => 'chandi@vta.lk',
            'phone_number' => '0778541236',
            'address' => 'No.34, Walana,Panadura',
            'city' => 'Panadura',
            'qualification' => 'O/L',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('applicant_course')->insert([
            'applicant_id' => $applicant3->id,
            'course_id' => $course1->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('applicant_course')->insert([
            'applicant_id' => $applicant3->id,
            'course_id' => $course3->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $applicant4 = Applicant::create([
            'batch_id' => $batch3->id,
            'full_name' => 'Sanadaru Imal',
            'name_with_initials' => 'S.I Rathnayake',
            'gender' => 'male',
            'ethnicity' => 'sinhala',
            'nic' => '948562308v',
            'email' => 'sandaru@vta.lk',
            'phone_number' => '0754512336',
            'address' => 'No20, Haliela,Badulla',
            'city' => 'Badulla',
            'qualification' => 'O/L',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('applicant_course')->insert([
            'applicant_id' => $applicant4->id,
            'course_id' => $course2->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('applicant_course')->insert([
            'applicant_id' => $applicant4->id,
            'course_id' => $course4->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $trainee1 = Trainee::create([
            'enrollment_no' => 'abc123',
            'course_id' => $course2->id,
            'batch_id' => $batch1->id,
            'full_name' => 'Jaith Chamara Yasantha Fonseka',
            'name_with_initials' => 'J.C Yasantha Fonseka',
            'gender' => 'male',
            'ethnicity' => 'sinhala',
            'nic' => '972471790v',
            'phone_number' => '0745223654',
            'address' => 'No40/2, Malsiripura,Kurunegala',
            'city' => 'Kurunegala',
            'email' => 'yasantha@vta.lk',
            'qualification' => 'O/L',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $trainee2 = Trainee::create([
            'enrollment_no' => 'abc456',
            'course_id' => $course1->id,
            'batch_id' => $batch1->id,
            'full_name' => 'Tharindu Vishal',
            'name_with_initials' => 'S.N Tharindu Vishal',
            'gender' => 'male',
            'ethnicity' => 'sinhala',
            'nic' => '972471790v',
            'phone_number' => '0745223654',
            'address' => 'No40/2, Malsiripura,Kurunegala',
            'city' => 'Kurunegala',
            'email' => 'vishal@vta.lk',
            'qualification' => 'O/L',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $trainee3 = Trainee::create([
            'enrollment_no' => 'abc789',
            'course_id' => $course1->id,
            'batch_id' => $batch3->id,
            'full_name' => 'Ushan Vishal',
            'name_with_initials' => 'K.M Ushan',
            'gender' => 'male',
            'ethnicity' => 'sinhala',
            'nic' => '972471790v',
            'phone_number' => '0745223654',
            'address' => 'No40/2, Malsiripura,Kurunegala',
            'city' => 'Kurunegala',
            'email' => 'ushan@vta.lk',
            'qualification' => 'O/L',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
