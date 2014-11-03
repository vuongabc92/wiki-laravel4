@section('title')
    Edit post
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/admin/post') }}">posts</a></li>
<li class="active">edit post</li>
@show

@section('pageinfo')
    <h4 class="admin-page-name">Edit post</h4>
@show

@section('body')

<div class="_fwfl">

    {{ Form::model($post, array('url' => url('/admin/post/' . $post->id), 'files' => true, 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <h3 class="_fwfl _tb _fs20 form-title"><i class="fa fa-file-text-o"></i> Edit post</h3>
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
                {{ Form::text('name', null, array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Image</label>
            <div class="col-sm-9">
                <div class="_fwfl">
                    {{ ! is_file('uploads/images/post/' . $post->image) ? '<span class="text text-warning">NO IMAGE</span>' : HTML::image('uploads/images/post/' . $post->image, $post->name, ['class' => '_fl img-thumbnail _fl post-upload-image']) }}
                </div>
                <div class="_fwfl _mt5">
                    {{ Form::file('image', array('class' => 'file-hidden', 'id' => 'post-file-hidden',)) }}
                    <span class="btn btn-default _fl _tg _fs13 btn-trigger-file-hidden-post" data-filehidden data-filehiddenid="post-file-hidden" data-filehiddenerror="file-hidden-error" data-filehiddenerrortxt="The file that you chosen is not valid" data-ext="jpg|png|gif|bmp"><i class="fa fa-link"></i> Choose File...</span>
                    <span class="_tg _fl _fs13 file-hidden-error">File name...</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-9">
                {{ Form::textarea('description', null, array('class' => 'form-control', 'id' => 'description', 'rows' => 4)) }}
            </div>
        </div>

        <div class="form-group">
            <label for="content" class="col-sm-2 control-label">Content <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::textarea('content', null, array('class' => 'form-control', 'id' => 'content')) }}
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