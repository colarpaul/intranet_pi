@extends('layouts.app')

@section('content.css')
<link href="{{ asset('css/lightbox2/lightbox.min.css') }}" rel="stylesheet">
@endsection

@section('content.wallpaper-navbar')

<nav class="navbar wallpaper-object relative" role="navigation" aria-label="dropdown navigation" style="background-image: url(/images/objects/slider_projektentwickler_0{{ rand(1, 7) }}.jpg);">
	<div class="objects-search-background has-text-right">
		<div class="objects-search-title">Objekteindrücke</div>
		<div class="documents-search-description">Aktuelle Bilder von unseren Bauvorhaben</div>
		<div  class="objects-search-wrap">
			<div class="relative">
				<input class="searchbar-field-objects" type="text" placeholder="Objektkürzel, Name oder Straße eingeben"><i class="searchbar-span-objects fa fa-search" aria-hidden="true"></i>
			</div>

			<div class="searchbar-document-wrap">
				<ul>
					<li>No results</li>
				</ul>
			</div>
			<select data-placeholder="Ort wählen" class="chosen-select objects-search-chosen" id="objects-search-chosen" tabindex="2">
				<option value=""></option>
				<option value="0">Alle Standorte</option>
				@foreach ($cities as $city)
				<option value="">
					@if ($city['niederlassung'] == 'Frankfurt')
					Rhein-Main
					@elseif($city['niederlassung'] == 'Duesseldorf' or $city['niederlassung'] == 'Düsseldorf' or $city['niederlassung'] == 'Muenchen' or $city['niederlassung'] == 'München')
					
					@else
					{{ ucFirst($city['niederlassung']) }} 
					@endif
				</option>
				@endforeach
				<option>Rheinland</option>
				<option>München</option>
			</select>
		</div>
	</div>
</nav>
@endsection

@section('content')
<div class="container objects-container wrap-container">
	<div class="columns">
		<div class="column is-8">
			<div class="documents-container-title"><span class="object-title-start">Objekteindrücke</span><span class="object-title-niederlassungen1"></span><span class="object-title-niederlassungen"></span></div>
            <div class="loading-container hidden">
                <a class="button is-loading">Loading</a>
            </div>
			<div class="divTable">
				<div class="divTableBody">
					@foreach ($objects as $object)
					<div class="divTableRow">
						<a href="{{ $object->pfad }}" target="_blank">
							<div class="divTableCell">
								<div>
									<img class="documents-pdf-image" src="/images/{{substr($object->pfad, -3)}}.png"/>
								</div>
								<div class="documents-pdf-name">
									{{ $object->objekt }} | {{ $object->strasse }}, {{ $object->plz }} {{ $object->stadt }}
								</div>
								<div class="documents-pdf-date">
									{{ '(' .  date('d.m.Y', strtotime($object->datum)) . ') ' . $object->niederlassung }}
								</div>
							</div>
						</a>
					</div>
					@endforeach
				</div>
			</div>
		</div>
		<div class="column is-4">
			<div class="documents-container-categories">
				<div class="doc-categories-title">
					Alle Standorte
				</div>
				<div class="doc-categories-spans">
					<div class="object-category-span pi-color" data-id="0"><i class="fa fa-plus-circle" aria-hidden="true"></i> Alle Standorte</div>
					@foreach ($cities as $key => $city)
					<div class="object-category-span" data-id="{{ $key+1 }}" data-name="{{ $city['niederlassung'] }}"><i class="fa fa-plus-circle" aria-hidden="true"></i> 
						@if ($city['niederlassung'] == 'Frankfurt')
						Rhein-Main
						@elseif($city['niederlassung'] == 'Duesseldorf' or $city['niederlassung'] == 'Düsseldorf')
						Rheinland
						@else
						{{ ucFirst($city['niederlassung']) }} 
						@endif
					</div>

					<!-- @foreach ($city['cities'] as $city)
					<div class="object-subcategory-div object-subcategory-{{ $key+1 }} category-change-chosen" data-city="{{ $city }}" data-subcategory="" data-name="">
						<i class="fa fa-plus-circle" aria-hidden="true"></i>
						{{ $city }}
					</div>
					@endforeach -->
					@endforeach
					<div class="object-category-span" data-id="5" data-name="Rheinland"><i class="fa fa-plus-circle" aria-hidden="true"></i> 
						Rheinland
					</div>
				</span>
			</div>
		</div>
	</div>
</div>
</div>
@endsection

@section('content.js')
<script src="{{ asset('js/lightbox2/lightbox-plus-jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
@endsection
