@extends('layouts.app')

@section('content')
<div class="container">
        <h1>Transactions</h1>

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
              <th scope="col">To</th>
              <th scope="col">Amount</th>
              <th scope="col">Type</th>
              <th scope="col">Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($transactions as $transaction)
            <tr>
              <th scope="row">{{$transaction->id}}</th>
              <td>{{$transaction->from->user->getFullname()}}</td>
              <td>
                @php 
                if ($transaction->to){
                  echo $transaction->to->user->getFullname();
                } else {
                  echo 'N/A';
                }
                @endphp
              </td>
              <td>{{number_format($transaction->amount, 2)}}</td>
              <td>{{$transaction->getType()}}</td>
              <td>{{$transaction->created_at->format('M d, Y H:i')}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
</div>
@endsection