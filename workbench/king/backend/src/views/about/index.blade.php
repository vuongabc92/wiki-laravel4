@section('title')
About
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">about</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">About</h4>
@show

@section('body')
<h4 class="_fwfl _tb _fs17"><i class="fa fa-ti"></i> Page about</h4>
<table class="table table-responsive">
    <tr>
        <td style="width:200px;">Name</td>
        <td>About us</td>
    </tr>
    <tr>
        <td>Image</td>
        <td>Name</td>
    </tr>
    <tr>
        <td>Description</td>
        <td>Baby love was good to me but you just make it better...</td>
    </tr>
    <tr>
        <td>Status</td>
        <td><span class="label label-success">active</span></td>
    </tr>
    <tr>
        <td>Modified</td>
        <td>2014-10-23 1:12:55</td>
    </tr>
    <tr>
        <td>Content</td>
        <td>Until you</td>
    </tr>
</table>
@show