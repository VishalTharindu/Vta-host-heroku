@extends('layouts.app', ['title' => __('Training Institutes Management')])

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
                            <h3 class="mb-0">{{ __('Training Institutes') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('trainingInstitute.create') }}"
                                class="btn btn-sm btn-warning">{{ __('Add Training Institute') }}</a>
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
                                <th scope="col">{{ __('Company Name') }}</th>
                                <th scope="col">{{ __('Company Address') }}</th>
                                <th scope="col">{{ __('Company Phone No') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainingInstitutes as $trainingInstitute)
                            <tr>
                                <td>{{ $trainingInstitute->name }}</td>
                                <td>
                                    {{ $trainingInstitute->address }}
                                </td>
                                <td>{{ $trainingInstitute->phone_no }}</td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <form action="{{ route('trainingInstitute.destroy', $trainingInstitute) }}" method="post">
                                                @csrf
                                                @method('delete')

                                                <a class="dropdown-item"
                                                    href="{{ route('trainingInstitute.edit', $trainingInstitute) }}">{{ __('Edit') }}</a>
                                                <button type="button" class="dropdown-item"
                                                    onclick="confirm('{{ __("Are you sure you want to delete this Institute?") }}') ? this.parentElement.submit() : ''">
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
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection