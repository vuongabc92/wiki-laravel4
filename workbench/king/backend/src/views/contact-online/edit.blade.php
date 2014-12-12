@section('title')
    Edit contact online
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/admin/contact-online') }}">contact online</a></li>
<li class="active">Edit contact online</li>
@show

@section('pageinfo')
    <h4 class="admin-page-name">Contact online</h4>
@show

@section('body')

<div class="_fwfl">

    {{ Form::model($online, array('url' => url('/admin/contact-online/' . $online->id), 'files' => true,'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <h3 class="_fwfl _tb _fs20 form-title"><i class="fa fa-anchor"></i> Edit contact online</h3>
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
                @if(count($contactType) > 0)
                    @define $listType = array()
                    @define $listType[''] = 'Please choose a type'
                    @foreach($contactType as $one)
                        @define $listType[$one->id] = $one->name
                    @endforeach
                    {{ Form::select('contact_type_id', $listType, null,array('class' => 'form-control')) }}
                @else
                    <span class="_fwfl _mt5">
                        <span class="label label-danger">NO-CONTACT-TYPE-AVAILABLE</span>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="contact" class="col-sm-2 control-label">Contact <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::text('contact', null, array('class' => 'form-control', 'id' => 'contact', 'placeholder' => 'Contact')) }}
            </div>
        </div>
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
                        {{ Form::checkbox('is_active', 1, true) }} Is active
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
                @if(count($contactType) > 0)
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                @else
                    <button type="button" class="btn btn-danger disabled"><i class="fa fa-remove"></i> Could not save due to no contact type available</button>
                @endif
                <a href="{{ url('/admin/contact-online') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

    {{ Form::close() }}

</div>
@show