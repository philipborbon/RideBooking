@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Redeems</h1>

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
          <th scope="col">From</th>
          <th scope="col">Code</th>
          <th scope="col">Amount</th>
          <th scope="col">Approved</th>
        </tr>
      </thead>
      <tbody>
        @foreach($redeems as $redeem)
        <tr>
          <th scope="row">{{$redeem->id}}</th>
          <td>{{$redeem->wallet->user->getFullname()}}</td>
          <td>{{$redeem->redeemcode}}</td>
          <td>Php {{number_format($redeem->amount, 2)}}</td>
          <td>
            @if( $redeem->approved )
            Approved
            @else
            <form action="{{action('RedeemController@approve', $redeem['id'])}}" method="post">
              {{csrf_field()}}
              <input name="_method" type="hidden" value="PATCH">
              <button class="btn btn-warning" type="submit">Approve</button>
            </form>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
</div>
@endsection