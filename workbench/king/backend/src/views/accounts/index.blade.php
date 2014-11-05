
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
            <th>Modified</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @define $i = 0
        @foreach($users as $user)
            @define $i = $i +1
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ HTML::mailto($user->email) }}</td>
            <td><span class="text-danger">{{ $user->getRole()->role }}<span></td>
            @define $url = url('/admin/account/active/user-' . $user->id)
            <td class="active-container">{{ $user->is_active ? '<span class="label label-success _cp" data-kingActive data-activeurl="' . $url . '">active</span>' : '<span class="label label-warning _cp" data-kingActive data-activeurl="' . $url . '">disable</span>'}}</td>
            <td>{{ King\Backend\_Common::changeDateTimeFormat($user->updated_at, 'd/m/Y') }}</td>
            <td class="_tc"><a href="{{ url('admin/accounts/' . $user->id . '/edit') }}" class="text-warning _td_i fa fa-edit"></a></td>
            <td class="_tc">
                {{ Form::open(array('url' => 'admin/accounts/' . $user->id, 'method' => 'DELETE')) }}
                    <button type="submit" class="_ff0" data-confirmation data-msg="Delete this account???"><i class="text-danger _td_i fa fa-trash"></i></button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="_fwfl">
    <a href="{{ url('admin/accounts/create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Add new account (<span class="text text-warning">{{ $total - 1 }}</span>) </a>
</div>
@show