@extends('layouts.app')

@section('content.css')
<link href="{{ asset('css/lightbox2/lightbox.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/custombox/custombox.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('slick/slick.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('slick/slick-theme.css') }}"/>
@endsection

@section('content.wallpaper-navbar')

@if(isset($news->youtube_url)) 
<iframe width="100%" height="440" src="https://www.youtube.com/embed/{{ $news->youtube_url }}?rel=0&autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
@else
<div class="wallpaper-news relative wallpaper-new-{{$news->id}}" id="lage-map" @if(isset($news->wallpaper_bild)) style="background-image: url('{{$news->wallpaper_bild}}')" @endif>
</div>
@endif

@endsection

@section('content')
<div class="container new-container wrap-container">
	<div class="columns is-centered is-mobile is-multiline">
		<div class="column is-7-tablet is-11-mobile ">
			<div class="new-header">
				<div class="new-title">
					{{ $news->titel }}
				</div>
				<div class="new-date">
					{{ date('d.m.Y', strtotime($news->datum)) }}
				</div>
			</div>
			<div class="new-subtitle">
				{!! nl2br($news->untertitel) !!}
			</div>
			<div class="new-description">
				{!! nl2br($news->meldung) !!}
			</div>
			@if($news->id == 144)
			@if(!$hasReviewed)
			<div>
				<form method="POST" action="{{ action('ReviewsController@addReview') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="question-title">1<span class="question-required">*</span>. Wie häufig nutzen Sie das Intranet?​</div>
					<div class="l-container">
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question1" id="q1a1" value="1" required>
								<span class="check_mark"></span>
								<label for="q1a1">Mehrmals täglich</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question1" id="q1a2" value="2" required>
								<span class="check_mark"></span>
								<label for="q1a2">Täglich</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question1" id="q1a3" value="3" required>
								<span class="check_mark"></span>
								<label for="q1a3">Mehrmals in der Woche</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question1" id="q1a4" value="4" required>
								<span class="check_mark"></span>
								<label for="q1a4">Einmal in der Woche</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question1" id="q1a5" value="5" required>
								<span class="check_mark"></span>
								<label for="q1a5">Gar nicht</label>
							</div>
						</div>
					</div>
					<div class="question-title">2<span class="question-required">*</span>. Welche Rubrik nutzen Sie regelmäßig? (Mehrfachnennungen sind möglich)​</div>
					<div class="l-container question2">
						<div class="l-checkbox">
							<div class="c-checkbox">
								<input type="checkbox" name="question2[]" id="q2a1" value="1" required>
								<span class="check_mark"></span>
								<label for="q2a1">PROJECT Intern (News)</label>
							</div>
						</div>
						<div class="l-checkbox">
							<div class="c-checkbox">
								<input type="checkbox" name="question2[]" id="q2a2" value="2" required>
								<span class="check_mark"></span>
								<label for="q2a2">Mitarbeiterübersicht</label>
							</div>
						</div>
						<div class="l-checkbox">
							<div class="c-checkbox">
								<input type="checkbox" name="question2[]" id="q2a3" value="3" required>
								<span class="check_mark"></span>
								<label for="q2a3">Dokumente</label>
							</div>
						</div>
						<div class="l-checkbox">
							<div class="c-checkbox">
								<input type="checkbox" name="question2[]" id="q2a4" value="4" required>
								<span class="check_mark"></span>
								<label for="q2a4">FAQs</label>
							</div>
						</div>
						<div class="l-checkbox">
							<div class="c-checkbox">
								<input type="checkbox" name="question2[]" id="q2a5" value="5" required>
								<span class="check_mark"></span>
								<label for="q2a5">Bildergalerien</label>
							</div>
						</div>
						<div class="l-checkbox">
							<div class="c-checkbox">
								<input type="checkbox" name="question2[]" id="q2a6" value="6" required>
								<span class="check_mark"></span>
								<label for="q2a6">Objekteindrücke</label>
							</div>
						</div>
					</div>
					<div class="question-title">3<span class="question-required">*</span>. Welche Rubrik nutzen Sie selten bis gar nicht? (Mehrfachnennungen sind möglich)</div>
					<div class="l-container question3">
						<div class="l-checkbox">
							<div class="c-checkbox">
								<input type="checkbox" name="question3[]" id="q3a1" value="1" required>
								<span class="check_mark"></span>
								<label for="q3a1">PROJECT Intern (News)</label>
							</div>
						</div>
						<div class="l-checkbox">
							<div class="c-checkbox">
								<input type="checkbox" name="question3[]" id="q3a2" value="2" required>
								<span class="check_mark"></span>
								<label for="q3a2">Mitarbeiterübersicht</label>
							</div>
						</div>
						<div class="l-checkbox">
							<div class="c-checkbox">
								<input type="checkbox" name="question3[]" id="q3a3" value="3" required>
								<span class="check_mark"></span>
								<label for="q3a3">Dokumente</label>
							</div>
						</div>
						<div class="l-checkbox">
							<div class="c-checkbox">
								<input type="checkbox" name="question3[]" id="q3a4" value="4" required>
								<span class="check_mark"></span>
								<label for="q3a4">FAQs</label>
							</div>
						</div>
						<div class="l-checkbox">
							<div class="c-checkbox">
								<input type="checkbox" name="question3[]" id="q3a5" value="5" required>
								<span class="check_mark"></span>
								<label for="q3a5">Bildergalerien</label>
							</div>
						</div>
						<div class="l-checkbox">
							<div class="c-checkbox">
								<input type="checkbox" name="question3[]" id="q3a6" value="6" required>
								<span class="check_mark"></span>
								<label for="q3a6">Objekteindrücke</label>
							</div>
						</div>
					</div>
					<div class="question-title">4<span class="question-required">*</span>. Wie gut entspricht das Intranet insgesamt Ihrem Bedarf?​</div>
					<div class="l-container">
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question4" id="q4a1" value="1" required>
								<span class="check_mark"></span>
								<label for="q4a1">Sehr gut</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question4" id="q4a2" value="2" required>
								<span class="check_mark"></span>
								<label for="q4a2">Gut</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question4" id="q4a3" value="3" required>
								<span class="check_mark"></span>
								<label for="q4a3">Mittelmäßig gut</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question4" id="q4a4" value="4" required>
								<span class="check_mark"></span>
								<label for="q4a4">Eher weniger gut</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question4" id="q4a5" value="5" required>
								<span class="check_mark"></span>
								<label for="q4a5">Gar nicht gut</label>
							</div>
						</div>
					</div>
					<div class="question-title">5<span class="question-required">*</span>. Wie einfach war es, im Intranet das zu finden, wonach Sie suchten?</div>
					<div class="l-container">
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question5" id="q5a1" value="1" required>
								<span class="check_mark"></span>
								<label for="q5a1">Sehr einfach</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question5" id="q5a2" value="2" required>
								<span class="check_mark"></span>
								<label for="q5a2">Einfach</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question5" id="q5a3" value="3" required>
								<span class="check_mark"></span>
								<label for="q5a3">Einigermaßen einfach</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question5" id="q5a4" value="4" required>
								<span class="check_mark"></span>
								<label for="q5a4">Eher schwierig</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question5" id="q5a5" value="5" required>
								<span class="check_mark"></span>
								<label for="q5a5">Schwierig</label>
							</div>
						</div>
					</div>
					<div class="question-title">6<span class="question-required">*</span>. Wie optisch attraktiv finden Sie das Intranet?​</div>
					<div class="l-container">
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question6" id="q6a1" value="1" required>
								<span class="check_mark"></span>
								<label for="q6a1">Sehr attraktiv</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question6" id="q6a2" value="2" required>
								<span class="check_mark"></span>
								<label for="q6a2">Attraktiv</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question6" id="q6a3" value="3" required>
								<span class="check_mark"></span>
								<label for="q6a3">Mittelmäßig attraktiv</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question6" id="q6a4" value="4" required>
								<span class="check_mark"></span>
								<label for="q6a4">Eher weniger attraktiv</label>
							</div>
						</div>
						<div class="l-radio">
							<div class="c-radio">
								<input type="radio" name="question6" id="q6a5" value="5" required>
								<span class="check_mark"></span>
								<label for="q6a5">Gar nicht attraktiv</label>
							</div>
						</div>
					</div>
					<div class="question-title">7<span class="question-required">*</span>. Wie wahrscheinlich ist es, dass Sie das Intranet Ihrer Kollegin oder Ihrem Kollegen weiterempfehlen werden?</div>
					<div class="star-rating">
						<fieldset>
							<input type="radio" id="star5" name="question7" value="5" required/><label for="star5" title="Sehr wahrscheinlich">5 stars</label>
							<input type="radio" id="star4" name="question7" value="4" required/><label for="star4" title="Ziemlich wahrscheinlich">4 stars</label>
							<input type="radio" id="star3" name="question7" value="3" required/><label for="star3" title="Wahrscheinlich">3 stars</label>
							<input type="radio" id="star2" name="question7" value="2" required/><label for="star2" title="Eher unwahrscheinlich">2 stars</label>
							<input type="radio" id="star1" name="question7" value="1" required/><label for="star1" title="Sehr unwahrscheinlich">1 star</label>
						</fieldset>
					</div>
					<div class="question-title">8. Haben Sie noch Ergänzungen zu Ihren Antworten? Oder möchten Sie generelles Lob, Wünsche oder Kritik loswerden?</div>
					<div>
						<textarea name="question8" style="width: 100%; height: 130px; margin: 0px; max-width: 100%; padding: 1rem; font-size: 18px;"></textarea>
					</div>
					<br>
					<div><button type="submit" class="news-button" style="border: none; cursor: pointer;font-size: 16px;padding: 12px 18px 12px;">Absenden</button></div>
				</form>
			</div>
			@else
			<div style="border: 2px solid #F29400; text-align: center; padding: 25px; font-size: 20px; color: #F29400; font-weight: bold;">Vielen Dank für Ihre Teilnahme!</div>
			@endif
			@endif
			<div class="buttons" style="float: none">
				@if($news->pdf_button_url)
				<a href="{{ $news->pdf_button_url }}" target="_blank" style="margin: 0 1rem 0 0">
					<button>
						@if($news->pdf_button_name)
						{{ $news->pdf_button_name }}
						@else
						ALS PDF LESEN
						@endif
					</button>
				</a>
				@endif

				@if($news->web_button_url)
				<a href="{{ $news->web_button_url }}" target="_blank" style="margin: 0 1rem 0 0">
					<button>
						@if($news->web_button_name)
							{{ $news->web_button_name }}
						@else
							@if(substr($news->web_button_url, 0, 7) == 'http://')
								{{ substr($news->web_button_url, 7) }}
							@elseif(substr($news->web_button_url, 0, 8) == 'https://')
								{{ substr($news->web_button_url, 8) }}
							@else
								{{ $news->web_button_url, 8 }}
							@endif
						@endif
					</button>
				</a>
				@endif
			</div>
			<div class="ba_to_over">
				<a href="{{ URL::previous() }}">
					<div class="circle"></div>
					<i class="fa fa-chevron-left fa-2x"></i>
					<p>Zurück zur Übersicht</p>		
				</a>
			</div>
		</div>
		<div class="column is-4-tablet  is-11-mobile news-pro-img">
			<a class="example-image-link" href="{{ $news->bild }}" data-lightbox="example-set" data-title="{{ $news->bild_unter }}"><img class="example-image" src="{{ $news->bild }}" alt=""/></a>

			<div class="new-image-desc">
				{!! nl2br($news->bild_unter) !!}</div>
			</div>
		</div>
	</div>
