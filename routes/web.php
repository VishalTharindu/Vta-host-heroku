<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

//HomePage Routes

//You can use HomeController@index for homepage
Route::get('/', ['as' => 'index', 'uses' => 'HomeController@home']);

Auth::routes();

Route::get('/home', 'HomeController@home')->name('home');
Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'UserController')->middleware('role:admin');
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

    //Batch Routes
    Route::resource('batch', 'BatchController')->middleware('permission:modify.batch');

    //Course Routes
    Route::resource('course', 'CourseController')->middleware('permission:modify.course');;

    //Applicant Routes
    Route::put('applicant/applicantsDelete/{batch}', ['as' => 'applicant.applicantsDelete', 'uses' => 'ApplicantController@applicantsDelete'])->middleware('permission:applicant.delete');
    Route::get('applicant/filterData', 'ApplicantController@filterData')->name('applicant.filterData')->middleware('permission:applicant.filter.data');
    Route::resource('applicant', 'ApplicantController')->middleware('permission:modify.applicant');

    //Interview Routes
    Route::get('interview', ['as' => 'interview.index', 'uses' => 'InterviewController@interview'])->middleware('permission:applicant.interview');
    Route::get('interview/select', 'InterviewController@interviewBatchSelect')->name('interview.select')->middleware('permission:applicant.interview');
    Route::get('interview/change', 'InterviewController@interviewBatchChange')->name('interview.change')->middleware('permission:applicant.interview');
    Route::get('interview/reviewMR', 'InterviewController@notificationToMR')->name('interview.reviewMR')->middleware('permission:applicant.interview');
    Route::get('interview/reviewOIC', 'InterviewController@notificationToOIC')->name('interview.reviewOIC')->middleware('permission:applicant.interview');
    Route::get('interview/oicConfirm', 'InterviewController@oicConfirm')->name('interview.oicConfirm')->middleware('permission:applicant.interview');
    Route::get('interview/rejectedList', 'InterviewController@rejected')->name('interview.rejected')->middleware('permission:applicant.interview');
    Route::get('updateTrainee', 'InterviewController@toTraineeView')->name('interview.updateTrainee')->middleware('permission:applicant.interview');
    Route::put('applicant/select/{applicant}', ['as' => 'applicant.select', 'uses' => 'InterviewController@applicantSelect'])->middleware('permission:applicant.interview');
    Route::put('applicant/unselect/{applicant}', ['as' => 'applicant.unselect', 'uses' => 'InterviewController@applicantUnselect'])->middleware('permission:applicant.interview');
    Route::put('applicant/reject/{applicant}', ['as' => 'applicant.reject', 'uses' => 'InterviewController@applicantReject'])->middleware('permission:applicant.interview');
    //Route::post('interview/filterCourse', ['as' => 'interview.filterCourse', 'uses' => 'InterviewController@filterCourse']);
    Route::get('interview/filterCourse', 'InterviewController@filterCourse')->name('interview.filterCourse')->middleware('permission:applicant.interview');

    //Trainee Routes
    Route::get('trainee/finishUpdate', 'TraineeController@finishUpdate')->name('trainee.finishUpdate')->middleware('permission:modify.trainee');
    //Route::get('trainee/filterData', 'TraineeController@filterData')->name('trainee.filterData');
    Route::post('trainee/filterData', ['as' => 'trainee.filterData', 'uses' => 'TraineeController@filterData'])->middleware('permission:modify.trainee');
    Route::resource('trainee', 'TraineeController')->middleware('permission:modify.trainee');

    //Demonstrator Routes
    Route::resource('demonstrator', 'DemonstratorController')->middleware('permission:modify.demonstrator');

    //Instructor Routes
    Route::resource('instructor', 'InstructorController')->middleware('permission:modify.instructor');

    //Adminstrative Staff Routes
    Route::resource('adminStaff', 'administrativeStaffController')->middleware('permission:modify.admin.staff');

    //Attendance Routes
    Route::resource('attendance', 'AttendanceController')->middleware('permission:modify.attendance');
    Route::get('attendance/show/select', ['as' => 'attendance.select', 'uses' => 'AttendanceController@showAttendanceSelectForm'])->middleware('permission:modify.attendance');
    Route::get('attendance/show/eligibility', ['as' => 'attendance.select.eligibility', 'uses' => 'AttendanceController@showEligibiltyForm'])->middleware('permission:modify.attendance');
    Route::post('attendance/show/eligibility', ['as' => 'attendance.eligibility', 'uses' => 'AttendanceController@calculateEligibilty'])->middleware('permission:modify.attendance');
    Route::post('attendance/show/select', ['as' => 'attendance.view', 'uses' => 'AttendanceController@showAttendanceViewForm'])->middleware('permission:modify.attendance');
    Route::post('attendance/add/today', ['as' => 'attendance.add', 'uses' => 'AttendanceController@showAttendanceForm'])->middleware('permission:modify.attendance');
    Route::get('attendance/report/daily', ['as' => 'attendance.report.daily', 'uses' => 'AttendanceController@reportDailyIndex'])->middleware('permission:modify.attendance');
    Route::post('attendance/report/daily', ['as' => 'attendance.report.daily.submit', 'uses' => 'AttendanceController@reportDailySubmit'])->middleware('permission:modify.attendance');
    Route::get('attendance/report/monthly', ['as' => 'attendance.report.monthly', 'uses' => 'AttendanceController@reportMonthlyIndex'])->middleware('permission:modify.attendance');
    Route::post('attendance/report/monthly', ['as' => 'attendance.report.monthly.submit', 'uses' => 'AttendanceController@reportMonthlySubmit'])->middleware('permission:modify.attendance');
    Route::get('attendance/permission/add', ['as' => 'attendance.permission.add', 'uses' => 'AttendanceController@addAttendancePermission'])->middleware('permission:give.attendance.permission');
    Route::post('attendance/permission/add', ['as' => 'attendance.permission.add.submit', 'uses' => 'AttendanceController@addAttendancePermissionSubmit'])->middleware('permission:give.attendance.permission');
    Route::get('attendance/permission/lock/{id}', ['as' => 'attendance.permission.lock', 'uses' => 'AttendanceController@addAttendancePermissionLock'])->middleware('permission:give.attendance.permission');
   
    //Scholarship Routes
    Route::resource('funds', 'FundController')->middleware('permission:modify.fund');
    Route::get('trainee/scholarship/waiting', ['as' => 'trainee.waiting', 'uses' => 'TraineeController@scholarshipWaitingList'])->middleware('permission:modify.fund');
    Route::post('fund/show/select', ['as' => 'fund.select', 'uses' => 'FundController@viewPaymentEligibility'])->middleware('permission:modify.fund');

    Route::get('/trainee/assignefund/{trainee}', ['as' => 'trainee.assignefund', 'uses' => 'TraineeController@assigneFunds'])->middleware('permission:modify.fund');
    Route::get('/trainee/assigne/fund/{trainee}', ['as' => 'trainee.assignenewfund', 'uses' => 'TraineeController@assigneFundsToTrainees'])->middleware('permission:modify.fund');

    Route::get('/trainee/reassignefund/{trainee}', ['as' => 'trainee.reassignefund', 'uses' => 'TraineeController@reassigneFunds'])->middleware('permission:modify.fund');
    Route::get('trainee/reassigne/fund/{trainee}', ['as' => 'trainee.reassignefundtotrainees', 'uses' => 'TraineeController@reassigneFundsToTrainees'])->middleware('permission:modify.fund');

    Route::get('trainee/fundsallocated/trainees', ['as' => 'trainee.fundsallocatedtrainees', 'uses' => 'TraineeController@fundsAllocatedTrainees'])->middleware('permission:modify.fund');
    Route::get('trainee/removefundtrainee/{trainees}', ['as' => 'trainee.removefundtrainee', 'uses' => 'TraineeController@removeFunds'])->middleware('permission:modify.fund');
    Route::get('edit/scholarship/{fund}', ['as' => 'trainee.removefundtrainee', 'uses' => 'TraineeController@edit'])->middleware('permission:modify.fund');

    Route::get('upload/scholarship/document/{trainee}', ['as' => 'trainee.uploaddocumentview', 'uses' => 'TraineeController@scholarshipDocument'])->middleware('permission:modify.fund');
    Route::post('scholarship/document/upload/{trainee}', ['as' => 'trainee.uploaddocument', 'uses' => 'TraineeController@scholarshipDocumentUpload'])->middleware('permission:modify.fund');
    
    Route::get('edit/uploaded/scholarship/document/{trainee}', ['as' => 'trainee.edituploadview', 'uses' => 'TraineeController@editscholarshipDocument'])->middleware('permission:modify.fund');
    Route::post('edit/scholarship/document/upload/{trainee}', ['as' => 'trainee.edituploaddocument', 'uses' => 'TraineeController@editScholarshipDocumentUpload'])->middleware('permission:modify.fund');

    //Calendar Routes
    Route::resource('calendar', 'CalendarController')->middleware('permission:modify.calendar');


    // Examination Routes

    Route::get('search/eligible/trainee/exam', ['as' => 'trainee.eliible.exam', 'uses' => 'ExaminationController@index'])->middleware('permission:modify.examination');
    Route::post('eligible/list/trainee/exam', ['as' => 'trainee.exam.eligible.list', 'uses' => 'ExaminationController@eligibleListForExam'])->middleware('permission:modify.examination');

    Route::get('practical/eligible/trainee/exam', ['as' => 'practical.eligible.trainee.exam', 'uses' => 'ExaminationController@practicalEligibilityIndex'])->middleware('permission:modify.examination');
    Route::post('practical/eligible/list/trainee/exam', ['as' => 'practical.eligible.list.trainee.exam', 'uses' => 'ExaminationController@eligibleListForPracticalExam'])->middleware('permission:modify.examination');

    Route::get('course/subject/fetch', ['as' => 'course.subject.fetch', 'uses' => 'ExaminationController@fetch'])->middleware('permission:modify.examination');
    Route::post('course/subject/trainee', ['as' => 'course.subject.trainee', 'uses' => 'ExaminationController@subjectTrainee'])->middleware('permission:modify.examination');

    Route::post('mark/subject/trainees/exam', ['as' => 'mark.subject.trainees.exam', 'uses' => 'MarkController@markSubjectResult'])->middleware('permission:modify.examination');
    Route::get('select/subject/mark', ['as' => 'trainee.subject.mark', 'uses' => 'ExaminationController@markSubjectView'])->middleware('permission:modify.examination');

    Route::get('select/practical/subject/mark', ['as' => 'select.practical.subject.mark', 'uses' => 'MarkController@markSubjectPracticalView'])->middleware('permission:modify.examination');
    Route::post('course/subject/practical/trainee', ['as' => 'course.subject.practical.trainee', 'uses' => 'MarkController@subjectPracticalTrainee'])->middleware('permission:modify.examination');
    Route::post('mark/subject/practical/trainees/exam', ['as' => 'mark.subject.practical.trainees.exam', 'uses' => 'MarkController@markPracticalResult'])->middleware('permission:modify.examination');
    
    Route::get('trainee/finel/result/view', ['as' => 'trainee.finel.result.view', 'uses' => 'ExaminationController@traineeFinalList'])->middleware('permission:modify.examination');
    Route::post('mark/trainee/finel/result/view', ['as' => 'mark.trainee.finel.result.view', 'uses' => 'ExaminationController@markTraineefinalresult'])->middleware('permission:modify.examination');
    Route::post('mark/result/trainees/exam', ['as' => 'trainee.exam.mark.result', 'uses' => 'ExaminationController@markTraineeFinalResultStore'])->middleware('permission:modify.examination');

    Route::get('trainee/finel/practical/result/view', ['as' => 'trainee.finel.practical.result.view', 'uses' => 'ExaminationController@traineePracticalFinalList'])->middleware('permission:modify.examination');
    Route::post('mark/trainee/finel/practical/result/view', ['as' => 'mark.trainee.finel.practical.result.view', 'uses' => 'ExaminationController@markTraineefinalPractiaclresult'])->middleware('permission:modify.examination');
    Route::post('store/practical/result/trainees/exam', ['as' => 'store.practical.result.trainees.exam', 'uses' => 'ExaminationController@markTraineeFinalPracticalResultStore'])->middleware('permission:modify.examination');

    Route::get('finel/result/', ['as' => 'finel.result', 'uses' => 'ExaminationController@checkFinalResult'])->middleware('permission:modify.examination');
    Route::get('finel/attempt/result/', ['as' => 'finel.attempt.result', 'uses' => 'ExaminationController@checkAttemptResult'])->middleware('permission:modify.examination');
    Route::post('trainee/finel/result/', ['as' => 'trainee.finel.result', 'uses' => 'ExaminationController@finalResult'])->middleware('permission:modify.examination');
    Route::post('trainee.exam.attempt.result/', ['as' => 'trainee.exam.attempt.result', 'uses' => 'ExaminationController@attemptWiseResult'])->middleware('permission:modify.examination');
    
    Route::get('finel/attempt/practical/result/', ['as' => 'finel.attempt.practical.result', 'uses' => 'ExaminationController@checkPracticalAttemptResult'])->middleware('permission:modify.examination');
    Route::post('trainee/practical/exam/attempt/result/', ['as' => 'trainee.practical.exam.attempt.result', 'uses' => 'ExaminationController@practicalAttemptWiseResult'])->middleware('permission:modify.examination');

    Route::get('trainee/overall/result/', ['as' => 'trainee.overall.result', 'uses' => 'ExaminationController@checkOverallResult'])->middleware('permission:modify.examination');
    Route::post('trainee/overall/result/view', ['as' => 'trainee.overall.result.view', 'uses' => 'ExaminationController@OveerallResult'])->middleware('permission:modify.examination');

    Route::get('course/subject/result/fetch', ['as' => 'course.subject.result.fetch', 'uses' => 'MarkController@fetch'])->middleware('permission:modify.examination');
    Route::get('check/subject/result', ['as' => 'check.subject.result', 'uses' => 'MarkController@selectSubjectView'])->middleware('permission:modify.examination');
    Route::post('course/subject/result', ['as' => 'course.subject.result', 'uses' => 'MarkController@subjectResult'])->middleware('permission:modify.examination');

    Route::resource('exmpayment', 'ExaminationPaymentController')->middleware('permission:modify.examination');

    Route::post('trainee/list/exmpayment', ['as' => 'exmpayment.creates', 'uses' => 'ExaminationPaymentController@create'])->middleware('permission:modify.examination');


    //Pre Assesment
    Route::resource('preassesment', 'PreAssesmentController')->middleware('permission:modify.preassesment');
    
    Route::get('edit/pre/assesment/{preAssesment}', ['as' => 'preassesment.edit', 'uses' => 'PreAssesmentController@edit'])->middleware('permission:modify.preassesment');
    Route::post('update/pre/assesment/{preAssesment}', ['as' => 'preassesment.update', 'uses' => 'PreAssesmentController@update'])->middleware('permission:modify.preassesment');
    Route::get('complete/pre/assesment/{preAssesment}', ['as' => 'preassesment.complete', 'uses' => 'PreAssesmentController@assestmentComnplete'])->middleware('permission:modify.preassesment');
    Route::delete('destory/pre/assesment/{preAssesment}', ['as' => 'preassesment.destroy', 'uses' => 'PreAssesmentController@destroy'])->middleware('permission:modify.preassesment');

    Route::get('search/eligible/trainee/preassesment', ['as' => 'preassesment.trainee.eliible', 'uses' => 'PreAssesmentRsultController@index'])->middleware('permission:modify.preassesment');
    Route::post('eligible/list/trainee/preassesment', ['as' => 'preassesment.trainee.eligible.list', 'uses' => 'PreAssesmentRsultController@eligibleListForExam'])->middleware('permission:modify.preassesment');

    Route::get('preassesment/course/subject/fetch', ['as' => 'preassesment.course.subject.fetch', 'uses' => 'PreAssesmentRsultController@prefetch'])->middleware('permission:modify.preassesment');
    Route::post('preassesment/course/subject/trainee', ['as' => 'preassesment.course.subject.trainee', 'uses' => 'PreAssesmentRsultController@presubjectTrainee'])->middleware('permission:modify.preassesment');

    Route::post('mark/subject/trainees/preassesment', ['as' => 'preassesment.mark.subject.trainees', 'uses' => 'PreAssesmentMarkController@markSubjectResult'])->middleware('permission:modify.preassesment');
    Route::get('select/subject/mark/preassesment', ['as' => 'preassesment.trainee.subject.mark', 'uses' => 'PreAssesmentRsultController@markSubjectView'])->middleware('permission:modify.preassesment');
    
    Route::get('trainee/finel/result/view/preassesment', ['as' => 'preassesment.trainee.finel.result.view', 'uses' => 'PreAssesmentRsultController@traineeFinalList'])->middleware('permission:modify.preassesment');
    Route::post('mark/trainee/finel/result/view/preassesment', ['as' => 'preassesment.mark.trainee.finel.result.view', 'uses' => 'PreAssesmentRsultController@markTraineefinalresult'])->middleware('permission:modify.preassesment');
    Route::post('mark/result/trainees/exam/preassesment', ['as' => 'trainee.preassesment.mark.result', 'uses' => 'PreAssesmentRsultController@markTraineeFinalResultStore'])->middleware('permission:modify.preassesment');

    Route::get('finel/result/preassesment', ['as' => 'preassesment.finel.result', 'uses' => 'PreAssesmentRsultController@checkFinalResult'])->middleware('permission:modify.preassesment');
    Route::post('trainee/finel/result/preassesment', ['as' => 'preassesment.trainee.finel.result', 'uses' => 'PreAssesmentRsultController@finalResult'])->middleware('permission:modify.preassesment');


    
    //Subjects Routes
    Route::resource('subject', 'SubjectController')->middleware('permission:modify.subject');

    //Course Duration Routes
    Route::resource('courseduration', 'CourseDurationController')->middleware('permission:modify.courseduration');

    //Training Institutes Routes
    Route::resource('trainingInstitute', 'TrainingInstituteController')->middleware('permission:modify.traininginstitute');

    //Implant Training Routes
    Route::get('implantTraining', 'ImplantTrainingController@index')->name('implantTraining.letter')->middleware('permission:modify.implanttraining');
    Route::get('implantTraining/Implant_Training_form', 'ImplantTrainingController@ojtForm')->name('implantTraining.ojtForm')->middleware('permission:modify.implanttraining');
    Route::get('implantTraining/change', 'ImplantTrainingController@change')->name('implantTraining.change')->middleware('permission:modify.implanttraining');
    Route::get('implantTraining/filterData', 'ImplantTrainingController@filterData')->name('implantTraining.filterData')->middleware('permission:modify.implanttraining');
    Route::get('implantTraining/filterBatchAndCourse', 'ImplantTrainingController@filterBatchAndCourse')->name('implantTraining.filterBatchAndCourse')->middleware('permission:modify.implanttraining');
    Route::put('implantTraining/generatePdf/{trainee}', ['as' => 'implantTraining.generatePdf', 'uses' => 'ImplantTrainingController@generatePdf'])->middleware('permission:modify.implanttraining');
    Route::put('implantTraining/trainingDetails/{trainee}', ['as' => 'implantTraining.trainingDetails', 'uses' => 'ImplantTrainingController@trainingDetails'])->middleware('permission:modify.implanttraining');
    Route::get('implantTraining/generateForm', 'ImplantTrainingController@generateForm')->name('implantTraining.generateForm')->middleware('permission:modify.implanttraining');

    //Dropout Routes
    Route::resource('dropout', 'DropoutController')->middleware('permission:modify.dropouts');
    Route::get('warning/letter/{trainee}', ['as' => 'dropout.letter', 'uses' => 'DropoutController@generateWarningPdf'])->middleware('permission:modify.dropouts');
    Route::get('suspended', ['as' => 'suspended.index', 'uses' => 'DropoutController@suspendedIndex'])->middleware('permission:modify.suspended');
    Route::post('suspended', ['as' => 'suspended.filter', 'uses' => 'DropoutController@filterData'])->middleware('permission:modify.suspended');
    Route::get('suspended/reconsidered', ['as' => 'suspended.reconsider.index', 'uses' => 'DropoutController@suspendReconsiderIndex'])->middleware('permission:modify.suspended');
    Route::get('suspended/reconsider/{trainee}', ['as' => 'suspended.reconsider', 'uses' => 'DropoutController@suspendReconsider'])->middleware('permission:modify.suspended');
    Route::post('suspended/reconsider/medicalreport', ['as' => 'suspended.reconsider.medical', 'uses' => 'DropoutController@uploadMedicalReports'])->middleware('permission:modify.suspended');
    Route::get('suspended/letter/{trainee}', ['as' => 'suspended.letter', 'uses' => 'DropoutController@generateSuspendPdf'])->middleware('permission:modify.suspended');
    Route::get('suspended/course', ['as' => 'suspended.count', 'uses' => 'DropoutController@suspendedCountByCourse'])->middleware('permission:modify.suspended');
    Route::post('suspended/leave/letter', ['as' => 'suspended.leave.letter', 'uses' => 'DropoutController@uploadLeaveLetter'])->middleware('permission:modify.suspended');
    
    //mark as read notification
    Route::get('/mark-as-read', 'HomeController@markNotification')->name('markNotification');
    Route::get('/mark-as-read-one/{if}', 'HomeController@markSingleNotification')->name('markSingleNotification');

    //certificates
    Route::resource('certificate', 'CertificateController')->middleware('permission:modify.certificate');
    Route::post('certificate/filter', ['as' => 'certificate.filter', 'uses' => 'CertificateController@filterData'])->middleware('permission:modify.certificate');
});