@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>

    @if (Session::has('message'))
      <div class="alert alert-info"><p>{{ Session::get('message') }}</p></div>
    @endif
    @if (Session::has('success'))
    <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
    </div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-danger">
      <p>{{ Session::get('error') }}</p>
    </div>
    @endif
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Vehicle</th>
          <th scope="col">Date</th>
          <th scope="col">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($reports as $report)
        <tr>
          <th scope="row">{{$report->id}}</th>
          <td>{{$report->description}} (Cab #: {{$report->cabnumber}})</div>
          </td>
          <td>{{$report->date}}</td>
          <td>Php {{number_format($report->amount, 2)}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
</div>
@endsection