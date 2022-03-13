<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="{{route('home')}}">
                <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Dashboards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-examples">
                            <i class="ni ni-user-run text-orange"></i>
                            <span class="nav-link-text">Trainee</span>
                        </a>
                        <div class="collapse" id="navbar-examples">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('trainee.index')}}" class="nav-link" role="button"
                                        aria-expanded="true" aria-controls="exams-multilevel">View Trainees</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#admission-multilevel" class="nav-link" data-toggle="collapse"
                                        role="button" aria-expanded="true"
                                        aria-controls="admission-multilevel">Admission</a>
                                    <div class="collapse show" id="admission-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{route('applicant.index')}}" class="nav-link ">Applicants</a>
                                            </li>
                                            {{-- <li class="nav-item">
                                                <a href="#!" class="nav-link ">Just another link</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link ">One last link</a>
                                            </li> --}}
                                        </ul>
                                    </div>
                                </li>
                                @role('ma | mr | oic')
                                <li class="nav-item">
                                    <a href="#interview-multilevel" class="nav-link" data-toggle="collapse"
                                        role="button" aria-expanded="true"
                                        aria-controls="interview-multilevel">Interview</a>
                                    <div class="collapse show" id="interview-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{ route('interview.index') }}" class="nav-link" role="button"
                                                    aria-expanded="true">
                                                    @role('ma')
                                                    Start or View
                                                    @endrole
                                                    @role('mr|oic')
                                                    View
                                                    @endrole
                                                </a>
                                            </li>
                                            @role('ma')
                                            <li class="nav-item">
                                                <a href="{{ route('interview.updateTrainee') }}" class="nav-link"
                                                    role="button" aria-expanded="true">Update Trainee Data</a>
                                            </li>
                                            @endrole
                                        </ul>
                                    </div>
                                </li>
                                @endrole
                                <li class="nav-item">
                                    <a href="#attendance-multilevel" class="nav-link" data-toggle="collapse"
                                        role="button" aria-expanded="true"
                                        aria-controls="attendance-multilevel">Attendance</a>
                                    <div class="collapse show" id="attendance-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{route('attendance.index')}}" class="nav-link ">Mark
                                                    Attendance</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('attendance.select')}}" class="nav-link ">View
                                                    Attendance</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('attendance.select.eligibility')}}"
                                                    class="nav-link ">Check
                                                    Eligibility</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('attendance.report.daily')}}" class="nav-link ">Daily
                                                    Reports
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('attendance.report.monthly')}}"
                                                    class="nav-link ">Monthly
                                                    Reports
                                                </a>
                                            </li>
                                            @level(4)
                                            <li class="nav-item">
                                                <a href="{{route('attendance.permission.add')}}" class="nav-link ">Give
                                                    Premissions
                                                </a>
                                            </li>
                                            @endlevel

                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="#payments-multilevel" class="nav-link" data-toggle="collapse" role="button"
                                        aria-expanded="true" aria-controls="payments-multilevel">Scholarship</a>
                                    <div class="collapse show" id="payments-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{route('funds.index')}}" class="nav-link ">Scholarships
                                                    Types</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="/trainee/scholarship/waiting" class="nav-link ">Allocate
                                                    Scholarships</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="/trainee/fundsallocated/trainees" class="nav-link ">Allocated
                                                    Trainees</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="/funds/show" class="nav-link ">Scholarships Eligibility</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="#dropouts-multilevel" class="nav-link" data-toggle="collapse" role="button"
                                        aria-expanded="true" aria-controls="dropouts-multilevel">Dropouts</a>
                                    <div class="collapse show" id="dropouts-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{route('dropout.index')}}" class="nav-link ">Dropout
                                                    Warnings</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('suspended.index')}}" class="nav-link ">Suspended
                                                    Trainees</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a href="#ojt-multilevel" class="nav-link" data-toggle="collapse" role="button"
                                        aria-expanded="true" aria-controls="ojt-multilevel">Implant Training</a>
                                    <div class="collapse show" id="ojt-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{ route('trainingInstitute.index') }}"
                                                    class="nav-link">Training Companies</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('implantTraining.ojtForm') }}"
                                                    class="nav-link">Training Log</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('implantTraining.letter') }}"
                                                    class="nav-link">Generate Letter</a>
                                            </li>


                                        </ul>
                                    </div>
                                </li>                                                          
                                <li class="nav-item">
                                    <a href="#certificates-multilevel" class="nav-link" data-toggle="collapse"
                                        role="button" aria-expanded="true"
                                        aria-controls="certificates-multilevel">Certificates</a>
                                    <div class="collapse show" id="certificates-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{ route('certificate.index') }}"
                                                    class="nav-link">Issue Certificate</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-examination" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-examination">
                            <i class="ni ni-briefcase-24 text-info"></i>
                            <span class="nav-link-text">Examination</span>
                        </a>
                        <div class="collapse" id="navbar-examination">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route ( 'exmpayment.index' ) }}" class="nav-link ">Mark Payment</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#preassessment-multilevel" class="nav-link" data-toggle="collapse" role="button"
                                        aria-expanded="true" aria-controls="preassessment-multilevel">Pre Assesstment</a>
                                    <div class="collapse show" id="preassessment-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{ route ( 'preassesment.index' ) }}" class="nav-link ">PA Dates</a>
                                            </li>                                          
                                            <li class="nav-item">
                                                <a href="{{ route ( 'preassesment.trainee.eliible' ) }}" class="nav-link ">PA Eligible List</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route ( 'preassesment.trainee.subject.mark' ) }}" class="nav-link ">Mark PA Subjects</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route ( 'preassesment.trainee.finel.result.view' ) }}" class="nav-link ">Mark PA Final Result</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route ( 'preassesment.finel.result' ) }}" class="nav-link ">PA Result</a>                               
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="#written-multilevel" class="nav-link" data-toggle="collapse" role="button"
                                        aria-expanded="true" aria-controls="written-multilevel">Final Exam</a>
                                    <div class="collapse show" id="written-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{ route ( 'trainee.eliible.exam' ) }}" class="nav-link ">Check
                                                    Eligible List</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route ( 'trainee.subject.mark' ) }}" class="nav-link ">Mark Subjects</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route ( 'trainee.finel.result.view' ) }}" class="nav-link ">Mark Final Result</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route ( 'finel.result' ) }}" class="nav-link ">Exam
                                                    Final Result</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route ( 'check.subject.result' ) }}" class="nav-link ">Subject Result</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route ( 'finel.attempt.result' ) }}" class="nav-link ">Attempts Result</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>                              
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-components" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-components">
                            <i class="ni ni-briefcase-24 text-info"></i>
                            <span class="nav-link-text">Staff</span>
                        </a>
                        <div class="collapse" id="navbar-components">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="#navbar-multilevel" class="nav-link" data-toggle="collapse" role="button"
                                        aria-expanded="true" aria-controls="navbar-multilevel">Staff Manager</a>
                                    <div class="collapse show" id="navbar-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{route('instructor.index')}}" class="nav-link ">Instructor</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('demonstrator.index')}}"
                                                    class="nav-link ">Demonstrator</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('adminStaff.index')}}" class="nav-link ">Administration
                                                    Staff</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-forms" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-forms">
                            <i class="ni ni-settings text-success"></i>
                            <span class="nav-link-text">Training</span>
                        </a>
                        <div class="collapse" id="navbar-forms">
                            <ul class="nav nav-sm flex-column">
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-tables" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-tables">
                            <i class="ni ni-archive-2 text-default"></i>
                            <span class="nav-link-text">Other</span>
                        </a>
                        <div class="collapse" id="navbar-tables">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="#coursesmanagement-multilevel" class="nav-link" data-toggle="collapse"
                                        role="button" aria-expanded="true"
                                        aria-controls="coursesmanagement-multilevel">Courses Management</a>
                                    <div class="collapse show" id="coursesmanagement-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{route('course.create')}}" class="nav-link ">Add New
                                                    Course</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('course.index')}}" class="nav-link ">View Courses</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('courseduration.index')}}" class="nav-link ">Setup
                                                    Course
                                                    Durations</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="#batchmanagement-multilevel" class="nav-link" data-toggle="collapse"
                                        role="button" aria-expanded="true"
                                        aria-controls="batchmanagement-multilevel">Batch Management</a>
                                    <div class="collapse show" id="batchmanagement-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{route('batch.create')}}" class="nav-link ">Add New Batch</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('batch.index')}}" class="nav-link ">View Batches</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('subject.index')}}" class="nav-link ">
                                        Subjects Management</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('calendar.index')}}">
                            <i class="ni ni-calendar-grid-58 text-primary"></i>
                            <span class="nav-link-text">Calendar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-maps" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-maps">
                            <i class="ni ni-settings-gear-65 text-danger"></i>
                            <span class="nav-link-text">Settings</span>
                        </a>
                        <div class="collapse" id="navbar-maps">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="/roles" class="nav-link">Roles & Permissions</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="ni ni-button-power text-gray-dark"></i>
                            <span class="nav-link-text">Logout</span>

                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>