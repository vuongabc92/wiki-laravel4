
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
            Category root: <span class="label label-info filter-what">{{ $filter }}</span>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-scroll" role="menu" data-filter data-filter-class="filter-what">
            <li>
                @define $allTxt = 'All'
                <a class="_fwfl" href="{{ $filter === $allTxt ? '#' :   url('admin/category-one') }}" @if($allTxt === $filter) style="background-color:#f5f5f5" @endif>
                   <span class="_fl">{{ $allTxt }}</span>
                    @if($allTxt === $filter)
                        <i class="fa fa-check _fr _fs11 _tb _mt5"></i>
                    @endif
                </a>
            </li>
            @foreach($categoryRoot as $root)
                <li>
                    <a class="_fwfl" href="{{ url('admin/category-one/filter/root-' . $root->id) }}" @if($root->name === $filter) style="background-color:#f5f5f5" @endif>
                        <span class="_fl">{{ $root->name }}</span>
                        @if($root->name === $filter)
                            <i class="fa fa-check _fr _fs11 _tb _mt5"></i>
                        @endif
                    </a>
                </li>
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
            <td>{{ $category->order_number }}</td>
            <td>{{ $category->getRoot()->name }}</td>
            <td><a href="{{ url('admin/category-one/' . $category->id) }}">{{ $category->name }}</a></td>
            <td>
                @define $img = 'uploads/images/category/' . $category->image
                {{ empty($category->image) ||  ! is_file($img) ? '<span class="text text-warning">NO IMAGE</span>' : '<a href="' . url($img) . '" class="_fwfl">' . HTML::image($img, $category->name, ['class' => 'img-thumbnail _fl post-upload-image']) . '</a>' }}
                @if( ! empty($category->image) && file_exists($img))
                    {{ Form::open(array('url' => 'admin/category-one/delete-image/' . $category->id, 'method' => 'DELETE', 'class' => 'delete-image-frm')) }}
                        <button type="submit" class="btn btn-warning btn-xs" data-confirmation data-msg="Delete this image???"><i class="_td_i fa fa-trash"></i> delete</button>
                    {{ Form::close() }}
                @endif
            </td>
            <td>{{ substr($category->description, 0, 30) }}...</td>
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

<div class="_fwfl">
    <div class="_fr">
        {{ $categories->links() }}
    </div>
</div>
@show