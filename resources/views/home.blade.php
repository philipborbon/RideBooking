@extends('layouts.home')

@section('content')

<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">
<!--             <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body"> -->
                    <h1>Dashboard</h1>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row mt-1">
                        <div class="col-xs-6 col-md-6">
                            <div class="row">
                                <div class="col">
                                    <a href="/users" class="btn btn-primary btn-lg p-3 mt-2 btn-block" role="button">Users</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <a href="/wallets" class="btn btn-success btn-lg p-3 mt-2 btn-block" role="button">Wallets</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6">
                            <div class="row">
                                <div class="col">
                                <a href="/vehicles" class="btn btn-success btn-lg p-3 mt-2 btn-block" role="button">Vehicles</a>
                                </div>
                                <div class="col-md-6">
                                <a href="/routes" class="btn btn-success btn-lg p-3 mt-2 btn-block" role="button">Routes</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                <a href="/passengertypes" class="btn btn-success btn-lg p-3 mt-2 btn-block" role="button">Passenger Types</a>
                                </div>
                                <div class="col">
                                <a href="/rideschedules" class="btn btn-success btn-lg p-3 mt-2 btn-block" role="button">Schedules</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-xs-6 col-md-6">
                            <div class="row">
                                <div class="col">
                                <a href="/topups" class="btn btn-primary btn-lg p-3 mt-2 btn-block" role="button">Topups</a>
                                </div>
                                <div class="col-md-6">
                                <a href="/redeems" class="btn btn-primary btn-lg p-3 mt-2 btn-block" role="button">Redeems</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                <a href="/collections" class="btn btn-success btn-lg p-3 mt-2 btn-block" role="button">Collections</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6 col-md-6">
                            <div class="row mt-1">
                                <div class="col">
                                    <a href="/bookings" class="btn btn-primary btn-lg p-3 mt-2 btn-block" role="button">Bookings</a>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col">
                                <a href="/transactions" class="btn btn-primary btn-lg p-3 mt-2 btn-block" role="button">Transactions</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                <a href="/reports" class="btn btn-primary btn-lg p-3 mt-2 btn-block" role="button">Reports</a>
                                </div>
                            </div>
                        </div>
                    </div>

<!--                 </div>
            </div>
        </div> -->
    </div>
</div>
@endsection
