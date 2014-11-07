@section('title')
    Edit category root
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/admin/category-root') }}">categories root</a></li>
<li class="active">Edit category root</li>
@show

@section('pageinfo')
    <h4 class="admin-page-name">Edit category</h4>
@show

@section('body')

<div class="_fwfl">

    {{ Form::model($category, array('url' => url('/admin/category-root/' . $category->id), 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <h3 class="_fwfl _tb _fs20 form-title"><i class="fa fa-anchor"></i> Edit category root</h3>
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
                <a href="{{ url('/admin/category-root') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

    {{ Form::close() }}

</div>
@show