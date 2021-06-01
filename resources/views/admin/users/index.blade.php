@extends('layouts.dashboard') 

@section('content')
<!-- begin::page header -->
<div class="page-header">
    <h3>System Users</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
    </nav>
</div>
<!-- end::page header -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-head">
                    <a
                        href="{{ route('admin.users.create') }}"
                        class="btn btn-primary btn-sm float-right"
                        ><i class="lni-plus mr-2"></i> Add User</a
                    >
                    <h4 class="card-title">Users</h4>
                </div>
                <div class="gaps-1x"></div>
                <table class="data-table table table-striped">
                    <thead>
                        <tr class="data-item data-head">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td>
                                <a
                                    href="{{ route('admin.users.show', $user->id) }}"
                                    class="btn btn-primary btn-sm btn-auto"
                                    >View</a
                                >
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
