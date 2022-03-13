@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-12">
            @include('partials.status')
        </div>

<div class="col-xl-12">
    <div class="card">
        <div class="card-header bg-transparent">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="text-uppercase text-muted ls-1 mb-1">Attendance</h6>
                    <h5 class="h3 mb-0">Today Attendance</h5>
                </div>
            </div>
        </div>
        <div class="card-body" >
            <!-- Chart -->
            <div class="chart">
                <canvas id="chart-bars"  class="chart-canvas"></canvas>
            </div>
        </div>
    </div>
</div>

</div>


<script>
    var ctx = document.getElementById('chart-bars').getContext('2d');
    var myChart = new Chart(ctx, {
        responsive:true,
        maintainAspectRatio: false,
        type: 'bar',
        data: {
            labels: {!! json_encode($courses) !!},
            datasets: [{
                barPercentage: 0.5,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
                label: 'Attendance',
                data: {!! json_encode($counts) !!},
                backgroundColor: [
                    '#fb6340',
                    '#fb6340',
                    '#fb6340',
                    '#fb6340',
                ],
                borderColor: [
                    '#fb6340',
                    '#fb6340',
                    '#fb6340',
                    '#fb6340',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
			maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    }
                }],
                xAxes: [{
            gridLines: {
                offsetGridLines: true
            }
        }]
            }
        }
    });
    </script>




<!-- Footer -->
@include('layouts.footers.auth')
</div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
@push('js')
{{-- <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script> --}}
@endpush