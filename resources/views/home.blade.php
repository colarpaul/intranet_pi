@extends('layouts.app')

@section('content.css')
<link href="{{ asset('css/custombox/custombox.min.css') }}" rel="stylesheet">
@endsection

@section('content.wallpaper-navbar')
<div class="wallpaper-home relative" style="background-image: url({{ $headerHPData->wallpaper }});">
	<div class="columns is-mobile">
		<div class="home-objects-container has-text-right column is-5-desktop is-8-tablet is-11-mobile">
			<div class="home-title">{{ $headerHPData->titel }}</div>
			<div class="home-subtitle">{{ $headerHPData->untertitel }}</div>
			<div class="more-info-button">
				<a href="{{ $headerHPData->button_url }}">
					<div class="info">
						<i class="fa fa-info-circle" aria-hidden="true"></i>
					</div>
					<div class="desc">
						{{ $headerHPData->button_name }}
					</div>
				</a>
			</div>
		</div>
	</div>
</div>
@endsection

@section('content')
<div class="wrap-container home-container container">
	<div class="columns is-multiline is-mobile is-centered">
		<div class="news-header column is-7-tablet is-11-mobile">
			<div class="news-title-container columns is-multiline is-gapless">
				<h2>PROJECT Intern</h2>&nbsp;&nbsp;<a href="/projectintern" class="link-web">[Alle Beiträge anzeigen]</a>
			</div>
			@foreach($lastNews as $lastNew)
			<div class="news-wrap columns is-multiline is-mobile">
				<a class="column is-4-desktop is-5-tablet is-12-mobile padding-0" href="/projectintern/{{ $lastNew->id }}"><div class="news-image-wrap column is-4-desktop is-5-tablet is-12-mobile" style="background: url('{{ $lastNew->bild_teaser }}'); width: 100%;">
				</div></a>
				<div class="news-desc-wrap column is-8-desktop is-7-tablet is-12-mobile">
					<div class="grau">{{ date('d.m.Y', strtotime($lastNew->datum)) }} | {{ $lastNew->news_art }}</div>
					<div class="news-title">{{ $lastNew->titel }}</div>
					<div class="grau">@if(strlen(strip_tags($lastNew->untertitel)) > 200) {{ substr(strip_tags($lastNew->untertitel), 0, 200).' (...)' }} @else {!! nl2br($lastNew->untertitel) !!} @endif</div>
					<a href="/projectintern/{{ $lastNew->id }}">
						<div class="news-button">
							WEITERLESEN
						</div>
					</a>
				</div>
			</div>
			@endforeach
		</div>
		<div class="column is-4-tablet is-11-mobile">

			@if(!empty($homeMessageData->title) && !empty($homeMessageData->message))
			<div class="employees-header">
				<h2>{{ $homeMessageData->title }}</h2>
			</div>
			<div class="documents-container-help" style="
			margin-bottom: 2rem;
			background: rgba(150, 92, 0, 0.08);
			color: #4a4a5b;
			margin-top: 1rem;
			border: 1px solid orange;
			font-weight: 00;
			border-radius: 0 0 15px 0;
			">

				<div class="doc-help-description">
					{!! $homeMessageData->message !!}
				</div>
			</div>
			@endif

			
			<div class="employees-header">
				<h2>Mitarbeiter </h2>&nbsp;&nbsp;<a class="link-web" href="/mitarbeiter">[Alle Mitarbeiter anzeigen]</a>
			</div>
			@foreach($employeesOfMonth as $key => $employeeOfMonth)
			<div class="employee-wraper-special">
				<div class="employee-wrap employee-wraper" data-id="{{ $key }}" data-email="{{ $employeeOfMonth['mail'] }}" >
					<div class="employees-image-wrap">
						@if(!empty($employeeOfMonth['thumbnailphoto']))
						<img class="thumbnailphoto-employee" src='data:image/jpeg;base64, {{ $employeeOfMonth['thumbnailphoto'] }}'>
						@else
						<img src="{{ asset('images/profile-image-example.png') }}">
						@endif
					</div>
					<div class="employees-desc-wrap">
						<div><span class="grau">Name:</span> {{ $employeeOfMonth['cn'] }}</div>
						<div><span class="grau">Unternehmen:</span> {{ $employeeOfMonth['company'] }}</div>
						<div><span class="grau">Ort:</span> {{ $employeeOfMonth['l'] }}</div>
						<div><span class="grau">Position:</span> {{ $employeeOfMonth['title'] }}</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>

<div class="modal-container employeeModal relative">
	<a class="downloadVCard"><i class="fa fa-address-card vCardImage"></i></a>
	<div class="employeeThumbnailphoto">
	</div>
	<div><span class="grau">Name: </span> <span class="employeeName"></span></div>
	<div><span class="grau">Position: </span> <span class="employeeTitle"></span></div>
	<div>
		<span class="grau">Abteilung: <span class="employeeAbteilung"></span></span> 
	</div>
	<div>
		<span class="grau">Ort: <span class="employeeLocation"></span></span> 
	</div>
	<div>
		<span class="grau">Unternehmen: <span class="employeeUnternehmen"></span></span> 
	</div>
	<div>
		<span class="grau">Telefon: </span> 
		<a class="phone-web employeeTelefonnumberLink"> <span class="employeeTelefonnumber"></span></a>
	</div>
	<div>
		<span class="grau">Mobil: </span> 
		<a class="phone-web employeeMobileLink"> <span class="employeeMobile"></span></a>
	</div>
	<div>
		<span class="grau">E-Mail: </span> 
		<a class="mail-web employeeMailLink"><span class="employeeMail"></span></a>
	</div>
</div>

<div class=" wallpaper-home-objects relative">
	<div class="columns">
		<div class="home-objects-container column is-7-fullhd is-8-widescreen is-9-desktop is-10-touch">
			<div class="columns is-multiline">
				<div class="column is-offset-5-fullhd is-7-fullhd is-offset-3-widescreen is-9-widescreen is-offset-2-desktop is-10-desktop is-offset-1-touch is-11-touch">
					<div class="columns is-multiline is-mobile is-gapless">
						<div class="home-objects-title column is-6-tablet is-12-mobile">
							Neueste Dokumente
						</div>
						<div class="home-objects-button column is-6-tablet is-12-mobile">
							<a href="/dokumente">
								[Alle Dokumente anzeigen]
							</a>
						</div>
					</div>
				</div>
				<div class="column is-offset-5-fullhd is-7-fullhd is-offset-3-widescreen is-9-widescreen is-offset-2-desktop is-10-desktop is-offset-1-touch is-11-touch">
					<div class="columns is-multiline">
						@foreach($newDocuments as $key => $dokument)
						<div class="column is-6 is-12-touch">
							<a href="{{ $dokument->pfad }}" target="_blank">
								<div class="is-flex">
									<div class="margin-right-20">
										<img class="documents-pdf-image" src="@if(strtotime($dokument->created_at) > strtotime('-30 days'))/images/{{substr($dokument->pfad, -3)}}_new.png @else /images/{{substr($dokument->pfad, -3)}}.png @endif"/>
									</div>
									<div> 
										<div class="grau">{{ date('d.m.Y', strtotime($dokument->created_at)) }} </div>
										<div class="home-object-title">	{{ $dokument->name }} </div>
									</div>
								</div>	
							</a>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="empty-top-container"></div>

<div class="wallpaper-home-objects relative">
	<div class="columns is-multiline">
		<div class="home-objects-container column is-7-fullhd is-8-widescreen is-8-desktop is-10-touch">
			<div class="columns">
				
				<div class="column is-offset-5-fullhd is-7-fullhd is-offset-3-widescreen is-9-widescreen is-offset-2-desktop is-10-desktop is-offset-1-touch is-11-touch">
					<div class="columns">
						
						<div class="column is-12 has-text-right">
							<div class="home-cloud-title">
								PROJECT Cloud
							</div>
							<div class="home-cloud-subtitle">
								Unsere Lösung für bequemen Datenaustausch
							</div>
							<div class="home-cloud-buttons">
								<a href="//transfer.project-immobilien.com" target="_blank" class="home-cloud-button"><i class="fa fa-cloud-download" aria-hidden="true"></i> Zur Cloud</a>
								<a href="/documents/pdf/AnleitungPROJECTCloud.pdf" target="_blank" class="home-cloud-pdf-button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Anleitung (PDF)</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="column wlan-container is-3-fullhd is-8-tablet is-10-touch">
			<div class="home-cloud-title">
				<i class="fa fa-wifi"></i>Gäste-WLAN
			</div>
			<div class="home-cloud-subtitle">
				Geschützter Internet-Zugang für Besucher:
			</div>
			<div class="home-cloud-subtitle">
				<span style="color: #4a4a4a;">Netzwerk: </span>{{ $wlan->name }}
			</div>
			<div class="home-cloud-subtitle">
				<span style="color: #4a4a4a;">Passwort: </span>{{ $wlan->password }}
			</div>
		</div>
	</div>
</div>
@endsection

@section('content.js')
<script src="{{ asset('js/custombox/custombox.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/custombox/custombox.legacy.min.js') }}" type="text/javascript" charset="utf-8"></script>
@endsection
