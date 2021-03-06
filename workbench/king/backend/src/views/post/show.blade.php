@section('title')
Post view detail
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/admin/post') }}">posts</a></li>
<li class="active">post details</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">Post details</h4>
@show

@section('body')
<h4 class="_fwfl _tb _fs17"><i class="fa fa-file-text-o"></i> Post view detail</h4>
<table class="table table-responsive">
    <tr>
        <td style="width:200px;">Name</td>
        <td>
            <span class="text text-primary _fs15">{{ $post->name }}</span>
            <span class="_fwfl">
                <a href="{{ url('admin/post/' . $post->id . '/edit') }}" class="btn btn-default btn-xs _mt5"><i class="fa fa-edit"></i> Edit</a>
            </span>
        </td>
    </tr>
    <tr>
        <td>Image</td>
        <td>
            @define $img = 'uploads/images/post/' . $post->image
            {{ empty($post->image) || ! is_file($img) ? '<span class="text text-warning">NO IMAGE</span>' : '<a href="' . url($img) . '">' . HTML::image($img, $post->name, ['class' => 'img-thumbnail _fl view-upload-image']) . '</a>' }}
            @if( ! empty($post->image) && file_exists($img))
                {{ Form::open(array('url' => 'admin/post/delete-image/' . $post->id, 'method' => 'DELETE', 'class' => '_fwfl delete-image-frm')) }}
                <button type="submit" class="btn btn-warning btn-xs" data-confirmation data-msg="Delete this image???"><i class="_td_i fa fa-trash"></i> delete</button>
                {{ Form::close() }}
            @endif
        </td>
    </tr>
    <tr>
        <td>Description</td>
        <td>{{ $post->description }}</td>
    </tr>
    <tr>
        <td>Status</td>
        <td>
            @define $url = url('/admin/ajax/active/post-' . $post->id)
            {{ $post->is_active ? '<span class="label label-success _cp" data-kingActive data-activeurl="' . $url . '">active</span>' : '<span class="label label-danger _cp" data-kingActive data-activeurl="' . $url . '">disable</span>'}}
        </td>
    </tr>
    <tr>
        <td>Modified</td>
        <td>{{ King\Backend\_Common::changeDatetimeFormat($post->updated_at, 'd/m/Y') }}</td>
    </tr>
    <tr>
        <td>Content</td>
        <td>{{ $post->content }}</td>
    </tr>
</table>
<a href="{{ url('/admin/post') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
@show