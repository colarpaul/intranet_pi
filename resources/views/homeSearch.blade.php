@extends('layouts.app')

@section('content.css')
<link href="{{ asset('css/custombox/custombox.min.css') }}" rel="stylesheet">
@endsection

@section('content.wallpaper-navbar')
<div class="wallpaper-home relative" style="background-image: url(/images/wallpaper/wallpaper-home.jpg);">
	<div class="columns is-mobile">
		<div class="home-objects-container has-text-right column is-5-desktop is-8-tablet is-11-mobile" style="padding-right: 2rem">
			<div class="home-title">Suche</div>
			<div class="documents-search-description">Schnell und einfach alle Bereiche des Intranets durchsuchen</div>
			<form action="{{ action('HomeController@suche') }}" class="searchAllForm" method="GET" style="position: relative">
				<input class="searchbar-field3 searchbar-field3-doc" type="text" placeholder="Suchbegriff eingeben" value="@if(isset($searchKey)){{ $searchKey }}@endif" name="key"><i class="searchbar-span3 fa fa-search search-all" aria-hidden="true"></i>
			</form>
		</div>
	</div>
</div>
@endsection

@section('content')
<div class="wrap-container home-container container">
	<div class="columns is-multiline is-mobile is-centered">
		<div class="news-header column is-12-tablet is-12-mobile">
			@if(count($news) > 0)
			<div class="news-title-container columns is-multiline is-gapless">
				<h2 class="pi-color">PROJECT Intern</h2>
			</div>
			@foreach($news as $new)
			<div class="news-wrap columns is-multiline is-mobile">
				<a class="column is-4-desktop column-new is-5-tablet is-12-mobile" href="/projectintern/{{ $new->id }}"><div class="news-image-wrap column is-4-desktop is-5-tablet is-12-mobile" style="background: url('{{ $new->bild_teaser }}');" >
				</div></a>
				<div class="news-desc-wrap column is-8-desktop is-7-tablet is-12-mobile">
					<div class="grau">{{ date('d.m.Y', strtotime($new->datum)) }} | {{ $new->news_art }}</div>
					<div class="news-title">{{ $new->titel }}</div>
					<div class="grau">@if(strlen($new->untertitel) > 220) {{ strip_tags(substr($new->untertitel, 0, 220)).' (...)' }} @else {!! nl2br($new->untertitel) !!} @endif</div>
					<a href="/projectintern/{{ $new->id }}">
						<div class="news-button">
							WEITERLESEN
						</div>
					</a>
				</div>
			</div>
			<hr>
			@endforeach
			@endif
			@if(count($employees) > 0)
			<div class="news-title-container columns is-multiline is-gapless">
				<h2 class="pi-color">Mitarbeiter </h2>
			</div>
			<div class="columns is-multiline is-mobile employees-table" >
				@foreach($employees as $key => $employee)
				<div class="column is-12-mobile is-4-desktop employee-wraper" data-id="{{ $key }}">
					@if(!empty($employee['thumbnailphoto']))
					<div class="employee-image" style="background: url('data:image/jpeg;base64,{{ $employee['thumbnailphoto'] }}')"></div>
					@else
					<div class="employee-image" style="background: url('/images/profile-image-example.png')"></div>
					@endif
					<div class="employee-info1">
						<div><span class="grau">Name: </span> {{ $employee['cn'] }}</div>
						<div><span class="grau">Position: </span>{{ $employee['title'] }}</div>
						<div><span class="grau">Ort: </span>{{ $employee['l'] }}</div>
					</div>
				</div>
				<div class="modal-container modal-{{ $key }}">
					@if(!empty($employee['thumbnailphoto']))
					<div class="thumbnailphoto" style="background: url('data:image/jpeg;base64,{{ $employee['thumbnailphoto'] }}')">
					</div>
					@else
					<div class="thumbnailphoto" style="background: url('/images/profile-image-example.png')">
					</div>
					@endif
					<div><span class="grau">Name: </span> {{ $employee['cn'] }}</div>
					<div><span class="grau">Position: </span> {{ $employee['title'] }}</div>
					@if (!empty($employee['department'])) 
					<div>
						<span class="grau">Abteilung: </span> 
						{{ $employee['department'] }}
					</div>
					@endif
					<div><span class="grau">Ort: </span> {{ $employee['streetaddress'] . ', ' . $employee['postalcode'] . '&nbsp;' . $employee['l'] }}</div>
					@if (!empty($employee['company']))
					<div>
						<span class="grau">Unternehmen: </span> 
						{{ $employee['company'] }}
					</div>
					@endif
					@if (!empty($employee['telephonenumber'])) 
					<div>
						<span class="grau">Telefon: </span> 
						<a class="phone-web" href="tel:{{ $employee['telephonenumber'] }}"> {{ $employee['telephonenumber'] }}</a>
					</div>
					@endif
					@if (!empty($employee['mobile'])) 
					<div>
						<span class="grau">Mobil: </span> 
						<a class="phone-web" href="tel:{{ $employee['mobile'] }}"> {{ $employee['mobile'] }}</a>
					</div>
					@endif
					@if (!empty($employee['mail']))
					<div>
						<span class="grau">E-Mail: </span> 
						<a class="mail-web" href="mailto:{{ strtolower($employee['mail']) }}">{{ strtolower($employee['mail']) }}</a>
					</div>
					@endif
				</div>
				@endforeach
			</div>
			<hr>
			@endif
			@if(count($documents) > 0)
			<div class="news-title-container columns is-multiline is-gapless">
				<h2 class="pi-color">Dokumente</h2>
			</div>
			@foreach ($documents as $document)
			<div class="divTableRow">
				<a target="_blank" href="{{ $document->pfad }}">
					<div class="divTableCell">
						<div>
							<img class="documents-pdf-image" src='/images/{{substr($document->pfad, -3)}}.png' />
						</div>
						<div class="documents-pdf-name">
							{{ $document->name }}
						</div>
						<div class="documents-pdf-date">
							{{ $document->groesse . 'Kb' }}
						</div>
					</div>
				</a>
			</div>
			@endforeach
			<hr>
			@endif
			@if(count($faqs) > 0)
			<div class="news-title-container columns is-multiline is-gapless">
				<h2 class="pi-color">FAQs</h2>
			</div>
			<ul class="faq faq-it-fragen faq-fragen">
				@foreach($faqs as $key => $faq)
				<li class="accordian is-flex">
					<i class="fa fa-angle-down"></i>
					{{ $faq->titel }} <div class="news-faq-category-div">{{ $faq->kategorie }}</div>
				</li>

				<li class="accordian-content">
					{!! nl2br($faq->meldung) !!}
				</li>
				@endforeach
			</ul>
			<hr>
			@endif
			@if(count($objects) > 0)
			<div class="news-title-container columns is-multiline is-gapless">
				<h2 class="pi-color">Objekte</h2>
			</div>
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
			<hr>
			@endif

			@if((count($news) <= 0) AND (count($employees) <= 0) AND (count($documents) <= 0) AND (count($objects) <= 0))
			<div class="news-title-container columns is-multiline is-gapless">
				@if(empty($searchKey))
				<h2 class="pi-color">Bitte geben Sie einen Suchbegriff ein.</h2>
				@else
				<h2 class="pi-color">Keine Ergebnisse. Bitte versuchen Sie es mit einem anderen Suchbegriff.</h2>
				@endif
			</div>
			
			@endif
		</ul>
	</div>
</div>
</div>

<div class="modal-container modal-faq-employee-container">
	<div class="imageModalEmployee"></div>
	<div class="nameModalEmployee"><span>Name: </span><span class="spanName"></span></div>
	<div class="titleModalEmployee"><span>Titel: </span><span class="spanTitle"></span></div>
	<div class="departmentModalEmployee"><span>Abteilung: </span><span class="spanDepartment"></span></div>
	<div class="locationModalEmployee"><span>Ort: </span><span class="spanLocation"></span></div>
	<div class="companyModalEmployee"><span>Unternehmen: </span><span class="spanCompany"></span></div>
	<div class="phoneModalEmployee"><span>Telefon: </span><a class="phone-web spanPhone"></a></div>
	<div class="emailModalEmployee"><span>Email: </span><a class="mail-web spanEmail"></a></div>
</div>

@endsection

@section('content.js')
<script src="{{ asset('js/custombox/custombox.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/custombox/custombox.legacy.min.js') }}" type="text/javascript" charset="utf-8"></script>
@endsection
