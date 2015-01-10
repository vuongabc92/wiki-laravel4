
@section('title')
{{ trans('backoffice::backoffice.user_title') }}
@show

@section('breadcrumb')
<li><a href=""><i class="fa fa-dashboard"></i> {{ trans('backoffice::backoffice.dashboard') }}</a></li>
<li class="active">{{ trans('backoffice::backoffice.user') }}</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">{{ trans('backoffice::backoffice.user_title') }}</h4>
@show

@section('body')
<table class="table table-bordered table-hover table-striped table-responsive">
    <thead>
        <tr>
            
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>

<div class="_fwfl">
    <a href="" class="btn btn-default"><i class="fa fa-plus"></i> {{ trans('backoffice::common.add_new') }} (<span class="text text-warning"></span>) </a>
</div>
@show