
@section('title')
List category one
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">List categories</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">List category one</h4>
@show

@section('body')

<div class="_fwfl _mt5 _mb5">
    <div class="btn-group _mb5">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            Category root: <span>All</span>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-scroll" role="menu" style="max-height:500px;overflow-x:hidden">
            @foreach($categoryRoot as $root)
                <li><a href="javascript:void();">{{ $root->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>

<table class="table table-bordered table-hover table-striped table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Root</th>
            <th>Name</th>
            <th>Image</th>
            <th>Description</th>
            <th>Is active</th>
            <th>Modified</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @define $i = 0
        @foreach($categories as $category)
            @define $i = $i +1
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $category->getRoot()->name }}</td>
            <td><a href="{{ url('admin/category-one/' . $category->id) }}">{{ $category->name }}</a></td>
            <td>
                {{ empty($category->image) ||  ! is_file('uploads/images/category/' . $category->image) ? '<span class="text text-warning">NO IMAGE</span>' : '<a href="' . url('uploads/images/category/' . $category->image) . '">' . HTML::image('uploads/images/category/' . $category->image, $category->name, ['class' => 'img-thumbnail _fl post-upload-image']) . '</a>' }}
                @if( ! empty($category->image) && file_exists('uploads/images/category/' . $category->image))
                    {{ Form::open(array('url' => 'admin/category-one/delete-image/' . $category->id, 'method' => 'DELETE', 'class' => 'delete-image-frm')) }}
                        <button type="submit" class="btn btn-warning btn-xs" data-confirmation data-msg="Delete this image???"><i class="_td_i fa fa-trash"></i> delete</button>
                    {{ Form::close() }}
                @endif
            </td>
            <td>{{ substr($category->description, 0, 20) }}...</td>
            @define $url = url('/admin/ajax/active/categoryOne-' . $category->id)
            <td class="active-container">{{ $category->is_active ? '<span class="label label-success _cp" data-kingActive data-activeurl="' . $url . '">active</span>' : '<span class="label label-danger _cp" data-kingActive data-activeurl="' . $url . '">disable</span>'}}</td>
            <td>{{ King\Backend\_Common::changeDatetimeFormat($category->updated_at, 'd/m/Y') }}</td>
            <td class="_tc"><a href="{{ url('admin/category-one/' . $category->id . '/edit') }}" class="text-warning _td_i fa fa-edit"></a></td>
            <td class="_tc">
                {{ Form::open(array('url' => 'admin/category-one/' . $category->id, 'method' => 'DELETE')) }}
                    <button type="submit" class="_ff0" data-confirmation data-msg="Delete this this???"><i class="text-danger _td_i fa fa-trash"></i></button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="_fwfl">
    <a href="{{ url('admin/category-one/create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Add new (<span class="text text-warning">{{ $total }}</span>) </a>
</div>
@show