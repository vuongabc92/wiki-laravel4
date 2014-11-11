@section('title')
    Edit category one
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/admin/category-one') }}">categories one</a></li>
<li class="active">Edit category one</li>
@show

@section('pageinfo')
    <h4 class="admin-page-name">Edit category</h4>
@show

@section('body')

<div class="_fwfl">

    {{ Form::model($category, array('url' => url('/admin/category-one/' . $category->id), 'files' => true,'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <h3 class="_fwfl _tb _fs20 form-title"><i class="fa fa-anchor"></i> Edit category one</h3>
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
            <label class="col-sm-2 control-label">Category root <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                @if(count($categoryRoot) > 0)
                    @define $listRoot = array()
                    @define $listRoot[''] = 'Please choose a category'
                    @foreach($categoryRoot as $one)
                        @define $listRoot[$one->id] = $one->name
                    @endforeach
                    {{ Form::select('category_root_id', $listRoot, null,array('class' => 'form-control')) }}
                @else
                    <span class="_fwfl _mt5">
                        <span class="label label-danger">NO-ROOT-AVAILABLE</span>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::text('name', null, array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="image" class="col-sm-2 control-label">Image</label>
            <div class="col-sm-9">
                <div class="_fwfl">
                    @define $img = 'uploads/images/category/' . $category->image;
                    {{ empty($category->image) || ! is_file($img) ? '<span class="text text-warning">NO IMAGE</span>' : '<a href="' . url($img) . '">' . HTML::image($img, $category->name, ['class' => '_fl img-thumbnail _fl post-upload-image']) . '</a>' }}
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
            <label for="order-number" class="col-sm-2 control-label">Order number <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::text('order_number', null, array('class' => 'form-control', 'id' => 'order-number', 'placeholder' => 'Order number')) }}
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
                @if(count($categoryRoot) > 0)
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                @else
                    <button type="button" class="btn btn-danger disabled"><i class="fa fa-remove"></i> Could not save due to no root available</button>
                @endif
                <a href="{{ url('/admin/category-one') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

    {{ Form::close() }}

</div>
@show