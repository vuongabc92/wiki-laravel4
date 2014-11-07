
@section('title')
List posts
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">posts</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">List posts</h4>
@show

@section('body')
<table class="table table-bordered table-hover table-striped table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Image</th>
            <th>Description</th>
            <th>Content</th>
            <th>Is active</th>
            <th>Modified</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @define $i = 0
        @foreach($posts as $post)
            @define $i = $i +1
        <tr>
            <td>{{ $i }}</td>
            <td><a href="{{ url('admin/post/' . $post->id) }}">{{ $post->name }}</a></td>
            <td>
                {{ empty($post->image) || ! is_file('uploads/images/post/' . $post->image) ? '<span class="text text-warning">NO IMAGE</span>' : '<a href="' . url('uploads/images/post/' . $post->image) . '">' . HTML::image('uploads/images/post/' . $post->image, $post->name, ['class' => 'img-thumbnail _fl post-upload-image']) . '</a>' }}
                @if( ! empty($post->image) && file_exists('uploads/images/post/' . $post->image))
                    {{ Form::open(array('url' => 'admin/post/delete-image/' . $post->id, 'method' => 'DELETE', 'class' => 'delete-image-frm')) }}
                        <button type="submit" class="btn btn-warning btn-xs" data-confirmation data-msg="Delete this image???"><i class="_td_i fa fa-trash"></i> delete</button>
                    {{ Form::close() }}
                @endif
            </td>
            <td>{{ substr($post->description, 0, 50) . '...' }}</td>
            <td>{{ substr($post->content, 0, 100) . '...' }}</td>
            @define $url = url('/admin/ajax/active/post-' . $post->id)
            <td class="active-container">{{ $post->is_active ? '<span class="label label-success _cp" data-kingActive data-activeurl="' . $url . '">active</span>' : '<span class="label label-danger _cp" data-kingActive data-activeurl="' . $url . '">disable</span>'}}</td>
            <td>{{ King\Backend\_Common::changeDatetimeFormat($post->updated_at, 'd/m/Y') }}</td>
            <td class="_tc"><a href="{{ url('admin/post/' . $post->id . '/edit') }}" class="text-warning _td_i fa fa-edit"></a></td>
            <td class="_tc">
                {{ Form::open(array('url' => 'admin/post/' . $post->id, 'method' => 'DELETE')) }}
                    <button type="submit" class="_ff0" data-confirmation data-msg="Delete this post???"><i class="text-danger _td_i fa fa-trash"></i></button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="_fwfl">
    <a href="{{ url('admin/post/create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Add new (<span class="text text-warning">{{ $total }}</span>) </a>
</div>
@show