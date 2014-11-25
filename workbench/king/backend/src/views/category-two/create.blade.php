@section('title')
    Add new category two
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/admin/category-two') }}">categories two</a></li>
<li class="active">add new category two</li>
@show

@section('pageinfo')
    <h4 class="admin-page-name">Add new category</h4>
@show

@section('body')

<div class="_fwfl">

    {{ Form::open(array('url' => url('/admin/category-two'), 'method' => 'POST', 'files' => true, 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <h3 class="_fwfl _tb _fs20 form-title">
                    <i class="fa fa-anchor"></i>
                    Add new category two
                    {{ HTML::image('packages/king/backend/images/loading.gif', 'loading...', array('class' => '_dn loading')) }}
                </h3>
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
                    @define $listRoot[''] = 'Please select a category'
                    @foreach($categoryRoot as $one)
                        @define $listRoot[$one->id] = $one->name
                    @endforeach
                    {{ Form::select('category_root_id', $listRoot, '', array('class' => 'form-control', 'data-categoryonefilterroot' => '', 'data-categoryoneid' => 'category-one', 'data-categoryonefilterrooturl' => url('/admin/category-two/create-filter/'), 'autocomplete' => 'off')) }}
                @else
                    <span class="_fwfl _mt5">
                        <span class="label label-danger">NO-ROOT-AVAILABLE</span>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Category one <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                @if(count($categoryOne) > 0)
                    @if( ! is_null(\Input::old('category_root_id')) && \Input::old('category_root_id') != '')
                        @define $categoryOneFilterRoot = King\Backend\CategoryRoot::find(\Input::old('category_root_id'))->categoryOnes
                    @else
                        @define $categoryOneFilterRoot = array()
                    @endif

                    @define $listOne = array()
                    @define $listOne[''] = 'Please select category root first'
                    @foreach($categoryOneFilterRoot as $one)
                        @define $listOne[$one->id] = $one->name
                    @endforeach
                    {{ Form::select('category_one_id', $listOne, '',array('class' => 'form-control', 'id' => 'category-one', 'autocomplete' => 'off')) }}
                @else
                    <span class="_fwfl _mt5">
                        <span class="label label-danger">NO-CATEGORY-ONE-AVAILABLE</span>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::text('name', '', array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="image" class="col-sm-2 control-label">Image</label>
            <div class="col-sm-9">
                {{ Form::file('image', array('class' => 'file-hidden', 'id' => 'post-file-hidden','autocomplete' => 'off')) }}
                <span class="btn btn-default _fl _tg _fs13 btn-trigger-file-hidden-post" data-filehidden data-filehiddenid="post-file-hidden" data-filehiddenerror="file-hidden-error" data-filehiddenerrortxt="The file that you chosen is not valid" data-ext="jpg|png|gif|bmp"><i class="fa fa-link"></i> Choose File...</span>
                <span class="_tg _fl _fs13 file-hidden-error">File name...</span>
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-9">
                {{ Form::textarea('description', '', array('class' => 'form-control', 'id' => 'description', 'rows' => 4)) }}
            </div>
        </div>
        <div class="form-group">
            <label for="order-number" class="col-sm-2 control-label">Order number <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::text('order_number', King\Backend\_Common::getMaxOrderNumber('King\Backend\CategoryTwo') + 1, array('class' => 'form-control', 'id' => 'order-number', 'placeholder' => 'Order number')) }}
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
                @if(count($categoryOne) > 0 && count($categoryRoot) > 0)
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                @else
                    <button type="button" class="btn btn-danger disabled"><i class="fa fa-remove"></i> Could not save due to no category one or root available available</button>
                @endif
                <a href="{{ url('/admin/category-two') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

    {{ Form::close() }}
</div>
@show