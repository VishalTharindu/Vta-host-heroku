<?php

use Illuminate\Database\Seeder;

class ConnectRelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Get Available Permissions.
         */
        $permissions = config('roles.models.permission')::all();

        /**
         * Attach Permissions to Roles.
         */
        $roleAdmin = config('roles.models.role')::where('name', '=', 'Admin')->first();
        foreach ($permissions as $permission) {
            $roleAdmin->attachPermission($permission);
        }

        
        $permissionsBySlug = $permissions->keyBy('slug');

        //User Roles
        $roleOIC = config('roles.models.role')::where('name', '=', 'OIC')->first();
        $roleMA = config('roles.models.role')::where('name', '=', 'MA')->first();
        $roleMR = config('roles.models.role')::where('name', '=', 'MR')->first();
        $roleInstructor = config('roles.models.role')::where('name', '=', 'Instructor')->first();
        $roleDemonstrator = config('roles.models.role')::where('name', '=', 'Demonstrator')->first();
        
        //Functions related to Batch Management
        $roleOIC->attachPermission($permissionsBySlug['modify.batch']);
        $roleMA->attachPermission($permissionsBySlug['modify.batch']);
        $roleMR->attachPermission($permissionsBySlug['modify.batch']);

        //Functions related to Course Management
        $roleOIC->attachPermission($permissionsBySlug['modify.course']);
        $roleMA->attachPermission($permissionsBySlug['modify.course']);
        $roleMR->attachPermission($permissionsBySlug['modify.course']);

        //Applicants Add,Edit and Delete
        $roleOIC->attachPermission($permissionsBySlug['modify.applicant']);
        $roleMA->attachPermission($permissionsBySlug['modify.applicant']);
        $roleMR->attachPermission($permissionsBySlug['modify.applicant']);
        $roleOIC->attachPermission($permissionsBySlug['applicant.delete']);
        $roleMA->attachPermission($permissionsBySlug['applicant.delete']);
        $roleMR->attachPermission($permissionsBySlug['applicant.delete']);

        //Filter Applicants data
        $roleOIC->attachPermission($permissionsBySlug['applicant.filter.data']);
        $roleMA->attachPermission($permissionsBySlug['applicant.filter.data']);
        $roleMR->attachPermission($permissionsBySlug['applicant.filter.data']);
        $roleInstructor->attachPermission($permissionsBySlug['applicant.filter.data']);
        $roleDemonstrator->attachPermission($permissionsBySlug['applicant.filter.data']);

        //Filter Related to Interview Process
        $roleOIC->attachPermission($permissionsBySlug['applicant.interview']);
        $roleMA->attachPermission($permissionsBySlug['applicant.interview']);
        $roleMR->attachPermission($permissionsBySlug['applicant.interview']);

        //Adding, Editing And Deleting Demonstrators 
        $roleOIC->attachPermission($permissionsBySlug['modify.demonstrator']);
        $roleMA->attachPermission($permissionsBySlug['modify.demonstrator']);
        $roleMR->attachPermission($permissionsBySlug['modify.demonstrator']);
        $roleInstructor->attachPermission($permissionsBySlug['modify.demonstrator']);

        //Adding, Editing And Deleting Instructors 
        $roleOIC->attachPermission($permissionsBySlug['modify.instructor']);
        $roleMA->attachPermission($permissionsBySlug['modify.instructor']);
        $roleMR->attachPermission($permissionsBySlug['modify.instructor']);

        //Modifying Administrative Staff
        $roleOIC->attachPermission($permissionsBySlug['modify.admin.staff']);
        $roleMA->attachPermission($permissionsBySlug['modify.admin.staff']);
        $roleMR->attachPermission($permissionsBySlug['modify.admin.staff']);

        //Modifying Trainee Details
        $roleOIC->attachPermission($permissionsBySlug['modify.trainee']);
        $roleMA->attachPermission($permissionsBySlug['modify.trainee']);
        $roleMR->attachPermission($permissionsBySlug['modify.trainee']);

        //Attendence mark and view
        $roleMA->attachPermission($permissionsBySlug['modify.attendance']);
        $roleInstructor->attachPermission($permissionsBySlug['modify.attendance']);
        $roleDemonstrator->attachPermission($permissionsBySlug['modify.attendance']);

        //Give Attendence Permission
        $roleOIC->attachPermission($permissionsBySlug['give.attendance.permission']);
        $roleMR->attachPermission($permissionsBySlug['give.attendance.permission']);

        //Fund Permission
        $roleOIC->attachPermission($permissionsBySlug['modify.fund']);
        $roleMR->attachPermission($permissionsBySlug['modify.fund']);

        //Calender Permission
        $roleOIC->attachPermission($permissionsBySlug['modify.calendar']);
        $roleMR->attachPermission($permissionsBySlug['modify.calendar']);

        //Examination Process 
        $roleOIC->attachPermission($permissionsBySlug['modify.examination']);
        $roleMA->attachPermission($permissionsBySlug['modify.examination']);
        $roleMR->attachPermission($permissionsBySlug['modify.examination']);
        $roleInstructor->attachPermission($permissionsBySlug['modify.examination']);
        $roleDemonstrator->attachPermission($permissionsBySlug['modify.examination']);

        //Pre Assesment Permission
        $roleOIC->attachPermission($permissionsBySlug['modify.preassesment']);
        $roleMA->attachPermission($permissionsBySlug['modify.preassesment']);
        $roleMR->attachPermission($permissionsBySlug['modify.preassesment']);
        $roleInstructor->attachPermission($permissionsBySlug['modify.preassesment']);
        $roleDemonstrator->attachPermission($permissionsBySlug['modify.preassesment']);


        //Subject Permission
        $roleOIC->attachPermission($permissionsBySlug['modify.subject']);
        $roleMA->attachPermission($permissionsBySlug['modify.subject']);
        $roleMR->attachPermission($permissionsBySlug['modify.subject']);

        //Course Duration Permission
        $roleOIC->attachPermission($permissionsBySlug['modify.courseduration']);
        $roleMA->attachPermission($permissionsBySlug['modify.courseduration']);
        $roleMR->attachPermission($permissionsBySlug['modify.courseduration']);

        //Training Institute modify permission
        $roleOIC->attachPermission($permissionsBySlug['modify.traininginstitute']);
        $roleMA->attachPermission($permissionsBySlug['modify.traininginstitute']);
        $roleMR->attachPermission($permissionsBySlug['modify.traininginstitute']);
        $roleInstructor->attachPermission($permissionsBySlug['modify.traininginstitute']);

        //Implant Training Permission
        $roleOIC->attachPermission($permissionsBySlug['modify.implanttraining']);
        $roleMA->attachPermission($permissionsBySlug['modify.implanttraining']);
        $roleMR->attachPermission($permissionsBySlug['modify.implanttraining']);
        $roleInstructor->attachPermission($permissionsBySlug['modify.implanttraining']);
   
        //Dropout Permission
        $roleOIC->attachPermission($permissionsBySlug['modify.dropouts']);
        $roleMA->attachPermission($permissionsBySlug['modify.dropouts']);
        $roleMR->attachPermission($permissionsBySlug['modify.dropouts']);
        $roleInstructor->attachPermission($permissionsBySlug['modify.dropouts']);

        //Suspended Permission
        $roleOIC->attachPermission($permissionsBySlug['modify.suspended']);
        $roleMA->attachPermission($permissionsBySlug['modify.suspended']);
        $roleMR->attachPermission($permissionsBySlug['modify.suspended']);
        $roleInstructor->attachPermission($permissionsBySlug['modify.suspended']);

        //Certificate Permission
        $roleOIC->attachPermission($permissionsBySlug['modify.certificate']);
        $roleMA->attachPermission($permissionsBySlug['modify.certificate']);
        $roleMR->attachPermission($permissionsBySlug['modify.certificate']);
        $roleInstructor->attachPermission($permissionsBySlug['modify.certificate']);
    }
}