</div>


@endsection
<div style="display:none" class="modal-container modal-faq-employee-container">
	<div class="imageModalEmployee"></div>
	<div class="nameModalEmployee"><span>Name: </span><span class="spanName"></span></div>
	<div class="titleModalEmployee"><span>Titel: </span><span class="spanTitle"></span></div>
	<div class="departmentModalEmployee"><span>Abteilung: </span><span class="spanDepartment"></span></div>
	<div class="locationModalEmployee"><span>Ort: </span><span class="spanLocation"></span></div>
	<div class="companyModalEmployee"><span>Unternehmen: </span><span class="spanCompany"></span></div>
	<div class="phoneModalEmployee"><span>Telefon: </span><a class="phone-web spanPhone"></a></div>
	<div class="emailModalEmployee"><span>Email: </span><a class="mail-web spanEmail"></a></div>
</div>


@section('content.js')

@if($news->latitude AND $news->longitude) 
<script>
	var latitude = {{ $news->latitude }}; 
	var longitude = {{ $news->longitude }}; 
	var pinAddress = @if($news->pin_google) '{{ $news->pin_google }}' @else 'Neue Grundstück' @endif; 
</script>
<script src="//maps.googleapis.com/maps/api/js" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/googleMaps.js') }}" type="text/javascript" charset="utf-8"></script>
@endif
<script src="{{ asset('js/custombox/custombox.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/custombox/custombox.legacy.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/lightbox2/lightbox-plus-jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="{{ asset('slick/slick.js') }}"></script>
<script src="{{ asset('bootstrap/bootstrap.js') }}"></script>
<script>
	$('.new-description img').each(function(e){
		var a1 = $(this).prev();
		var a2 = $(this).before();
		if(this.src != 'https://intranet.project-immobilien.com/images/teamviewer_logo2.png'){
			$(this).replaceWith('<a class="example-image-link" data-lightbox="example-set" title="'+this.alt+'" href="'+this.src+'">'+'<img style="'+$(this).attr("style")+'" class="example-image" src="'+this.src+'">'+'</a>');
		}
	});
	$.ajax({
		type: 'GET',
		url: document.location+'/downloadImage',
	});
	$(function(){
		var requiredCheckboxes = $('.question2 :checkbox[required]');
		requiredCheckboxes.change(function(){
			if(requiredCheckboxes.is(':checked')) {
				requiredCheckboxes.removeAttr('required');
			} else {
				requiredCheckboxes.attr('required', 'required');
			}
		});

		var requiredCheckboxes2 = $('.question3 :checkbox[required]');
		requiredCheckboxes2.change(function(){
			if(requiredCheckboxes2.is(':checked')) {
				requiredCheckboxes2.removeAttr('required');
			} else {
				requiredCheckboxes2.attr('required', 'required');
			}
		});
	});
</script>
@endsection
