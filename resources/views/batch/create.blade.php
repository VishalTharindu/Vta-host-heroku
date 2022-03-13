@extends('layouts.app', ['title' => __('Batch Management')])

@section('content')
@include('users.partials.header', ['title' => __('Add New Batch')])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Batch Management') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('batch.index') }}"
                                class="btn btn-sm btn-warning">{{ __('View All Batches') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('batch.store') }}" autocomplete="off">
                        @csrf

                        <h6 class="heading-small text-muted mb-4">{{ __('Batch information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('year') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-year">{{ __('Year') }}</label>
                                <input type="text" name="year" id="input-year"
                                    class="form-control form-control-alternative{{ $errors->has('year') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Year') }}" value="{{ old('year') }}" required autofocus>

                                @if ($errors->has('year'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('year') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('batch') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-batch">{{ __('Batch') }}</label>
                                <select name="batch" id="input-batch"
                                    class="form-control form-control-alternative{{ $errors->has('batch') ? ' is-invalid' : '' }}"
                                    value="{{ old('batch') }}" required autofocus>
                                    <option value="1">1st Batch</option>
                                    <option value="2">2nd Batch</option>
                                </select>
                                @if ($errors->has('batch'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('batch') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Add Batch') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection