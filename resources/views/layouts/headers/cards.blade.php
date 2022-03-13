<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Today Attendance</h5>
                                    <span class="h2 font-weight-bold mb-0">{{App\Attendance::returnTodayMaleAttendanceCount()+App\Attendance::returnTodayFemaleAttendanceCount()}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-success mr-1">{{App\Attendance::returnTodayMaleAttendanceCount()}}</span>
                                <span class="text-nowrap">Male</span>
                                <br>
                                <span class="text-info mr-1"><i class="fas fa-venus mr-1"></i>{{App\Attendance::returnTodayFemaleAttendanceCount()}}</span>
                                <span class="text-nowrap">Female</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Academic Staff</h5>
                                    <span class="h2 font-weight-bold mb-0">{{App\Instructor::getInstructorCount()+App\Demonstrator::getDemonstratorCount()}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="fas fa-school"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-success mr-1">{{App\Instructor::getInstructorCount()}}</span>
                                <span class="text-nowrap">Instructor</span>
                                <br>
                                <span class="text-info mr-1">{{App\Demonstrator::getDemonstratorCount()}}</span>
                                <span class="text-nowrap">Demonstrator</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Dropout Warnings</h5>
                                    <span class="h2 font-weight-bold mb-0">{{App\Dropout::getDropoutsCount()+App\Dropout::getSuspenedCount()}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="fa fa-exclamation"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-success mr-1">{{App\Dropout::getDropoutsCount()}}</span>
                                <span class="text-nowrap">Warned</span>
                                <br>
                                <span class="text-info mr-1">{{App\Dropout::getSuspenedCount()}}</span>
                                <span class="text-nowrap">Suspended</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Holidays - {{Carbon\Carbon::now()->format('M'. ' ' .'Y')}}</h5>
                                    <span class="h2 font-weight-bold mb-0">{{App\Calendar::getCurrentMonthHolidays()}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="fas fa-coffee"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                            <span class="text-success mr-1">Next</span>
                            <span class="text-nowrap">{{count(App\Calendar::getCurrentUpcommingMonthHoliday()) > 0 ? App\Calendar::getCurrentUpcommingMonthHoliday()[0]['title'] : ''}}</span>
                                <br>
                                <span class="text-info mr-1">After</span>
                                <span class="text-nowrap">{{count(App\Calendar::getCurrentUpcommingMonthHoliday()) > 1 ? App\Calendar::getCurrentUpcommingMonthHoliday()[1]['title'] : ''}}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>