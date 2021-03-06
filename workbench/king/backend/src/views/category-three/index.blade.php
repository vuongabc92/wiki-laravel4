
@section('title')
List category three
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">List categories</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">List category three</h4>
@show

@section('body')

<div class="_fwfl _mt5 _mb5">
    <div class="btn-group _mb5">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            @define $filterRootId = $filterRoot->id
            Category root: <span class="label label-info filter-root-what">{{ $filterRoot->name }}</span>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-scroll" role="menu" data-filter data-filter-class="filter-root-what">
            <li>
                <a class="_fwfl" href="{{ !$filterRootId ? '#' :   url('admin/category-three') }}" @if(!$filterRootId) style="background-color:#f5f5f5" @endif>
                   <span class="_fl">All</span>
                    @if(!$filterRootId)
                        <i class="fa fa-check _fr _fs11 _tb _mt5"></i>
                    @endif
                </a>
            </li>
            @foreach($categoryRoot as $root)
                <li>
                    <a class="_fwfl" href="{{ url('admin/category-three/filter-category-root/' . $root->id) }}" @if($root->id === $filterRootId) style="background-color:#f5f5f5" @endif>
                        <span class="_fl">{{ $root->name }}</span>
                        @if($root->id === $filterRootId)
                            <i class="fa fa-check _fr _fs11 _tb _mt5"></i>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="btn-group _mb5">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            @define $filterOneId = $filterOne->id
            Category one: <span class="label label-info filter-one-what">{{ $filterOne->name }}</span>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-scroll" role="menu" data-filter data-filter-class="filter-one-what">
            <li>
                <a class="_fwfl" href="{{ !$filterOneId ? '#' :   url('admin/category-three') }}" @if(!$filterOneId) style="background-color:#f5f5f5" @endif>
                   <span class="_fl">All</span>
                    @if(!$filterOneId)
                        <i class="fa fa-check _fr _fs11 _tb _mt5"></i>
                    @endif
                </a>
            </li>
            @foreach($categoryOne as $one)
                <li>
                    @define $filterOneUrl = $filterOneId ? url('admin/category-three/filter-category-one-and-root/' . $filterRoot->id . '/' . $one->id) : url('admin/category-three/filter-category-one/' . $one->id)
                    <a class="_fwfl" href="{{ $filterOneUrl }}" @if($one->id === $filterOneId) style="background-color:#f5f5f5" @endif>
                        <span class="_fl">{{ $one->name }}</span>
                        @if($one->id === $filterOneId)
                            <i class="fa fa-check _fr _fs11 _tb _mt5"></i>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="btn-group _mb5">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            @define $filterTwoId = $filterTwo->id
            Category two: <span class="label label-info filter-one-what">{{ $filterTwo->name }}</span>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-scroll" role="menu" data-filter data-filter-class="filter-one-what">
            <li>
                <a class="_fwfl" href="{{ !$filterTwoId ? '#' :   url('admin/category-three') }}" @if(!$filterTwoId) style="background-color:#f5f5f5" @endif>
                   <span class="_fl">All</span>
                    @if(!$filterTwoId)
                        <i class="fa fa-check _fr _fs11 _tb _mt5"></i>
                    @endif
                </a>
            </li>

            @foreach($categoryTwo as $two)
                <li>
                    @define $filterTwoUrl = url('admin/category-three/filter-category-two/' . $two->id)
                    @if($filterRootId && $filterOneId)
                         @define $filterTwoUrl = url('admin/category-three/filter-category-root-one-two/' . $filterRoot->id . '/' . $filterOne->id . '/' . $two->id)
                    @endif
                    <a class="_fwfl" href="{{ $filterTwoUrl }}" @if($two->id === $filterTwoId) style="background-color:#f5f5f5" @endif>
                        <span class="_fl">{{ $two->name }}</span>
                        @if($two->id === $filterTwoId)
                            <i class="fa fa-check _fr _fs11 _tb _mt5"></i>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <a href="{{ url('admin/category-three/create') }}" class="btn btn-default _fr"><i class="fa fa-plus"></i> Add new (<span class="text text-warning">{{ $total }}</span>) </a>
