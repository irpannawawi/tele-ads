@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fas fa-user-shield"></i> Administartor</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-bordered datatable">
                                <thead >
                                    <tr>
                                        <th class="bg-dark text-center text-white">ID</th>
                                        <th class="bg-dark text-center text-white">Name</th>
                                        <th class="bg-dark text-center text-white">Email</th>
                                        <th class="bg-dark text-center text-white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td class="text-end">
                                                <a href="{{route('administrator.edit', $user->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                                <a href="{{route('administrator.destroy', $user->id)}}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection