@extends('layout.app')
@section('konten-title','Login')

@section('auth')
    <div class="bg-primary">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center min-vh-100">
                <div class="col-md-5">
                    <div class="card shadow-lg p-3 rounded">
                        <div class="text-center mt-3">
                            <h1>Login</h1>
                        </div>
                        <div class="card-body text-start">
                            @if (session('gagal'))
                                <div class="alert alert-danger">
                                    {{ session('gagal') }}
                                </div>
                            @endif
                                    <form action="{{ route('login.post') }}" method="post">
                                        @csrf
                                            <label for="">Email</label>
                                            <input type="text" name="email" class="form-control mb-2">
                                            <label for="">Password</label>
                                            <input type="password" name="password" class="form-control mb-2">
                                            <div class="row mb-0">
                                                <div class="col-md-6 offset-md-6 text-start">

                                                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                                                    <a href="{{ route('register') }}" class="btn btn-success mt-2">Register</a>
                                                </div>
                                            </div>
                                    </form>
                                    
                                </div>
                            
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection