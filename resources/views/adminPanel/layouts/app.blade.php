<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PROJECT Immobilien · Intranet · CMS</title>
    <link href="{{ asset('adminPanel/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('adminPanel/assets/plugins/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('adminPanel/assets/plugins/chartist-js/dist/chartist-init.css') }}" rel="stylesheet">
    <link href="{{ asset('adminPanel/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <link href="{{ asset('adminPanel/assets/plugins/c3-master/c3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('adminPanel/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('adminPanel/css/colors/blue.css') }}" id="theme" rel="stylesheet">
    <link href="{{ asset('css/chosen/chosen.min.css')}}" rel="stylesheet"></script>
    <link href="{{ asset('css/custombox/custombox.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/css/froala_style.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>
        <div id="main-wrapper">
            <header class="topbar">
                <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="/cms">
                            INTRANET
                        </a>
                    </div>
                    <div class="navbar-collapse">
                        <ul class="navbar-nav mr-auto mt-md-0"  style="float: right">
                            <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="left-sidebar">
                <div class="scroll-sidebar">
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li> <a class="waves-effect waves-dark {{ Route::current()->uri == 'cms' ? 'active' : ''}}" href="/cms" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark {{ Route::current()->uri == 'cms/documents' ? 'active' : ''}}" href="/cms/documents" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="hide-menu">Documents</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark {{ Route::current()->uri == 'cms/objects' ? 'active' : ''}}" href="/cms/objects" aria-expanded="false"><i class="mdi mdi-book"></i><span class="hide-menu">Objects</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark {{ (Route::current()->uri == 'cms/news' OR Route::current()->uri == 'cms/news/sortable') ? 'active' : ''}}" href="/cms/news" aria-expanded="false"><i class="mdi mdi-newspaper"></i><span class="hide-menu">News</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark {{ (Route::current()->uri == 'cms/faqs' OR Route::current()->uri == 'cms/faqs/sortable' OR Route::current()->uri == 'cms/faqs/statistics') ? 'active' : ''}}" href="/cms/faqs" aria-expanded="false"><i class="mdi mdi-content-copy"></i><span class="hide-menu">FAQs</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark {{ Route::current()->uri == 'cms/homepage' ? 'active' : ''}}" href="/cms/homepage" aria-expanded="false"><i class="mdi mdi-image"></i><span class="hide-menu">Homepage</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark {{ Route::current()->uri == 'cms/wlan' ? 'active' : ''}}" href="/cms/wlan" aria-expanded="false"><i class="mdi mdi-signal-variant"></i><span class="hide-menu">WLAN Settings</span></a>
                            </li>
                            <li> <a class="waves-effect waves-dark {{ Route::current()->uri == 'cms/central' ? 'active' : ''}}" href="/cms/central" aria-expanded="false"><i class="mdi mdi-domain"></i><span class="hide-menu">Central</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="sidebar-footer">
                </aside>
                @yield('content')

                <footer class="footer"> © 2017 PROJECT Immobilien </footer>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script src="{{ asset('js/custombox/custombox.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/custombox/custombox.legacy.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/chosen/chosen.jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/chosen/init.js')}}" type="text/javascript" charset="utf-8"></script>

    <!-- Include Editor style. -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.7.3/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.7.3/css/froala_style.min.css' rel='stylesheet' type='text/css' />

    <!-- Include JS file. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
    <script type="text/javascript" src="/adminPanel/js/nicEdit.js"></script>

    <script src="{{ asset('adminPanel/js/custom.js') }}"></script>
</body>

</html>

