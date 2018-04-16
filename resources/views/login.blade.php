@extends('main-layout')
@section('title', 'Login')
@section('content')
  <h1>Login</h1>
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
    </div>
  @endif
  <form action="/vbdb/login" method="post">
    {{csrf_field()}}
    <div class='form-group'>
      <label for='username'>Username</label>
      @if (old('username', null) != null)
        <input type='text' placeholder='Enter username' name='username' value='{{old("username")}}'>
      @else
        <input type='text' placeholder='Enter username' name='username'>
      @endif
    </div>
    <div class='form-group'>
      <label for='password'>Password</label>
      <input type='password' placeholder='Enter password' name='password'>
    </div>
    <button type='submit' class='button btn-primary'>Submit</button>
  </form>
@endsection
