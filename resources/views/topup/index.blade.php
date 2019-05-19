@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Top-Up's</h1>

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
        </tr>
      </thead>
      <tbody>
        @foreach($topups as $topup)
        <tr>
          <th scope="row">{{$topup->id}}</th>
          <td>{{$topup->wallet->user->getFullname()}}</td>
          <td>{{$topup->topupcode}}</td>
          <td>{{number_format($topup->amount, 2)}}</td>
          <td>
            @if( $topup->approved )
            Approved
            @else
            <form action="{{action('TopupController@approve', $topup['id'])}}" method="post">
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