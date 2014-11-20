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
        @if(Session::has('adminErrors'))
        <div class="alert alert-danger _fwfl  _tc _r0 _b0 _tw _bgr _fwb _fs13 _m0">
            <i class="fa fa-remove"></i> {{ Session::get('adminErrors') }}
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>
        @endif
        @if(Session::has('adminSuccess'))
        <div class="alert alert-danger _fwfl  _tc _r0 _b0 _tw _bgs _fwb _fs13 _m0">
            <i class="fa fa-check"></i> {{ Session::get('adminSuccess') }}
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>
        @endif
        @if(Session::has('adminWarning'))
        <div class="alert alert-warning _fwfl  _tc _r0 _b0 _tw _bgwr _fwb _fs13 _m0">
            <i class="fa fa-exclamation-circle"></i> {{ Session::get('adminWarning') }}
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>
        @endif

        <div class="_fwfl _bgw header">
            <a href="{{ url('/admin/auth/logout') }}" class="_fr _td_i _tg1 _cp logout-btn">{{ trans('backend::main.layouts_master_logout') }} <i class="fa fa-sign-out"></i></a>
        </div>

        <div class="_fwfl admin-wrapper">

            <div class="_fl left-col">
                @define $activeNav = 'active-nav'
                <div class="_fwfl admin-box">
                    <h4 class="_fwfl _fs16 _tb _m0 hallo-admin">
                        <span class="_fs13 hallo">Hallo </span>
                        {{ \Auth::user()->username }}
                        @if(King\Backend\_Knight::isMaster())
                            <sup><i class="fa fa-star _fs13"></i></sup>
                        @endif
                    </h4>
                    <a href="{{ url('/admin/account/current-edit') }}" class="_fl _r3 _td_i _fs12 edit-acc-nav"><i class="fa fa-gear"></i> {{ trans('backend::main.layouts_master_accsetting') }}</a>
                </div>

                <!-- Generate vertical navigation -->
                {{ King\Backend\_Common::generateNavs() }}
                
                <div class="vertical-nav-line"></div>
            </div>

            <div class="right-col">
                <div class="_fwfl right-col-header">
                    <div class="_fwfl right-col-breadcrumb">
                        <ol class="breadcrumb _fs13 admin-breadcrumb">
                            @yield('breadcrumb')
                        </ol>
                    </div>

                    <div class="_fwfl _tb admin-page-info">
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
        {{ HTML::script('packages/king/backend/js/jquery_v1.11.1.js') }}
        {{ HTML::script('packages/king/backend/js/bootstrap.js') }}
        {{ HTML::script('packages/king/backend/js/script.js') }}
        @yield('js')
    </body>
</html>

<!--<ul class="_fwfl _db _m0 vertical-nav">
    <li class="vertical-nav-top">
        <a href="{{ url('admin') }}">
            <i class="fa fa-dashboard left-nav-icon"></i>
            <span class="left-nav-txt">{{ trans('backend::main.layouts_master_dashboard') }}</span>
            <i class="fa fa-angle-left left-nav-arrow"></i>
        </a>
    </li>
    <li>
        <a href="{{ url('/admin/accounts'); }}">
            <i class="fa fa-users left-nav-icon"></i>
            <span class="left-nav-txt">{{ trans('backend::main.layouts_master_acc') }}</span>
            <i class="fa fa-angle-left left-nav-arrow"></i>
        </a>
    </li>
    <li>
        <a href="{{ url('/admin/roles'); }}">
            <i class="fa fa-lock left-nav-icon"></i>
            <span class="left-nav-txt">{{ trans('backend::main.layouts_master_role') }}</span>
            <i class="fa fa-angle-left left-nav-arrow"></i>
        </a>
    </li>
    <li>
        <a href="{{ url('admin/post') }}">
            <i class="fa fa-file-text left-nav-icon"></i>
            <span class="left-nav-txt">{{ trans('backend::main.layouts_master_post') }}</span>
            <i class="fa fa-angle-left left-nav-arrow"></i>
        </a>
    </li>
    <li>
        <a href="{{ url('admin/category-root') }}">
            <i class="fa fa-anchor left-nav-icon"></i>
            <span class="left-nav-txt">Category root</span>
            <i class="fa fa-angle-left left-nav-arrow"></i>
        </a>
    </li>
    <li>
        <a href="{{ url('admin/category-one') }}" class="{{ King\Backend\_Common::showActiveClass($activeNav, 'category-one') }}">
            <i class="fa fa-list-ul left-nav-icon"></i>
            <span class="left-nav-txt">Category one</span>
            <i class="fa fa-angle-left left-nav-arrow"></i>
        </a>
    </li>
    <li>
        <a href="{{ url('admin/category-two') }}" class="{{ King\Backend\_Common::showActiveClass($activeNav, 'category-two') }}">
            <i class="fa fa-list left-nav-icon"></i>
            <span class="left-nav-txt">Category two</span>
            <i class="fa fa-angle-left left-nav-arrow"></i>
        </a>
    </li>
</ul>-->