@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Reports</h1>

    <div class="row mt-3">
        <div class="col-sm-4">
        <div class="card">
            <div class="card-header">Passenger Payment</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ action('ReportController@passengerDailyPayment') }}">Daily Payment</a></li>
                <li class="list-group-item"><a href="{{ action('ReportController@passengerMonthlyPayment') }}">Monthly Payment</a></li>
                <li class="list-group-item"><a href="{{ action('ReportController@passengerYearlyPayment') }}">Yearly Payment</a></li>
            </ul>
        </div>
        </div>

        <div class="col-sm-4">
        <div class="card">
            <div class="card-header">Driver Collection</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ action('ReportController@driverDailyCollection') }}">Daily Collection</a></li>
                <li class="list-group-item"><a href="{{ action('ReportController@driverMonthlyCollection') }}">Monthly Collection</a></li>
                <li class="list-group-item"><a href="{{ action('ReportController@driverYearlyCollection') }}">Yearly Collection</a></li>
            </ul>
        </div>
        </div>

        <div class="col-sm-4">
        <div class="card">
            <div class="card-header">Operator Boundary</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ action('ReportController@operatorDailyBoundary') }}">Daily Boundary</a></li>
                <li class="list-group-item"><a href="{{ action('ReportController@operatorMonthlyBoundary') }}">Monthly Boundary</a></li>
                <li class="list-group-item"><a href="{{ action('ReportController@operatorYearlyBoundary') }}">Yearly Boundary</a></li>
            </ul>
        </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-4">
        <div class="card">
            <div class="card-header">Vehicle Income</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ action('ReportController@vehicleDailyIncome') }}">Daily Income</a></li>
                <li class="list-group-item"><a href="{{ action('ReportController@vehicleMonthlyIncome') }}">Monthly Income</a></li>
                <li class="list-group-item"><a href="{{ action('ReportController@vehicleYearlyIncome') }}">Yearly Income</a></li>
            </ul>
        </div>
        </div>
    </div>

</div>
@endsection
