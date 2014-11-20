
@section('title')
List contact from client
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">list contact</li>
@show

@section('pageinfo')
<h4 class="admin-page-name">List contact from client</h4>
@show

@section('body')
    <table class="table table-bordered table-hover table-striped table-responsive">
    <thead>
        <tr>
            <th><input type="checkbox" class="checkbox-top" data-checkall data-checkallclass="check-all"/></th>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone number</th>
            <th>Content</th>
            <th>Date</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @define $i = 0
        @foreach($contacts as $contact)
            @define $i += 1
        <tr>
            <td><input type="checkbox" class="check-all" id="check-{{ $contact->id }}" data-id="{{ $contact->id }}"/></td>
            <td>{{ $i }}</td>
            <td><a href="{{ url('admin/contacts/' . $contact->id) }}">{{ $contact->name }}</a></td>
            <td>{{ HTML::mailto($contact->email) }}</td>
            <td>{{ $contact->phone_number }}</td>
            <td>{{ str_limit($contact->content, $limit = 30, $end = '...') }}</td>
            <td>{{ King\Backend\_Common::changeDatetimeFormat($contact->created_at, 'd/m/Y') }}</td>
            <td class="_tc">
                {{ Form::open(array('url' => 'admin/contact/' . $contact->id, 'method' => 'DELETE')) }}
                    <button type="submit" class="_ff0" data-confirmation data-msg="Delete this this???"><i class="text-danger _td_i fa fa-trash"></i></button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@show