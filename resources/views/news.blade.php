@extends('layouts.app')

@section('content.css')
<link href="{{ asset('css/lightbox2/lightbox.min.css') }}" rel="stylesheet">
@endsection

@section('content.wallpaper-navbar')
<nav class="navbar wallpaper-news relative" role="navigation" aria-label="dropdown navigation">
	<div class="documents-search-background has-text-right">
        <div class="documents-search-title">PROJECT Intern</div>
        <div class="documents-search-description">Neuigkeiten und Informationen rund um unser Unternehmen und den Immobilienmarkt</div>
        <select data-placeholder="@if(!empty(request()->route()->parameters['newsId'])) {{ request()->route()->parameters['newsId'] }} @else Kategorie auswählen @endif" class="chosen-select" id="documents-categories-search-chosen" tabindex="2">
			<option value=""></option>
			<option value="0">Alle Kategorien</option>
			@foreach($newsCategories as $category)
			<option value="{{ $category }}">{{ $category }}</option>
			@endforeach
		</select>
    </div>
</nav>
@endsection

@section('content')
<div class="container news-container wrap-container">
			<div class="documents-container-title">PROJECT Intern<span>@if(!empty(request()->route()->parameters['newsId'])): <span style="font-size: 27px; color: #F29400;">{{ request()->route()->parameters['newsId'] }}</span> @endif</span></div>
			<div class="news-table">

				@foreach($news as $new)
				<div class="news-result columns is-mobile is-multiline">
					<a href="/projectintern/{{ $new->id }}" class="news-image column is-4-desktop is-5-tablet is-12-mobile">
						<div class="news-image-wrap" style="background: url('{{ $new->bild_teaser }}')"></div>
					</a>
					<div class="news-about column is-8-desktop is-7-tablet is-12-mobile">
						<div class="news-message">
							<span>{{ $new->news_art }} ({{ date('d.m.Y', strtotime($new->datum)) }})</span>
						</div>
						<div class="news-title">
							{{ $new->titel }}
						</div>
						@if($new->untertitel)
						<div class="news-description">
							@if(strlen(strip_tags($new->untertitel)) > 200) {!! nl2br(substr(strip_tags($new->untertitel), 0, 200).' (...)') !!} @else {!! nl2br($new->untertitel) !!} @endif
						</div>
						@endif
						<a href="/projectintern/{{ $new->id }}">
							<div class="news-button">
								WEITERLESEN
							</div>
						</a>
					</div>
				</div>
				@endforeach
				{{ $news->links() }}
			</div>
</div>
@endsection

@section('content.js')
<script src="{{ asset('js/lightbox2/lightbox-plus-jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
@endsection
