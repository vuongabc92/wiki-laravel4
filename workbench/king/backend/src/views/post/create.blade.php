@section('title')
    Add new post
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/admin/post') }}">posts</a></li>
<li class="active">add new post</li>
@show

@section('pageinfo')
    <h4 class="admin-page-name">Add new post</h4>
@show

@section('body')

<div class="_fwfl">

    {{ Form::open(array('url' => url('/admin/post'), 'files' => true, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <h3 class="_fwfl _tb _fs20 form-title"><i class="fa fa-file-text-o"></i> Add new post</h3>
            </div>
        </div>
        @if(count($errors) > 0)
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {{HTML::ul($errors->all())}}
                </div>
            </div>
        </div>
        @endif
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::text('name', '', array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Image</label>
            <div class="col-sm-9">
                {{ Form::file('image', array('class' => 'file-hidden', 'id' => 'post-file-hidden', 'data-id' => 'aaa')) }}
                <span class="btn btn-primary btn-xs _fl btn-trigger-file-hidden-post" data-filehidden data-filehiddenid="post-file-hidden" data-filehiddenerror="file-hidden-error" data-ext="jpg|png|gif|bmp"><i class="fa fa-image"></i> Choose an image...</span>
                <span class="text text-danger _fl _fs13 file-hidden-error"> <i class="fa fa-exclamation-circle"></i> The file that you chosen is not valid</span>
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-9">
                {{ Form::textarea('description', '', array('class' => 'form-control', 'id' => 'description', 'rows' => 4)) }}
            </div>
        </div>

        <div class="form-group">
            <label for="content" class="col-sm-2 control-label">Content <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::textarea('content', '', array('class' => 'form-control', 'id' => 'content')) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label class="_tb">
                        {{ Form::checkbox('is_active', 1) }} Is active
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <sup class="text-danger">*</sup> mean the field must be filled or selected.
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                <a href="{{ url('/admin/post') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

    {{ Form::close() }}
</div>
@show