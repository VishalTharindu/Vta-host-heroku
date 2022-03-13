<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission Types
         *
         */
        $Permissionitems = [
            [
                'name'        => 'Batch Permission',
                'slug'        => 'modify.batch',
                'description' => 'Add,Edit,Delete Batch',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Course Permission',
                'slug'        => 'modify.course',
                'description' => 'Add,Edit,Delete Course',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Applicant Permission',
                'slug'        => 'modify.applicant',
                'description' => 'Add,Edit Applicant',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Applicant Delete',
                'slug'        => 'applicant.delete',
                'description' => 'Delete Applicants',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Applicant Filter Data',
                'slug'        => 'applicant.filter.data',
                'description' => 'Filter Applicant Data',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Applicant Interview',
                'slug'        => 'applicant.interview',
                'description' => 'Applicant Interview',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Demonstrator Permission',
                'slug'        => 'modify.demonstrator',
                'description' => 'Add,Edit,Delete Demonstrator',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Instructor Permission',
                'slug'        => 'modify.instructor',
                'description' => 'Add,Edit,Delete Instructor',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Adminstrative Staff Permission',
                'slug'        => 'modify.admin.staff',
                'description' => 'Add,Edit,Delete Adminstrative Staff',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Trainee Permission',
                'slug'        => 'modify.trainee',
                'description' => 'Add,Edit,Delete Trainee',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Attendance Permission',
                'slug'        => 'modify.attendance',
                'description' => 'Mark,View Attendance',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Give Attendance Permission',
                'slug'        => 'give.attendance.permission',
                'description' => 'Give Attendance Permission',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Fund Permission',
                'slug'        => 'modify.fund',
                'description' => 'Add,Edit,Delete Fund',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Calendar Permission',
                'slug'        => 'modify.calendar',
                'description' => 'Add,Edit,Delete Calendar',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Examination Permission',
                'slug'        => 'modify.examination',
                'description' => 'Examination Task',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Pre Assesment Permission',
                'slug'        => 'modify.preassesment',
                'description' => 'Pre Assesment Task',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Subject Permission',
                'slug'        => 'modify.subject',
                'description' => 'Add,Edit,Delete Subject',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Course Duration Permission',
                'slug'        => 'modify.courseduration',
                'description' => 'Add,Edit,Delete Course Duration',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Training Institute Permission',
                'slug'        => 'modify.traininginstitute',
                'description' => 'Add,Edit,Delete Training Institute',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Implant Training Permission',
                'slug'        => 'modify.implanttraining',
                'description' => 'Implant Training Task',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Dropout Permission',
                'slug'        => 'modify.dropouts',
                'description' => 'Dropout Task',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Suspended Permission',
                'slug'        => 'modify.suspended',
                'description' => 'Suspended Task',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Certificate Permission',
                'slug'        => 'modify.certificate',
                'description' => 'Add,Edit,Delete Certificate',
                'model'       => 'Permission',
            ],
        ];

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $Permissionitem) {
            $newPermissionitem = config('roles.models.permission')::where('slug', '=', $Permissionitem['slug'])->first();
            if ($newPermissionitem === null) {
                $newPermissionitem = config('roles.models.permission')::create([
                    'name'          => $Permissionitem['name'],
                    'slug'          => $Permissionitem['slug'],
                    'description'   => $Permissionitem['description'],
                    'model'         => $Permissionitem['model'],
                ]);
            }
        }
    }
}