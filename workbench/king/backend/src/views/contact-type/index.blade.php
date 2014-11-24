
@section('title')
List contact type
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">List contact type</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">List contact type</h4>
@show

@section('body')
<div class="_fwfl _mb5">
    <a href="{{ url('admin/contact-type/create') }}" class="btn btn-default _mb5 _fr"><i class="fa fa-plus"></i> Add new (<span class="text text-warning">{{ $total }}</span>) </a>
</div>

<table class="table table-bordered table-hover table-striped table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Is active</th>
            <th>Modified</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @define $i = 0
        @foreach($types as $type)
            @define $i = $i +1
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $type->name }}</td>
            @define $url = url('/admin/ajax/active/contactType-' . $type->id)
            <td class="active-container">{{ $type->is_active ? '<span class="label label-success _cp" data-kingActive data-activeurl="' . $url . '">active</span>' : '<span class="label label-danger _cp" data-kingActive data-activeurl="' . $url . '">disable</span>'}}</td>
            <td>{{ King\Backend\_Common::changeDatetimeFormat($type->updated_at, 'd/m/Y') }}</td>
            <td class="_tc"><a href="{{ url('admin/contact-type/' . $type->id . '/edit') }}" class="text-warning _td_i fa fa-edit"></a></td>
            <td class="_tc">
                {{ Form::open(array('url' => 'admin/contact-type/' . $type->id, 'method' => 'DELETE')) }}
                    <button type="submit" class="_ff0" data-confirmation data-msg="Delete this this???"><i class="text-danger _td_i fa fa-trash"></i></button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="_fwfl">
    <a href="{{ url('admin/contact-type/create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Add new (<span class="text text-warning">{{ $total }}</span>) </a>
</div>

<div class="_fwfl">
    <div class="_fr">
        {{ $types->links() }}
    </div>
</div>

@show