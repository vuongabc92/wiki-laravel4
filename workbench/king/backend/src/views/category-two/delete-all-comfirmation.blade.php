@section('title')
    Delete all data confirmation
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/admin/category-one') }}">categories one</a></li>
<li class="active">delete confirmation</li>
@show

@section('pageinfo')
    <h4 class="admin-page-name">Delete all data confirmation</h4>
@show

@section('body')

<div class="_fwfl">

    <h3 class="_fwfl _fs17 text text-danger"> <i class="fa fa-warning"></i> Do you really want to delete all resources, so it can not be recovery ???</h3>
    {{ Form::open(array('url' => 'admin/category-two/delete-all', 'method' => 'DELETE', 'class' => '_fwfl _mt5')) }}
        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
        <a href="{{ url('admin/category-two') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> back</a>
    {{ Form::close() }}
</div>
@show