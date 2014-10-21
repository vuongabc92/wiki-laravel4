<!DOCTYPE html>
<html>
    <head>
        <title>Admin dashboard | @yield('title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Load CSS -->
        {{ HTML::style('packages/king/backend/css/bootstrap.css') }}
        {{ HTML::style('packages/king/backend/css/font-awesome.css') }}
        {{ HTML::style('packages/king/backend/css/style.css') }}
    </head>
    <body>

        <div class="header">
            <a href="{{ url('/admin/auth/logout') }}" class="logout-btn">Logout <i class="fa fa-sign-out"></i></a>
        </div>

        <div class="admin-wrapper">

            <div class="left-col">

                <div class="admin-box">
                    <h4 class="hallo-admin">
                        <span class="hallo">Hallo </span>
                        {{ \Auth::user()->username }}
                        {{ \King\Backend\AuthUtility::checkMaster() ? '<sup style="color:#a77;font-size:11px;">master</sup>' : '' }}
                    </h4>
                    <a href="{{ url('/admin/account/current-edit') }}" class="edit-acc-nav">Account setting</a>
                </div>
                <ul class="vertical-nav">
                    <li class="vertical-nav-top">
                        <a href="#">
                            <i class="fa fa-dashboard left-nav-icon"></i>
                            <span class="left-nav-txt">Dashboard</span>
                            <i class="fa fa-angle-left left-nav-arrow"></i>
                        </a>
                    </li>
                    <li class="vertical-nav-top">
                        <a href="{{ url('/admin/accounts'); }}">
                            <i class="fa fa-dashboard left-nav-icon"></i>
                            <span class="left-nav-txt">Accounts</span>
                            <i class="fa fa-angle-left left-nav-arrow"></i>
                        </a>
                    </li>
                    <li class="vertical-nav-top">
                        <a href="#">
                            <i class="fa fa-dashboard left-nav-icon"></i>
                            <span class="left-nav-txt">Dashboard</span>
                            <i class="fa fa-angle-left left-nav-arrow"></i>
                        </a>
                    </li>
                    <li class="vertical-nav-top">
                        <a href="#">
                            <i class="fa fa-dashboard left-nav-icon"></i>
                            <span class="left-nav-txt">Dashboard</span>
                            <i class="fa fa-angle-left left-nav-arrow"></i>
                        </a>
                    </li>
                    <li class="vertical-nav-top">
                        <a href="#">
                            <i class="fa fa-dashboard left-nav-icon"></i>
                            <span class="left-nav-txt">Dashboard</span>
                            <i class="fa fa-angle-left left-nav-arrow"></i>
                        </a>
                    </li>
                    <li class="vertical-nav-top">
                        <a href="#">
                            <i class="fa fa-dashboard left-nav-icon"></i>
                            <span class="left-nav-txt">Dashboard</span>
                            <i class="fa fa-angle-left left-nav-arrow"></i>
                        </a>
                    </li>
                </ul>
                <div class="vertical-nav-line"></div>
            </div>

            <div class="right-col">
                <div class="right-col-header">
                    <div class="right-col-breadcrumb">
                        <ol class="breadcrumb admin-breadcrumb">
                            @yield('breadcrumb')
                        </ol>
                    </div>

                    <div class="admin-page-info">
                        @yield('pageinfo')
                    </div>
                </div>

                <div class="admin-content-wrapper">
                    <div class="admin-content">
                        @yield('body')
                    </div>
                </div>

            </div>
        </div>

        <!-- Load JS -->
        {{ HTML::script('packages/king/backend/js/jquery_v1.5.1.js') }}
        {{ HTML::script('packages/king/backend/js/bootstrap.js') }}
        {{ HTML::script('packages/king/backend/js/script.js') }}
    </body>
</html>
