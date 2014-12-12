
@section('title')
List category root
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">List categories</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">List category root</h4>
@show

@section('body')
<table class="table table-bordered table-hover table-striped table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Is active</th>
            <th>Modified</th>
            <th style="width: 142px">Action</th>
        </tr>
    </thead>
    <tbody>
        @define $i = 0
        @foreach($categories as $category)
            @define $i = $i +1
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $category->name }}</td>
            @define $url = url('/admin/ajax/active/categoryRoot-' . $category->id)
            <td class="active-container">{{ $category->is_active ? '<span class="label label-success _cp" data-kingActive data-activeurl="' . $url . '">active</span>' : '<span class="label label-danger _cp" data-kingActive data-activeurl="' . $url . '">disable</span>'}}</td>
            <td>{{ King\Backend\_Common::changeDatetimeFormat($category->updated_at, 'd/m/Y') }}</td>
            <td>
                <div class="_w50 _fl">
                    <a class="btn btn-default btn-xs" href="{{ url('admin/category-root/' . $category->id . '/edit') }}"><i class="_td_i fa fa-edit"></i> Edit</a>
                </div>
                <div class="_w50 _fr">
                    {{ Form::open(array('url' => 'admin/category-root/' . $category->id, 'method' => 'DELETE')) }}
                        <button type="submit" class="btn btn-danger btn-xs" data-confirmation data-msg="Delete this this???"><i class="text-danger _td_i fa fa-trash _tw"></i> Delete</button>
                    {{ Form::close() }}
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="_fwfl">
    <a href="{{ url('admin/category-root/create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Add new (<span class="text text-warning">{{ $total }}</span>) </a>
</div>

<div class="_fwfl">
    <div class="_fr">
        {{ $categories->links() }}
    </div>
</div>

@show