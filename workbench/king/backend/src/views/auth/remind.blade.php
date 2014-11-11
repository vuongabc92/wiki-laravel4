

@section('title')
    Login
@show

@section('body')

<form action="{{ action('King\Backend\RemindersController@postRemind') }}" method="POST">
    <input type="email" name="email">
    <input type="submit" value="Send Reminder">
</form>
@show