</div>

<table class="table table-bordered table-hover table-striped table-responsive">
    <thead>
        <tr>
            <th><input type="checkbox" class="checkbox-top" data-checkall data-checkallclass="check-all"/></th>
            <th>#</th>
            <th>Root</th>
            <th>Category one</th>
            <th>Category two</th>
            <th>Name</th>
            <th>Image</th>
            <!--<th>Description</th>-->
            <th>Is active</th>
            <th>Modified</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
            @define $class = ! $category->getRoot()->is_active || ! $category->getCategoryOne()->is_active || ! $category->getCategoryTwo()->is_active ? 'warning' : ''
        <tr class="{{ $class }}">
            <td><input type="checkbox" class="check-all" id="check-{{ $category->id }}" data-id="{{ $category->id }}"/></td>
            <td>{{ $category->order_number }}</td>
            <td>
                {{ $category->getRoot()->name }}
                @if(! $category->getRoot()->is_active) <sup class="text text-danger" title="Disable or deleted">(*)</sup>@endif
            </td>
            <td>
                {{ $category->getCategoryOne()->name }}
                @if(! $category->getCategoryOne()->is_active) <sup class="text text-danger" title="Disable or deleted">(*)</sup>@endif
            </td>
            <td>
                {{ $category->getCategoryTwo()->name }}
                @if(! $category->getCategoryTwo()->is_active) <sup class="text text-danger" title="Disable or deleted">(*)</sup>@endif
            </td>
            <td><a href="{{ url('admin/category-three/' . $category->id) }}">{{ $category->name }}</a></td>
            <td>
                @define $img = $category->getImage()
                {{ empty($category->image) ||  ! is_file($img) ? '<span class="text text-warning">NO IMAGE</span>' : '<a href="' . url($img) . '" class="_fwfl">' . HTML::image($img, $category->name, ['class' => 'img-thumbnail _fl post-upload-image']) . '</a>' }}
                @if( ! empty($category->image) && file_exists($img))
                    {{ Form::open(array('url' => 'admin/category-three/delete-image/' . $category->id, 'method' => 'DELETE', 'class' => 'delete-image-frm')) }}
                        <button type="submit" class="btn btn-warning btn-xs" data-confirmation data-msg="Delete this image???"><i class="_td_i fa fa-trash"></i> delete</button>
                    {{ Form::close() }}
                @endif
            </td>
            <!--<td>{{-- str_limit($category->description, $limit = 30, $end = '...') --}}</td>-->
            @define $url = url('/admin/ajax/active/categoryThree-' . $category->id)
            <td class="active-container">{{ $category->is_active ? '<span class="label label-success _cp" data-kingActive data-activeurl="' . $url . '">active</span>' : '<span class="label label-danger _cp" data-kingActive data-activeurl="' . $url . '">disable</span>'}}</td>
            <td>{{ King\Backend\_Common::changeDatetimeFormat($category->updated_at, 'd/m/Y') }}</td>
            <td class="_tc"><a href="{{ url('admin/category-three/' . $category->id . '/edit') }}" class="text-warning _td_i fa fa-edit"></a></td>
            <td class="_tc">
                {{ Form::open(array('url' => 'admin/category-three/' . $category->id, 'method' => 'DELETE')) }}
                    <button type="submit" class="_ff0" data-confirmation data-msg="Delete this this???"><i class="text-danger _td_i fa fa-trash"></i></button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="_fwfl">
    <a href="{{ url('admin/category-three/create') }}" class="btn btn-default _fl"><i class="fa fa-plus"></i> Add new (<span class="text text-warning">{{ $total }}</span>) </a>
    <a href="{{ url('admin/category-three/delete-all') }}" class="btn btn-danger _fr"><i class="fa fa-trash"></i> Delete all </a>
</div>

<div class="_fwfl">
    <div class="_fr">
        {{ $categories->links() }}
    </div>
</div>
@show