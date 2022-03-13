@extends('layouts.app', ['title' => __('Course Management')])

@section('content')
@include('layouts.headers.cards')
<link rel="stylesheet" href="{{ asset('argon') }}/vendor/fullcalendar/dist/fullcalendar.min.css">
<div class="my-5"></div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Main content -->

<!-- Page content -->
<div class="my-5"></div>

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0">{{ __('Calendar') }}</h3>
                        </div>
                        <div class="col-lg-6 mt-4 text-lg-right">
                            <h6 class="fullcalendar-title h4 text-primary d-inline-block mb-0"></h6>
                            <br>
                            <a href="#" class="fullcalendar-btn-prev btn btn-sm btn-neutral">
                                <i class="fas fa-angle-left"></i>
                            </a>
                            <a href="#" class="fullcalendar-btn-next btn btn-sm btn-neutral">
                                <i class="fas fa-angle-right"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="month">Month</a>
                            <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicWeek">Week</a>
                            <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicDay">Day</a>
                        </div>

                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>
                <!-- Card body -->
                <div class="card-body loadme">
                    <div calss="calendar" data-toggle="calendar" id="calendar"></div>
                </div>
            </div>
            <!-- Modal - Add new event -->
            <!--* Modal header *-->
            <!--* Modal body *-->
            <!--* Modal footer *-->
            <!--* Modal init *-->
            <div class="modal fade" id="new-event" tabindex="-1" role="dialog" aria-labelledby="new-event-label"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-secondary" role="document">
                    <div class="modal-content">
                        <!-- Modal body -->
                        <div class="modal-body">
                            <form class="new-event--form">
                                <div class="form-group">
                                    <label class="form-control-label">Vacation title</label>
                                    <input type="text" class="form-control form-control-alternative new-event--title"
                                        placeholder="Vacation Title">
                                </div>
                                <div class="form-group mb-0">
                                    <label class="form-control-label d-block mb-3">Status color</label>
                                    <div class="btn-group btn-group-toggle btn-group-colors event-tag"
                                        data-toggle="buttons">
                                        <label class="btn bg-info active"><input type="radio" name="event-tag"
                                                value="bg-info" autocomplete="off" checked></label>
                                        <label class="btn bg-warning"><input type="radio" name="event-tag"
                                                value="bg-warning" autocomplete="off"></label>
                                        <label class="btn bg-danger"><input type="radio" name="event-tag"
                                                value="bg-danger" autocomplete="off"></label>
                                        <label class="btn bg-success"><input type="radio" name="event-tag"
                                                value="bg-success" autocomplete="off"></label>
                                        <label class="btn bg-default"><input type="radio" name="event-tag"
                                                value="bg-default" autocomplete="off"></label>
                                        <label class="btn bg-primary"><input type="radio" name="event-tag"
                                                value="bg-primary" autocomplete="off"></label>
                                    </div>
                                </div>
                                <input type="hidden" class="new-event--start" />
                                <input type="hidden" class="new-event--end" />
                            </form>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary new-event--add">Add event</button>
                            <button type="button" class="btn btn-link ml-auto" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal - Edit event -->
            <!--* Modal body *-->
            <!--* Modal footer *-->
            <!--* Modal init *-->
            <div class="modal fade" id="edit-event" tabindex="-1" role="dialog" aria-labelledby="edit-event-label"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-secondary" role="document">
                    <div class="modal-content">
                        <!-- Modal body -->
                        <div class="modal-body">
                            <form class="edit-event--form">
                                <div class="form-group">
                                    <label class="form-control-label">Holiday title</label>
                                    <input type="text" class="form-control form-control-alternative edit-event--title"
                                        placeholder="Holiday Title">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label d-block mb-3">Status color</label>
                                    <div class="btn-group btn-group-toggle btn-group-colors event-tag mb-0"
                                        data-toggle="buttons">
                                        <label class="btn bg-info active"><input type="radio" name="event-tag"
                                                value="bg-info" autocomplete="off" checked></label>
                                        <label class="btn bg-warning"><input type="radio" name="event-tag"
                                                value="bg-warning" autocomplete="off"></label>
                                        <label class="btn bg-danger"><input type="radio" name="event-tag"
                                                value="bg-danger" autocomplete="off"></label>
                                        <label class="btn bg-success"><input type="radio" name="event-tag"
                                                value="bg-success" autocomplete="off"></label>
                                        <label class="btn bg-default"><input type="radio" name="event-tag"
                                                value="bg-default" autocomplete="off"></label>
                                        <label class="btn bg-primary"><input type="radio" name="event-tag"
                                                value="bg-primary" autocomplete="off"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Description</label>
                                    <textarea
                                        class="form-control form-control-alternative edit-event--description textarea-autosize"
                                        placeholder="Holiday Desctiption"></textarea>
                                    <i class="form-group--bar"></i>
                                </div>
                                <input type="hidden" class="edit-event--id">
                            </form>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button class="btn btn-primary" data-calendar="update">Update</button>
                            <button class="btn btn-danger" data-calendar="delete">Delete</button>
                            <button class="btn btn-link ml-auto" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        'use strict';
        var Fullcalendar = (function() {
            var $calendar = $('[data-toggle="calendar"]');

            function init($this) {
                var events = {!!json_encode($events->toArray(), JSON_HEX_TAG) !!},
                    options = {
                        header: {
                            right: '',
                            center: '',
                            left: ''
                        },
                        buttonIcons: {
                            prev: 'calendar--prev',
                            next: 'calendar--next'
                        },
                        theme: false,
                        selectable: true,
                        selectHelper: true,
                        editable: false,
                        events: events,

                        dayClick: function(date) {
                            var isoDate = moment(date).toISOString();
                            $('#new-event').modal('show');
                            $('.new-event--title').val('');
                            $('.new-event--start').val(isoDate);
                            $('.new-event--end').val(isoDate);
                        },
                        viewRender: function(view) {
                            var calendarDate = $this.fullCalendar('getDate');
                            var calendarMonth = calendarDate.month();

                            $('.fullcalendar-title').html(view.title);
                        },
                        eventClick: function(event, element) {
                            $('#edit-event input[value=' + event.className + ']').prop('checked', true);
                            $('#edit-event').modal('show');
                            $('.edit-event--id').val(event.id);
                            $('.edit-event--title').val(event.title);
                            $('.edit-event--description').val(event.description);
                        }
                    };

                $this.fullCalendar(options);

                $('body').on('click', '.new-event--add', function() {
                    var eventTitle = $('.new-event--title').val();
                    if (eventTitle != '') {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "/calendar",
                            method: "POST",
                            data: {
                                title: eventTitle,
                                start: $('.new-event--start').val(),
                                end: $('.new-event--end').val(),
                                allDay: true,
                                className: $('.event-tag input:checked').val()
                            },
                            success: function() {
                                $.alert({
                                    title: 'Holiday added',
                                    icon: 'fa fa-check',
                                    theme: 'material',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'green',
                                    content: 'Holiday is  saved successfully.',
                                    onClose: () => location.reload(),
                                })
                               
                            }
                        })
                        $('.new-event--form')[0].reset();
                        $('.new-event--title').closest('.form-group').removeClass('has-danger');
                        $('#new-event').modal('hide');
                    } else {
                        $('.new-event--title').closest('.form-group').addClass('has-danger');
                        $('.new-event--title').focus();
                    }
                });

                //Update/Delete an Event
                $('body').on('click', '[data-calendar]', function() {
                    var calendarAction = $(this).data('calendar');
                    var currentId = $('.edit-event--id').val();
                    var currentTitle = $('.edit-event--title').val();
                    var currentDesc = $('.edit-event--description').val();
                    var currentClass = $('#edit-event .event-tag input:checked').val();
                    var currentEvent = $this.fullCalendar('clientEvents', currentId);

                    //Update
                    if (calendarAction === 'update') {
                        if (currentTitle != '') {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: "/calendar/" + currentId,
                                method: "PUT",
                                data: {
                                    title: currentTitle,
                                    description: currentDesc,
                                    className: currentClass
                                },
                                success: function() {
                                $.alert({
                                    title: 'Holiday Updated',
                                    icon: 'fa fa-check',
                                    theme: 'material',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'green',
                                    content: 'Holiday is updated successfully.',
                                    onClose: () => location.reload(),
                                })
                               
                            }
                            })

                            console.log(currentClass);
                            $this.fullCalendar('updateEvent', currentEvent[0]);
                            $('#edit-event').modal('hide');
                        } else {
                            $('.edit-event--title').closest('.form-group').addClass('has-error');
                            $('.edit-event--title').focus();
                        }
                    }

                    //Delete
                    if (calendarAction === 'delete') {
                        $('#edit-event').modal('hide');

                        setTimeout(function() {
                            $.confirm({
                                title: 'Delete!',
                                content: 'Are you sure you want to delete this?',
                                animation: 'zoom',
                                closeAnimation: 'scale',
                                icon: 'fa fa-trash-alt',
                                theme: 'material',
                                closeIcon: true,
                                type: 'red',
                                animateFromElement: false,
                                buttons: {
                                    confirm: function() {
                                        $.alert('Deleted');
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]'
                                                    ).attr('content')
                                            }
                                        });
                                        $.ajax({
                                            url: "/calendar/" + currentId,
                                            method: "DELETE",
                                        });
                                    },
                                    cancel: function() {
                                        $.alert('Canceled');
                                    }
                                },
                                onClose: () => location.reload(),
                            });
                        }, 200);
                    }
                });


                //Calendar views switch
                $('body').on('click', '[data-calendar-view]', function(e) {
                    e.preventDefault();

                    $('[data-calendar-view]').removeClass('active');
                    $(this).addClass('active');

                    var calendarView = $(this).attr('data-calendar-view');
                    $this.fullCalendar('changeView', calendarView);
                });


                //Calendar Next
                $('body').on('click', '.fullcalendar-btn-next', function(e) {
                    e.preventDefault();
                    $this.fullCalendar('next');
                });


                //Calendar Prev
                $('body').on('click', '.fullcalendar-btn-prev', function(e) {
                    e.preventDefault();
                    $this.fullCalendar('prev');
                });
            }
            // Init
            if ($calendar.length) {
                init($calendar);
            }

        })();
    </script>
    @include('layouts.footers.auth')
</div>

@endsection