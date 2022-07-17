@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Users List
                        <a href="{{ url(route('create_users')) }}" class="btn btn-primary float-end">+ User</a>
                    </h4>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Profile</th>
                                <th>Hourly Rate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                            <tr>
                                <td>{{ $member->id }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->headline }}</td>
                                <td>{{ $member->getCurrency->symbol }} {{ number_format($member->hourly_rate, 2) }}</td>
                                <td>
                                    <a href="{{ route('view_user_details',$member->id) }}" class="btn btn-primary btn-sm">Details</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $members->links() }}
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection