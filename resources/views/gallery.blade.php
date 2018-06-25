@extends('layouts.app')

@section('content.css')
<link href="{{ asset('css/lightbox2/lightbox.min.css') }}" rel="stylesheet">
@endsection

@section('content.wallpaper-navbar')
<nav class="navbar wallpaper-gallery relative" role="navigation" aria-label="dropdown navigation">
	<div class="gallery-search-background has-text-right column is-5-desktop is-8-tablet is-11-mobile">
		<div class="home-title">Bildergalerien</div>
		<div class="home-subtitle">Eindrücke und Bilder vergangener Veranstaltungen</div>
		<select data-placeholder="@if(!empty(request()->route()->parameters['location'])) {{ str_replace('-', ' ', request()->route()->parameters['location']) }} @else Event auswählen @endif" class="chosen-select" id="gallery-location-search-chosen" tabindex="2">
			<option value=""></option>
			<option value="0">Alle Events</option>
			<option value="Berlin">Weihnachtsfeier Berlin</option>
			<option value="Nuernberg">Weihnachtsfeier Nürnberg</option>
		</select>
	</div>
</div>
</nav>
@endsection

@section('content')
<div class="wrap-container container gallery-container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="columns is-multiline is-12 is-touch">
					@if(count($images))
					<div class="column is-12-desktop is-12-touch is-12-mobile margin-auto">
						@if(!empty(request()->route()->parameters['location']))
						<div class="gallery-title-start">{{ str_replace('-', ' ', request()->route()->parameters['location']) }}</div>
						<div class="gallery-title-date">{{ str_replace('December', 'Dezember', strftime("%d. %B %Y", strtotime($date->date))) }}</div>
						@else
						<div class="gallery-title-start">Alle Bilder</div>
						@endif
					</div>

					@foreach($images as $image)
					<div class="column is-4-desktop is-6-touch is-12-mobile margin-auto image-div-gallery">
						<a class="example-image-link" href="{{ $image->pfad }}" data-lightbox="example-set" data-title="{{ str_replace('ue', 'ü', $image->description) }}"><img class="example-image" src="{{ $image->pfad }}" alt=""/></a>
					</div> 
					@endforeach
					@else
					<div class="gallery-title-start">
						Kurzfristig müssen doch noch einige Änderungen vorgenommen werden.
						<br>
						Die Bilder von den Weihnachtsfeiern werden nächste Woche wieder verfügbar sein.
						<br>
						Vielen Dank für Ihr Verständnis!
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
    {{ $images->links() }}
</div>
@endsection

@section('content.js')
<script src="{{ asset('js/lightbox2/lightbox-plus-jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
@endsection