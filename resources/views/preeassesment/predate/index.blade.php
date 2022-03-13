@extends('layouts.app', ['title' => __('Examination Management')])

@section('content')
@include('layouts.headers.cards')
<div class="my-5"></div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Pre Assessment') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('preassesment.create') }}"
                                class="btn btn-sm btn-warning">{{ __('Add New') }}</a>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="datatable-basic">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Batch') }}</th>
                                <th scope="col">{{ __('Course') }}</th>
                                <th scope="col">{{ __('Pre Asses Date') }}</th>
                                <th scope="col">{{ __('Complete') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Action') }}</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($preassesment as $preasses)
                                @if($preasses->status != 1)

                                @php
                                $assessmentStatus = App\PreAssesment::dateComparision($preasses->id);
                                @endphp

                                <tr>
                                    <td>{{$preasses->batch->year . ' / ' . $preasses->batch->batch_no}}</td>                              
                                    <td>{{$preasses->course->course_name}}</td>
                                    <td>
                                        {{$preasses->date}}
                                    </td>
                                    <td>        
                                        @if($assessmentStatus == 'overdue')
                                            <div class="">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <a href="{{ route('preassesment.complete', ['id' => $preasses->id]) }}" class="btn-sm btn-primary">Complete</a>
                                                    </div>                                                   
                                                    <div class="col-md-4">
                                                        <a href="{{ route('preassesment.edit', ['id' => $preasses->id]) }}" class="btn-sm btn-warning">Reset</a></td>                                              
                                                    </div>
                                                </div>                                          
                                            </div>
                                            @else                                   
                                            <a href="{{ route('preassesment.complete', ['id' => $preasses->id]) }}" class="btn-sm btn-primary">Complete</a>                                          
                                        @endif  
                                    </td>
                                    <td>
                                        @if($assessmentStatus == 'today')
                                            <span class="text-success">Today</span>
                                        @elseif($assessmentStatus == 'overdue')
                                            <span class="text-danger">OverDue</span>
                                        @else
                                            <span class="text-success">{{$assessmentStatus}}</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <form action="{{route('preassesment.destroy', ['id' => $preasses->id])}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <a class="dropdown-item"
                                                        href="{{ route('preassesment.edit', ['id' => $preasses->id]) }}">{{ __('Edit') }}</a>
                                                    <button type="button" class="dropdown-item" onclick="confirmDelete()">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{-- {{ $courses->links() }} --}}
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete() {
            event.preventDefault();
            var form = event.target.form;
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
                        form.submit();
                    },
                    cancel: function() {
                        $.alert('Canceled');
                    }
                }
            });
        }
    </script>
    @include('layouts.footers.auth')
</div>
@endsection