@extends('layout.app')
@section('konten-title','Register')
    

@section('auth')
    <div class="bg-primary">

        <div class="container">
            <div class="d-flex justify-content-center align-items-center min-vh-100">
                <div class="col-md-5">
                    <div class="card shadow-lg p-3 rounded">
                        <div class="text-center mt-3">
                            <h1>Register</h1>
                        </div>
                        <div class="card-body text-start">
                            <form action="{{ route('register.post') }}" method="post">
                                @csrf
                                <label for="">Username</label>
                                <input type="text" name="name" class="form-control mb-2">
                                <label for="">Email</label>
                                <input type="text" name="email" class="form-control mb-2">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control mb-2">
                                <label for="">Role</label>
                                <select name="type" id="" class="form-select">
                                    <option value="0">User</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Manager</option>
                                </select>
                                <button class="btn btn-primary mt-2">Submit</button>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection