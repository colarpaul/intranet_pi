<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge;FF=3;OtherUA=4;">
  <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>PROJECT Immobilien · Intranet</title>

  <!-- Styles -->
  <link href="{{ asset('css/chosen/chosen.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('css/bulma.css') }}">
  @yield('content.css')
  <link href="{{ asset('css/main.min.css') }}" rel="stylesheet">

  @if(env('APP_ENV') == 'production')
  <!-- Matomo -->
  <script type="text/javascript">
    var _paq = _paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
      var u="//intranet.project-immobilien.com/analytics/";
      _paq.push(['setTrackerUrl', u+'piwik.php']);
      _paq.push(['setSiteId', '1']);
      var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
      g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
  </script>
  <!-- End Matomo Code -->
  @endif

</head>
<body>

  <nav class="navbar navbar-is-black" role="navigation" aria-label="dropdown navigation">
    <div class="container">
      <div class="navbar-item navbar-search">
        <form action="{{ action('HomeController@suche') }}" class="searchAllForm" method="GET" style="margin: 0">
          <input class="searchbar-field" type="text" placeholder="Suchbegriff eingeben" name="key" value="@if(isset($searchKey)){{ $searchKey }}@endif" style="padding: 0.4rem 2rem .6em 1rem; width: 13rem;">
          <i class="searchbar-span fa fa-search search-all" aria-hidden="true" style="right: 2rem;"></i>
          <!-- <a href="#"><span></span></a> -->
        </form>
      </div>
      <div class="navbar-item navbar-socials " style="margin-right: 0">
        Social Media: 
        <!-- <a href="https://plus.google.com/" target="_blank"><img class="social-image" src="{{ asset('images/google-plus-grey.png') }}"/></a> -->
        <a href="https://www.facebook.com/projectimmobiliengruppe/" target="_blank"><img class="social-image" title="PROJECT Immobilien - Facebook" src="{{ asset('images/facebook-grey.png') }}"/></a>
        <a href="https://www.instagram.com/projectimmo/" target="_blank"><img class="social-image" title="PROJECT Immobilien - Instagram" src="{{ asset('images/instagram-grey.png') }}"/></a>
        <a href="https://www.youtube.com/user/ProjectImmobilien/" target="_blank"><img class="social-image" title="PROJECT Immobilien - Youtube" src="{{ asset('images/youtube-grey.png') }}"/></a>
      </div>
    </div>
  </nav>
  <div class="h-top navbar-is-white">
    <div class="container">

      <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
         <a href="{{ url('home') }}" class="navbar-image-logo"></a>
       </div>

       <button class="button navbar-burger" data-target="navMenu">
        <span></span>
        <span></span>
        <span></span>
      </button>

      <div class="navbar-menu">
        <div class="navbar-start"></div>
        <div class="navbar-end">
          <div class="navbar-item @if(Route::current()->uri == '/' OR Route::current()->uri == 'start') navbar-is-active @endif">
            <a href="{{ url('') }}">Start</a>
          </div>
          <div class="navbar-item @if(Route::current()->uri == 'projectintern' OR Route::current()->uri == 'projectintern/{newsId}') navbar-is-active @endif">
            <a href="{{ url('projectintern') }}">PROJECT Intern</a>
          </div>
          <div class="navbar-item @if(Route::current()->uri == 'mitarbeiter') navbar-is-active @endif">
            <a href="{{ url('mitarbeiter') }}">Mitarbeiter</a>
          </div>
          <div class="navbar-item @if(Route::current()->uri == 'dokumente-support' OR Route::current()->uri == 'dokumente-support/alleDokumente') navbar-is-active @endif">
            <a href="{{ url('dokumente-support') }}">Dokumente & Support</a>
          </div>
          <div class="navbar-item @if(Route::current()->uri == 'bildergalerien' OR Route::current()->uri == 'bildergalerien/{location}') navbar-is-active @endif">
            <a href="{{ url('bildergalerien') }}">Bildergalerien</a>
          </div>
          <div class="navbar-item @if(Route::current()->uri == 'objekte') navbar-is-active @endif">
            <a href="{{ url('objekte') }}">Objekte</a>
          </div>
        </div>

      </div>


    </nav>

  </div>
</div>

@yield('content.wallpaper-navbar')


@yield('content')

<div class="footer">
  <div class="copyright">© PROJECT Immobilien 2018</div>
</div>

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js" type="text/javascript"></script>
<script src="{{ asset('js/chosen/chosen.jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/chosen/init.js')}}" type="text/javascript" charset="utf-8"></script>
@yield('content.js')
<script src="{{ asset('js/main.min.js') }}" type="text/javascript" charset="utf-8"></script>
  <script>
    $('.search-all').on('click', function(e){
      e.preventDefault;
      $('.searchAllForm').submit();
    })
  </script>
</body>
</html>