@extends('layouts.dashboard') 

@section('content')
<!-- begin::page header -->
<div class="page-header">
    <h3>System Users</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
</div>
<!-- end::page header -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-head">
                    <h4 class="card-title">Create User</h4>
                </div>
                <div class="gaps-1x"></div>
                <form action="{{ route('admin.users.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Name</label>
                        <input
                            type="text"
                            class="form-control"
                            required
                            name="name"
                            placeholder="Name"
                        />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input
                            type="email"
                            class="form-control"
                            required
                            name="email"
                            placeholder="Email"
                        />
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input
                            type="text"
                            class="form-control"
                            required
                            placeholder="Phone Number"
                            name="phone_number"
                        />
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary btn-auto">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
