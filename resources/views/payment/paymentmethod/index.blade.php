@extends('layouts.app', ['title' => __('Instructor Management')])

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
                            <h3 class="mb-0">{{ __('Scholarship') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('funds.create') }}"
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
                                <th scope="col">{{ __('Scholarship Name') }}</th>
                                <th scope="col">{{ __('Samurdi Requirement') }}</th>
                                <th scope="col">{{ __('80% Attendance Requirement') }}</th>
                                <th scope="col">{{ __('Other Criteria') }}</th>
                                <th scope="col">{{ __('Amount') }}</th>
                                <th scope="col">{{ __('Discription') }}</th>
                                <th scope="col">{{ __('Action') }}</th>                                   
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->fund_name }}</td>
                                <td>
                                    @if(($payment->samurdi) == 1)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                                <td>
                                @if(($payment->attendance) == 1)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                                <td>
                                @foreach(json_decode($payment->othercriteria) as $cirteria)
                                    <i class="fas fa-caret-right"></i>&nbsp;<span>{{$cirteria}}<br></span>
                                @endforeach
                                </td>
                                <td>Rs : {{$payment->amount}}</td>
                                <td>
                                    {{$payment->discription}}
                                </td>                               
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <form action="{{route('funds.destroy',$payment)}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a class="dropdown-item"
                                                    href="{{ route('funds.edit', $payment) }}">{{ __('Edit') }}</a>
                                                <button type="button" class="dropdown-item" onclick="confirmDelete()">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
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