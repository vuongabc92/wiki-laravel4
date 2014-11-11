@section('title')
Category view detail
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/admin/category-one') }}">category</a></li>
<li class="active">category details</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">Category details</h4>
@show

@section('body')
<h4 class="_fwfl _tb _fs17"><i class="fa fa-list "></i> Category view detail</h4>
<table class="table table-responsive">
    <tr>
        <td>Category root</td>
        <td><strong class="text text-danger">{{ $category->getRoot()->name }}</strong></td>
    </tr>
    <tr>
        <td style="width:200px;">Name</td>
        <td>
            <span class="text text-primary _fs15">{{ $category->name }}</span>
            <span class="_fwfl">
                <a href="{{ url('admin/category-one/' . $category->id . '/edit') }}" class="btn btn-default btn-xs _mt5"><i class="fa fa-edit"></i> Edit</a>
            </span>
        </td>
    </tr>
    <tr>
        <td>Image</td>
        <td>
            @define $img = 'uploads/images/category/' . $category->image
            {{ empty($category->image) || ! is_file($img) ? '<span class="text text-warning">NO IMAGE</span>' : '<a href="' . url($img) . '">' . HTML::image($img, $category->name, ['class' => 'img-thumbnail _fl view-upload-image']) . '</a>' }}
            @if( ! empty($category->image) && file_exists($img))
                {{ Form::open(array('url' => 'admin/category-one/delete-image/' . $category->id, 'method' => 'DELETE', 'class' => '_fwfl delete-image-frm')) }}
                <button type="submit" class="btn btn-warning btn-xs" data-confirmation data-msg="Delete this image???"><i class="_td_i fa fa-trash"></i> delete</button>
                {{ Form::close() }}
            @endif
        </td>
    </tr>
    <tr>
        <td>Description</td>
        <td>{{ $category->description }}</td>
    </tr>
    <tr>
        <td>Status</td>
        <td>
            @define $url = url('/admin/ajax/active/categoryOne-' . $category->id)
            {{ $category->is_active ? '<span class="label label-success _cp" data-kingActive data-activeurl="' . $url . '">active</span>' : '<span class="label label-danger _cp" data-kingActive data-activeurl="' . $url . '">disable</span>'}}
        </td>
    </tr>
    <tr>
        <td>Order number</td>
        <td><span class="text text-primary">{{ $category->order_number }}</span></td>
    </tr>
    <tr>
        <td>Modified</td>
        <td>{{ King\Backend\_Common::changeDatetimeFormat($category->updated_at, 'd/m/Y') }}</td>
    </tr>
    
</table>
@show