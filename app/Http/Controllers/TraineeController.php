<?php

namespace App\Http\Controllers;

use App\Trainee;
use App\Batch;
use App\Course;
use App\Fund;
use Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\TraineeRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TraineeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Trainee $trainee)
    {
        $trainees = Trainee::where([
            ['status', '!=', 2],
        ])->get();
        
        $courses = Course::get();
        $batches = Batch::get();
        $maleCount = $trainee->maleCount($trainees);
        $femaleCount = $trainee->femaleCount($trainees);
        return view('trainee.index', compact('trainees','courses','batches','maleCount','femaleCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->hasRole('mr') || Auth::user()->hasRole('admin')){
            $courses = Course::select('id','course_name')->get();
            $batches = Batch::get();

            return view('trainee.create', compact('courses','batches'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasRole('mr') || Auth::user()->hasRole('admin')){
            $validatedData = $request->validate([
                'name_with_initials' => 'required|string|min:4',
                'full_name' => 'required|string|min:4',
                'nic' => [
                    'required',
                    'regex:/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/m',
                    Rule::unique('applicants', 'nic')
                ],
                'enrollment_no' => [
                    'required',
                    'max:255',
                    Rule::unique('trainees', 'enrollment_no')
                ],
                'image' => 'required|image|max:1024',
                'gender' => 'required',
                'ethnicity' => 'required',
                'phone_number' => 'required|numeric|regex:/[0-9]{10}/',
                'address' => 'required',
                'city' => 'required',
                'qualification' => 'required',
                'course_id' => 'required',
                'batch_id' => 'required',
            ]);
    
    
            $image = $request->image->store('trainees');
    
            $trainee = new Trainee;
            $trainee->name_with_initials = request('name_with_initials');
            $trainee->full_name = request('full_name');
            $trainee->enrollment_no = request('enrollment_no');
            $trainee->image = $image;
            $trainee->email = request('email');
            $trainee->nic = request('nic');
            $trainee->gender = request('gender');
            $trainee->ethnicity = request('ethnicity');
            $trainee->course_id = request('course_id');
            $trainee->batch_id = request('batch_id');
            $trainee->city = request('city');
            $trainee->phone_number = request('phone_number');
            $trainee->address = request('address');
            $trainee->qualification = request('qualification');
            $trainee->save();
    
            return redirect()->route('trainee.index')->withStatus(__('Trainee data Added Successfully'));
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trainee  $trainee
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trainee  $trainee
     * @return \Illuminate\Http\Response
     */
    public function edit(Trainee $trainee)
    {
        $courses = Course::select('id','course_name')->get();
        $batches = Batch::get();
        $maEdit = false;
        if($trainee->status == 1){
            $maEdit = True;

        }
        return view('trainee.edit', compact('trainee','courses','batches','maEdit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trainee  $trainee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trainee $trainee)
    {
        //dd(request('full_name'));
        if(request('mode') == 'interview'){

            if($trainee->image == NULL){

                $validatedData = $request->validate([
                    'enrollment_no' => [
                        'required',
                        'max:255',
                        Rule::unique('trainees', 'enrollment_no')->ignore($trainee)
                    ],
                    'image' => 'required|image|max:1024',
                ]);

                $image = $request->image->store('trainees');
                Trainee::where('id', $trainee->id)->update([
                    'enrollment_no' => request('enrollment_no'),
                    'image' => $image
                    ]);
            }
            else{

                if($request->hasFile('image')){
                    $validatedData = $request->validate([
                        'enrollment_no' => [
                            'required',
                            'max:255',
                            Rule::unique('trainees', 'enrollment_no')->ignore($trainee)
                        ],
                        'image' => 'image|max:1024',
                    ]);
    
                    $image = $request->image->store('trainees');
                    Storage::delete($trainee->image); 

                    Trainee::where('id', $trainee->id)->update([
                        'enrollment_no' => request('enrollment_no'),
                        'image' => $image
                        ]);
                }
                else{

                    $validatedData = $request->validate([
                        'enrollment_no' => [
                            'required',
                            'max:255',
                            Rule::unique('trainees', 'enrollment_no')->ignore($trainee)
                        ]
                    ]);
        
    
                    Trainee::where('id', $trainee->id)->update([
                        'enrollment_no' => request('enrollment_no')
                        ]);
                }
                

            }
            
            return redirect()->route('interview.updateTrainee')->withStatus(__('Trainee data updated'));

        }
        elseif(request('mode') == 'normal'){
            dd('normal');
            //$validated = $request->validated();
        }

        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trainee  $trainee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trainee $trainee)
    {
        //
    }

    /**
     * Managenemt Assistant finish updating trainee data afer interview
     *
     * @return \Illuminate\Http\Response
     */
    public function finishUpdate()
    {
        //dd(Trainee::where('enrollment_no','0')->get()->count());
        if(Trainee::where('enrollment_no', NULL)->get()->count() > 0){
            return redirect()->route('interview.updateTrainee')->withError(__('You need to fill Enrollment Number of all trainees'));
        }
        $trainees = Trainee::where('status',1)->get();

        if($trainees->count() > 0){

            Trainee::where('status', 1)
            ->update(['status' => 0]);

            Batch::where('interview_status', 4)
                    ->update(['interview_status' => 5]);

            return redirect()->route('home')->withStatus(__('Trainee data updated'));
        }

    }

    public function filterData(Trainee $trainee){

        $filterCourse  = request('filterCourse');
        $filterBatch = request('filterBatch');

        $courses = Course::get();
        $batches = Batch::get();

        if($filterBatch != 0 && $filterCourse != 0){

            $trainees = $trainee->filter($filterBatch,$filterCourse);
            $maleCount = $trainee->maleCount($trainees);
            $femaleCount = $trainee->femaleCount($trainees);
            
            return view('trainee.index', compact('trainees','courses','batches','filterCourse','filterBatch','maleCount','femaleCount'));

        }
        elseif($filterBatch == 0 && $filterCourse == 0){

            return redirect()->route('trainee.index');

        }
        elseif($filterBatch != 0 && $filterCourse == 0){

            $trainees = $trainee->filterBatch($filterBatch);
            $maleCount = $trainee->maleCount($trainees);
            $femaleCount = $trainee->femaleCount($trainees);

            return view('trainee.index', compact('trainees','courses','batches','filterBatch','maleCount','femaleCount'));

        }
        elseif($filterBatch == 0 && $filterCourse != 0){

            $trainees = $trainee->filterCourse($filterCourse);
            $maleCount = $trainee->maleCount($trainees);
            $femaleCount = $trainee->femaleCount($trainees);

            return view('trainee.index', compact('trainees','courses','batches','filterCourse','maleCount','femaleCount'));

        }


    }

    public function scholarshipWaitingList(){

        if (Auth::user()->hasRole('oic')) {
            
            $funds = Fund::select('id','fund_name')->get();
            $eligibleTrainees = DB::table('fund_trainee')->pluck('trainee_id');
            $trainees = Trainee::whereNotIn('id',$eligibleTrainees)->get();
            $recount = $trainees->count();
            return view('payment.all', compact('trainees','funds','recount'));

        }else{
            abort(403);
        }

    }

    public function assigneFunds(Request $request, Trainee $trainee)
    {
        if ($request->funds) {
            $trainee->funds()->attach($request->funds);
        }
        return redirect()->route('trainee.waiting')->withStatus(__('Funds has being assinged successfully'));
    }

    public function assigneFundsToTrainees(Trainee $trainee){

        if (Auth::user()->hasRole('oic')) {

            $funds = Fund::select('id','fund_name')->get();
            return view('payment.scholarshipassigne', compact('trainee', 'funds'));

        }else {
            abort(403);
        }


    }

    public function fundsAllocatedTrainees()
    {
        if (Auth::user()->hasRole('oic')) {
            
            $funds = Fund::select('id','fund_name')->get();
            $eligibleTraineesid = DB::table('fund_trainee')->pluck('trainee_id');
            $trainees = Trainee::whereIn('id',$eligibleTraineesid)->get();
            $recount = $trainees->count();

            return view('payment.aclocatedtrainees', compact('trainees','funds','recount'));

        }else {
            abort(403);
        }

        
    }

    public function reassigneFundsToTrainees(Trainee $trainee){

        if (Auth::user()->hasRole('oic')) {

            $funds = Fund::select('id','fund_name')->get();
            return view('payment.scholarshipreassigne', compact('trainee', 'funds'));

        }else{
            abort(403);
        }

        // return redirect()->back();

    }

    public function reassigneFunds(Request $request, Trainee $trainee)
    {
        if ($request->funds) {
            $trainee->funds()->sync($request->funds);
        }
        return redirect()->route('trainee.fundsallocatedtrainees')->withStatus(__('Funds has being reassinged successfully'));
    }

    public function removeFunds(Trainee $trainees)
    {
        $trainees->funds()->detach($trainees->funds);
        return redirect()->back()->withStatus(__('Funds has being removed from the trainee successfully'));
    }

    public function scholarshipDocument(Trainee $trainee)
    {
        if (Auth::user()->hasRole('mr')) {

            return view('payment.document.create', compact('trainee'));

        }else {
            abort(403);
        }

    }

    public function editscholarshipDocument(Trainee $trainee)
    {
        if (Auth::user()->hasRole('mr')) {

            return view('payment.document.edit', compact('trainee'));

        }else {
            abort(403);
        }

    }

    public function scholarshipDocumentUpload(Request $request, Trainee $trainee)
    {

        if (Auth::user()->hasRole('mr')) {

            $document = [];
            $forumA = 0;
            $forumB = 0;
            if($request->hasfile('forumA')){
                $forumA= uniqid('vta_') . '.' . $request->forumA->getClientOriginalExtension();
                $request->forumA->storeAs('ForumA', $forumA); 
            }
            
            if($request->hasfile('forumB')){
                $forumB= uniqid('vta_') . '.' . $request->forumB->getClientOriginalExtension();
                $request->forumB->storeAs('ForumB', $forumB);
            }                   

            if ($request->hasfile('other_document')) {

                foreach($request->file('other_document') as $image)
                {
                    $otherdocument = uniqid('vta_') . '.' . $image->getClientOriginalExtension();
                    $path = \Storage::disk('public')->put($otherdocument, file_get_contents($image));             
                    $document[] = $otherdocument;

                    
                }
            }

            $updateDetails = [
                'forumB' => $forumB,
                'forumA' => $forumA,
                'other_documents' => json_encode($document)
            ];

            Trainee::where('id', $trainee->id)->update($updateDetails);
            return redirect()->route('trainee.index')->withStatus(__('Scholarship Document data upload success'));

        }else {
            abort(403);
        }

        

    }

    public function editScholarshipDocumentUpload(Request $request, Trainee $trainee)
    {
        if (Auth::user()->hasRole('mr')) {

            $document = [];
            $forumA = 0;
            $forumB = 0;
            if($request->hasfile('forumA')){
                $forumA= uniqid('vta_') . '.' . $request->forumA->getClientOriginalExtension();
                $request->forumA->storeAs('ForumA', $forumA); 
            }else {
                $forumA = $trainee->forumA;
            }
            
            if($request->hasfile('forumB')){
                $forumB= uniqid('vta_') . '.' . $request->forumB->getClientOriginalExtension();
                $request->forumB->storeAs('ForumB', $forumB);
            }else {
                $forumB = $trainee->forumB;
            }                   

            if ($request->hasfile('other_document')) {

                foreach($request->file('other_document') as $image)
                {
                    $otherdocument = uniqid('vta_') . '.' . $image->getClientOriginalExtension();
                    $path = \Storage::disk('public')->put($otherdocument, file_get_contents($image));             
                    $document[] = $otherdocument;

                    
                }
            }else {
                foreach (json_decode($trainee->other_documents) as $image) {
                $document[] =$image; 
                }
            }

            $updateDetails = [
                'forumB' => $forumB,
                'forumA' => $forumA,
                'other_documents' => json_encode($document)
            ];

            Trainee::where('id', $trainee->id)->update($updateDetails);
            return redirect()->route('trainee.index')->withStatus(__('Scholarship Document data upload success'));
        }

        return redirect()->back();

    }

}