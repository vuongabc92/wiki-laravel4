
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

        </tr>
        @endforeach
    </tbody>
</table>

<div class="_fwfl">
    <a href="{{ url('admin/post/create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Add new account (<span class="text text-warning">{{ $total - 1 }}</span>) </a>
</div>
@show