@extends('layouts.app')
@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Please check below errors!</strong><br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif           

            <div class="card">
                <div class="card-header">
                    <h4>Add User
                        <a href="{{ url(route('list_users')) }}" class="btn btn-primary float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ url(route('save_user_details')) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" value="{{old('name')}}" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" value="{{old('email')}}" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Profile Image</label>
                            <input type="file" name="profile_image" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Profile Headline</label>
                            <input type="text" name="headline" class="form-control" value="{{old('headline')}}" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Skills Summary</label>
                            <textarea id="message" name ="skill_summary" class="form-control">{{old('skill_summary') }}</textarea>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="">Currency</label>
                            <select class="form-select" aria-label="Default select example" name="currency_id">
                                <option aria-label="Disabled select example" disabled>Select Currency</option>
                                    @isset($currencies)
                                        @foreach ($currencies as $cur)
                                            <option value="{{$cur->id}}">{{$cur->symbol}} {{$cur->code}} {{$cur->title}}</option>
                                        @endforeach                                            
                                    @endisset
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="">Hourly Rate</label>
                            <input type="number" name="hourly_rate" class="form-control" value="{{old('hourly_rate')}}" />
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection