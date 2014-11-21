@section('title')
Contact details
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/admin/contacts') }}">contacts</a></li>
<li class="active">contact details</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">Contact details</h4>
@show

@section('body')
<h4 class="_fwfl _tb _fs17"><i class="fa fa-reply "></i> Contact view details</h4>
<table class="table table-responsive">
    <tr>
        <td style="width:200px;">Name</td>
        <td>
            <span class="text text-danger _fs15">{{ $contact->name }}</span>
        </td>
    </tr>
    <tr>
        <td>Email</td>
        <td>{{ HTML::mailto($contact->email) }}</td>
    </tr>
    <tr>
        <td>Phone number</td>
        <td>{{ $contact->phone_number }}</td>
    </tr>
    <tr>
        <td>Content</td>
        <td>{{ $contact->content }}</td>
    </tr>
    <tr>
        <td>Date sent</td>
        <td>{{ King\Backend\_Common::changeDatetimeFormat($contact->updated_at, 'd/m/Y') }}</td>
    </tr>

</table>
<a href="{{ url('/admin/contacts') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
@show