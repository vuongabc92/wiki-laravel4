
@section('title')
List roles
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">roles</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">List roles</h4>
@show

@section('body')
<table class="table table-bordered table-hover table-striped table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Role</th>
            <th>Is active</th>
            <th>Modified</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @define $i = 0
        @foreach($roles as $role)
            @define $i = $i +1
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $role->role_name }}</td>
            <td>{{ $role->role }}</td>
            @define $url = url('/admin/roles/active/role-' . $role->id)
            <td>{{ $role->is_active ? '<span class="label label-success _cp" data-kingActive data-activeurl="' . $url . '">active</span>' : '<span class="label label-warning _cp" data-kingActive data-activeurl="' . $url . '">disable</span>'}}</td>
            <td>{{ King\Backend\_Common::changeDatetimeFormat($role->updated_at, 'd/m/Y') }}</td>
            <td><a href="{{ url('admin/roles/' . $role->id . '/edit') }}" class="text-warning _td_i fa fa-edit"></a></td>
            <td>
                {{ Form::open(array('url' => 'admin/roles/' . $role->id, 'method' => 'DELETE')) }}
                    <button type="submit" class="_ff0" data-confirmation data-msg="Delete this role???"><i class="text-danger _td_i fa fa-trash"></i></button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="_fwfl">
    <a href="{{ url('admin/roles/create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Add new role (<span class="text text-warning">{{ $total }}</span>) </a>
</div>
@show