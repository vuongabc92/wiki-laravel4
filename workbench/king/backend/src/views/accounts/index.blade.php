
@section('title')
List accounts
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">accounts</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">List accounts</h4>
@show

@section('body')
<table class="table table-bordered table-hover table-striped table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Is active</th>
            <th>Created</th>
            <th>Modified</th>
        </tr>
    </thead>
    <tbody>
        @define $i = 0
        @foreach($users as $user)
            @define $i = $i +1
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->is_active ? '<span class="label label-success label-xs">publish</span>' : '<span class="label label-warning">disable</span>'}}</td>
            <td>{{ $user->created_at }}</td>
            <td>{{ $user->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@show