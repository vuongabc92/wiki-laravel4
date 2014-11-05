
@section('title')
{{ trans('backend::main.accounts_index_title') }}
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> {{ trans('backend::main.layouts_master_dashboard') }}</a></li>
<li class="active">{{ trans('backend::main.accounts_index_acc') }}</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">{{ trans('backend::main.accounts_index_pagetitle') }}</h4>
@show

@section('body')
<table class="table table-bordered table-hover table-striped table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('backend::main.accounts_index_gridusername') }}</th>
            <th>{{ trans('backend::main.accounts_index_gridemail') }}</th>
            <th>{{ trans('backend::main.accounts_index_gridrole') }}</th>
            <th>{{ trans('backend::main.accounts_index_gridactive') }}</th>
            <th>{{ trans('backend::main.accounts_index_gridmodify') }}</th>
            <th>{{ trans('backend::main.accounts_index_gridedit') }}</th>
            <th>{{ trans('backend::main.accounts_index_griddelete') }}</th>
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
            <td class="active-container">{{ $user->is_active ? '<span class="label label-success _cp" data-kingActive data-activeurl="' . $url . '">active</span>' : '<span class="label label-danger _cp" data-kingActive data-activeurl="' . $url . '">disable</span>'}}</td>
            <td>{{ King\Backend\_Common::changeDateTimeFormat($user->updated_at, 'd/m/Y') }}</td>
            <td class="_tc"><a href="{{ url('admin/accounts/' . $user->id . '/edit') }}" class="text-warning _td_i fa fa-edit"></a></td>
            <td class="_tc">
                {{ Form::open(array('url' => 'admin/accounts/' . $user->id, 'method' => 'DELETE')) }}
                    <button type="submit" class="_ff0" data-confirmation data-msg="{{ trans('backend::alert.askfordelete') }}"><i class="text-danger _td_i fa fa-trash"></i></button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="_fwfl">
    <a href="{{ url('admin/accounts/create') }}" class="btn btn-default"><i class="fa fa-plus"></i> {{ trans('backend::main.add_new') }} (<span class="text text-warning">{{ $total - 1 }}</span>) </a>
</div>
@show