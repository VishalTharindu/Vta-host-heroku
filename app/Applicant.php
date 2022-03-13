<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = ['status','selected_course_id'];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function hasCourses($courseId)
    {
        return in_array($courseId, $this->courses->pluck('id')->toarray());
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function course($id){
        return Course::select('course_name')->where('id',$id)->first();
    }
    
    //To get the batch in interview process
    public function BatchInInterview(){
        return Batch::where('interview_status', 1)->orWhere('interview_status', 2)->orWhere('interview_status', 3)->first();
    }

    //To get the batch details
    public function getbatch($id){
        return Batch::where('id',$id)->first();
    }

    public function ifInterview(){
        return Batch::where('interview_status', 1)->count();
    }

    public function selectedApplicants($filteredCourse){
        if($filteredCourse != 0){
            return Applicant::where([
                    ['status', '=', 1],
                    ['selected_course_id', '=', $filteredCourse]
                ])->get();
        }
        return Applicant::where('status', 1)->get();
    }

    public function maleCount($applicants)
    {
        return $applicants->where('gender','male')->count();
    }
    public function femaleCount($applicants)
    {
        return $applicants->where('gender','female')->count();
    }
}
