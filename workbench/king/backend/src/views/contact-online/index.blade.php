
@section('title')
List contact online
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">List contacts</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">List contact online</h4>
@show

@section('body')

<div class="_fwfl _mt5 _mb5">

    <div class="btn-group _mb5">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            @define $filterName = $filter->name
            @define $filterId = $filter->id
            @define $allTxt = 'All'
            Contact type: <span class="label label-info filter-what">{{ $filterName }}</span>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-scroll" role="menu" data-filter data-filter-class="filter-what">
            <li>
                <a class="_fwfl" href="{{ !$filterId ? '#' :   url('admin/contact-online') }}" @if( ! $filterId) style="background-color:#f5f5f5" @endif>
                   <span class="_fl">{{ $allTxt }}</span>
                    @if( ! $filterId)
                    <i class="fa fa-check _fr _fs11 _tb _mt5"></i>
                    @endif
                </a>
            </li>
            @foreach($contactType as $type)
            <li>
                <a class="_fwfl" href="{{ url('admin/contact-online/filter/' . $type->id) }}" @if($type->id === $filterId) style="background-color:#f5f5f5" @endif>
                   <span class="_fl">{{ $type->name }}</span>
                    @if($type->id === $filterId)
                    <i class="fa fa-check _fr _fs11 _tb _mt5"></i>
                    @endif
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <a href="{{ url('admin/contact-online/create') }}" class="btn btn-default _fr"><i class="fa fa-plus"></i> Add new (<span class="text text-warning">{{ $total }}</span>) </a>
</div>

<table class="table table-bordered table-hover table-striped table-responsive">
    <thead>
        <tr>
            <th><input type="checkbox" class="checkbox-top" data-checkall data-checkallclass="check-all"/></th>
            <th>#</th>
            <th>Contact type</th>
            <th>Name</th>
            <th>contact</th>
            <th>Is active</th>
            <th>Modified</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @define $i = 0;
        @foreach($online as $one)
        @define $i += 1
            @define $class = ! $one->getContactType()->is_active ? 'warning' : ''
        <tr class="{{ $class }}">
            <td><input type="checkbox" class="check-all" id="check-{{ $one->id }}" data-id="{{ $one->id }}"/></td>
            <td>{{ $i }}</td>
            <td>
                {{ $one->getContactType()->name }}
                @if(! $one->getContactType()->is_active) <sup class="text text-danger" title="Disable or deleted">(*)</sup>@endif
            </td>
            <td>{{ $one->name }}</td>
            <td>{{ $one->contact }}</td>
            @define $url = url('/admin/ajax/active/contactOnline-' . $one->id)
            <td class="active-container">{{ $one->is_active ? '<span class="label label-success _cp" data-kingActive data-activeurl="' . $url . '">active</span>' : '<span class="label label-danger _cp" data-kingActive data-activeurl="' . $url . '">disable</span>'}}</td>
            <td>{{ King\Backend\_Common::changeDatetimeFormat($one->updated_at, 'd/m/Y') }}</td>
            <td class="_tc"><a href="{{ url('admin/contact-online/' . $one->id . '/edit') }}" class="text-warning _td_i fa fa-edit"></a></td>
            <td class="_tc">
                {{ Form::open(array('url' => 'admin/contact-online/' . $one->id, 'method' => 'DELETE')) }}
                    <button type="submit" class="_ff0" data-confirmation data-msg="Delete this this???"><i class="text-danger _td_i fa fa-trash"></i></button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="_fwfl">
    <a href="{{ url('admin/contact-online/create') }}" class="btn btn-default _fl"><i class="fa fa-plus"></i> Add new (<span class="text text-warning">{{ $total }}</span>) </a>
    <a href="{{ url('admin/contact-online/delete-all') }}" class="btn btn-danger _fr"><i class="fa fa-trash"></i> Delete all </a>
</div>

<div class="_fwfl">
    <div class="_fr">
        {{ $online->links() }}
    </div>
</div>
@show