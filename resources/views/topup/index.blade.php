@extends('layouts.app')

@section('content')
<div class="container">
        @if (Session::has('message'))
          <div class="alert alert-info"><p>{{ Session::get('message') }}</p></div>
        @endif
        @if (Session::has('success'))
        <div class="alert alert-success">
          <p>{{ Session::get('success') }}</p>
        </div>
        @endif
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">From</th>
              <th scope="col">Code</th>
              <th scope="col">Amount</th>
              <th scope="col">Approved</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($topups as $topup)
            <tr>
              <th scope="row">{{$route->id}}</th>
              <td>{{$route->wallet->user->getFullname()}}</td>
              <td>{{$route->topupcode}}</td>
              <td>{{number_format($route->amount, 2)}}</td>
              <td>
                <form action="{{action('Topup@approve', $route['id'])}}" method="post">
                  {{csrf_field()}}
                  <input name="_method" type="hidden" value="PATCH">
                  <button class="btn btn-warning" type="submit">Approve</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
</div>
@endsection