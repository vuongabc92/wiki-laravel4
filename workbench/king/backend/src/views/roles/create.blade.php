@section('title')
    Add new role
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/admin/roles') }}">roles</a></li>
<li class="active">add new role</li>
@show

@section('pageinfo')
    <h4 class="admin-page-name">Add new role</h4>
@show

@section('body')

<div class="_fwfl">

    {{ Form::open(array('url' => url('/admin/roles'), 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <h3 class="_fwfl _tb _fs20 form-title"><i class="fa fa-file-text-o"></i> Add new role</h3>
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
            <label for="role-name" class="col-sm-2 control-label">Role name <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::text('role_name', '', array('class' => 'form-control', 'id' => 'role-name', 'placeholder' => 'Role name')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="role" class="col-sm-2 control-label">Role <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::text('role', '', array('class' => 'form-control', 'id' => 'role', 'placeholder' => 'Role')) }}
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
                <a href="{{ url('/admin/roles') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

    {{ Form::close() }}
</div>
@show