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
        <div class="m-1 text-right"><a href="{{action('WalletController@create')}}" class="btn btn-primary">Add Wallet</a></div>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">User</th>
              <th scope="col">Amount</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($wallets as $wallet)
            <tr>
              <th scope="row">{{$wallet->id}}</th>
              <td>{{$wallet->user->getFullname()}}</td>
              <td>Php {{number_format($wallet->amount, 2)}}</td>
              <td><a href="{{action('WalletController@edit', $wallet['id'])}}" class="btn btn-warning">Edit</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
</div>
@endsection