$( document ).ready(function() {
	$('.news-image-wrap').on('click', function(e){
		
		var modal = new Custombox.modal({
			content: {
				effect: 'blur',
				target: '.modal-news-image',
			}
		});
		
		modal.open();
	});

	$('.faq-employee-mail').on('click',function(e){
		var email = $(this).data('email');

		var modal = new Custombox.modal({
			content: {
				effect: 'blur',
				target: '.modal-faq-employee-container',
			}
		});
		
		modal.open();

		$.ajax({
			type: 'POST',
			url: '/employees/getEmployeeByEmail',
			dataType: 'json',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			data: { 'email': email }
		})
		.done(function(data){
			var imageSRC = ((data.thumbnailphoto) ? 'data:image/jpeg;base64, ' + data.thumbnailphoto : '/images/profile-image-example.png');
			
			var phone = ((data.telephonenumber) ? data.telephonenumber : '-');
			phone = phone.toLowerCase();

			var mail = ((data.mail) ? data.mail : '-');
			mail = mail.toLowerCase();

			$('.imageModalEmployee').css('background', 'url("'+ imageSRC +'")');

			$('.modal-container .spanName').text(data.cn);
			$('.modal-container .spanTitle').text(data.title);
			$('.modal-container .spanDepartment').text(data.department);
			$('.modal-container .spanLocation').text(data.streetaddress + ', ' + data.postalcode + ' ' + data.l);
			$('.modal-container .spanCompany').text(data.company);
			
			$('.modal-container .spanPhone').text(phone);
			if(phone != '-'){
				$('.modal-container .spanPhone').attr('href', 'tel:'+phone);
			}

			$('.modal-container .spanEmail').text(mail).attr('href', 'mailto:'+mail);
			if(mail != '-'){
				$('.modal-container .spanMail').attr('href', 'mailto:'+mail);
			}
		});
	});

	$('.support-radio-button').on('click', function() {
		var email = $(this).data('email');
		$('.support-email-field').prop("disabled", true).val(email);
		$('.support-send-button').prop("disabled", false).css("background", "#F29400").css("color", "white");
		$('.support-email-check').hide().show();
	});

	$('.category-option-span').on('click', function() {
		var dataValue = $(this).data('value');
		$('.support-container-form').css('display', 'none');
		$('.support-container-form form')[0].reset();
		$( ".support-container-answers" ).fadeIn("fast");
		$('.support-container-answers .answer').removeClass('active');
		$('.faq-fragen').hide();

		if(dataValue == 'faq'){

			$('.wallpaper-service').css('background-image', 'url(/images/bg_faq.jpg)');
			$('.documents-search-title').hide().html('Haben Sie eine Frage?').show();
			$('.documents-search-description').hide().html('Antworten auf die häufigsten Fragen und nützliche Informationen zum Arbeitsalltag').show();
			$('.searchbar-field2').hide();
			$('.searchbar-span2').hide();
			$('.chosen-container').hide();
			$('.category-chose-span').hide();
			$('.documents-container').hide();
			$('.faq-container').hide().fadeIn(1000);
			$('.searchbar-field-faq').hide().show();
			$('.searchbar-span-faq').hide().show();
			$('.wallpaper-service-faq').hide().show();
			$('.support-container').hide();
			$('.support-email-field').prop("disabled", true).val('');
			$('.support-send-button').prop("disabled", true).css("background", "#EBEBE4").css("color", "black");
			$('.support-email-check').hide();
			$('.support-radio-button').prop('checked',false);
			$('.feedback-container').hide();
			$('.faqSearchInput').hide().show();
			$('.faqSearchInputField').val('');
			$('.faqSearchInput .searchbar-span2').hide().show();
			$('.searchbar-document-wrap2').hide();

		} else if(dataValue == 'documents'){

			$('.documents-search-title').hide().html('Dokumentensuche').show();
			$('.documents-search-description').hide().html('Vorlagen, Anleitungen und wichtige Informationen zum Download').show();
			$('.searchbar-field-faq').hide();
			$('.searchbar-span-faq').hide();
			$('.faq-container').hide();
			$('.documents-container').hide().fadeIn(1000);
			$('.searchbar-field2').hide().show();
			$('.searchbar-span2').hide().show();
			$('.chosen-container').hide().show();
			$('.category-chose-span').hide().show();
			$('.wallpaper-service').css('background-image', 'url(/images/bg_dokumente.jpg)');
			$('.wallpaper-service').css('background-position-y', 'center');
			$('.wallpaper-service-faq').hide();
			$('.support-container').hide();
			$('.support-email-field').prop("disabled", true).val('');
			$('.support-send-button').prop("disabled", true).css("background", "#EBEBE4").css("color", "black");
			$('.support-email-check').hide();
			$('.support-radio-button').prop('checked',false);
			$('.feedback-container').hide();
			$('.faqSearchInput').hide();
			$('.faqSearchInput .searchbar-span2').hide();

		} else if(dataValue == 'support'){

			$('.support-container-form-title').hide().fadeIn(1000);
			$('.support-container-form-title2').hide();
			$('#support-form')[0].reset();
			$('#support-form').hide().fadeIn(1000);
			$('.wallpaper-service').css('background-image', 'url(/images/bg_support.jpg)');
			$('.documents-search-title').hide().html('Support').show();			
			$('.documents-search-description').hide().html('Benötigen Sie technische Unterstützung oder haben eine Frage, auf die Sie im Intranet noch keine Antwort gefunden haben? Unserer Support hilft Ihnen gerne weiter!').show();
			$('.searchbar-field2').hide();
			$('.searchbar-span2').hide();
			$('.chosen-container').hide();
			$('.category-chose-span').hide();
			$('.faq-container').hide();
			$('.searchbar-field-faq').hide();
			$('.searchbar-span-faq').hide();
			$('.wallpaper-service-faq').hide();
			$('.documents-container').hide();
			$('.support-container').hide().fadeIn(1000);
			$('.feedback-container').hide();
			$('.faqSearchInput').hide();
			$('.faqSearchInput .searchbar-span2').hide();

		} else if(dataValue == 'feedback'){

			$('.feedback-container-form-title').text('FEEDBACK');
			$('#feedback-form')[0].reset();
			$('#feedback-form').hide().fadeIn(1000);
			$('.documents-search-title').hide().html('Feedback').show();
			$('.documents-search-description').hide().html('Helfen Sie mit, das Intranet noch besser zu machen. Wir freuen uns auf Ihr Feedback!').show();
			$('.feedback-container').hide().fadeIn(1000);
			$('.searchbar-field2').hide();
			$('.searchbar-span2').hide();
			$('.chosen-container').hide();
			$('.category-chose-span').hide();
			$('.faq-container').hide();
			$('.searchbar-field-faq').hide();
			$('.searchbar-span-faq').hide();
			$('.wallpaper-service-faq').hide();
			$('.documents-container').hide();
			$('.support-container').hide();
			$('.faqSearchInput').hide();
			$('.faqSearchInput .searchbar-span2').hide();
		}

		$('.category-option-is-active').removeClass('category-option-is-active');
		$(this).addClass('category-option-is-active');
	});

$('.zu-it-faq-link').on('click', function(){
	$('.faq-bueroorganisation-fragen').hide();
	$('.faq-it-fragen').hide().fadeIn(1000);
	$('.category-option-is-active').removeClass('category-option-is-active');
	$('.category-option-2').addClass('category-option-is-active');
});

$('.zu-support-faq-link').on('click', function(){
	$('.documents-search-title').hide().html('Support').show();			
	$('.documents-search-description').hide().html('Benötigen Sie technische Unterstützung oder haben eine Frage, auf die Sie im Intranet noch keine Antwort gefunden haben? Unserer Support hilft Ihnen gerne weiter!').show();
	
	$('.support-container-form-title').hide().fadeIn(1000);
	$('.support-container-form-title2').hide();
	$('#support-form').fadeIn(1000);
	$('#support-form')[0].reset();

	$('.feedback-container').hide();
	$('.support-container-form').hide();
	$( ".support-container-answers" ).fadeIn("fast");
	$('.faq-fragen').hide();
	$('.support-container-answers .answer').removeClass('active');
	$('.support-container').hide().fadeIn(1000);
	$('.category-option-is-active').removeClass('category-option-is-active');
	$('.category-option-3').addClass('category-option-is-active');
});

$('.zu-feedback-faq-link').on('click', function(){

	$('.documents-search-title').hide().html('Feedback').show();
	$('.documents-search-description').hide().html('Helfen Sie mit, das Intranet noch besser zu machen. Wir freuen uns auf Ihr Feedback!').show();

	$('.feedback-container-form-title').text('FEEDBACK');
	$('#feedback-form')[0].reset();
	$('#feedback-form').hide().fadeIn(1000);

	$('.support-container').hide();
	$('.feedback-container').hide().fadeIn(1000);
	$('.category-option-is-active').removeClass('category-option-is-active');
	$('.category-option-4').addClass('category-option-is-active');
});

$('.doc-help-button').on('click', function(){

	$('.category-option-is-active').removeClass('category-option-is-active');
	$('.category-option-3').addClass('category-option-is-active');
	$('.wallpaper-service').css('background-image', 'url(/images/bg_support.jpg)');
	$('.documents-search-title').hide().html('Support').show();			
	$('.documents-search-description').hide().html('Hast du fragen?').show();
	$('.searchbar-field2').hide();
	$('.searchbar-span2').hide();
	$('.chosen-container').hide();
	$('.category-chose-span').hide();
	$('.faq-container').hide();
	$('.searchbar-field-faq').hide();
	$('.searchbar-span-faq').hide();
	$('.wallpaper-service-faq').hide();
	$('.documents-container').hide();
	$('.support-container').hide().fadeIn(1000);

});

$('.doc-category-span').on('click', function(){
	var categoryId = $(this).data('id');

	if(categoryId == 0){
		$('.doc-subcategory-div').removeClass('subcategory-active');
		getAllDocuments();
	}

	if($(this).hasClass('active')){
		$(this).removeClass('active');
		$('.doc-subcategory-'+categoryId).slideUp();

	} else {
		$('.doc-category-span').removeClass('active');
		$(this).addClass('active');
		$('.doc-subcategory-div').slideUp();
		$('.doc-subcategory-'+categoryId).slideToggle();
	}
});

$('.category-change-chosen').on('click', function(){
	var name = $(this).data('name');
	$('#documents_search_chosen_chosen a span').text(name);
});

$(document).on("click","#documents_search_chosen_chosen li.active-result",function(){
	var categoryName = $(this).text();
	categoryName.replace(/\s/g, '');
	getDocumentsByCategoryName(categoryName);

	$('.searchbar-field2').val('');
});

$(document).on("click","#gallery_location_search_chosen_chosen li.active-result",function(){
	var location = $(this).text();
	if(location != 'Alle Events'){
		if(location == 'Weihnachtsfeier Berlin'){
			location = 'Weihnachtsfeier-Berlin';
		}
		if(location == 'Weihnachtsfeier Nürnberg'){
			location = 'Weihnachtsfeier-Nürnberg';
		}
		window.location.href = "/bildergalerien/"+location;
	} else {
		window.location.href = "/bildergalerien";
	}
});

$("#gallery_location_search_chosen_chosen").bind('keyup',function(e) {
	if(e.which === 13) {
		var location = $('#gallery_location_search_chosen_chosen a span').html();
		if(location != 'Alle Events'){
			if(location == 'Weihnachtsfeier Berlin'){
				location = 'Weihnachtsfeier-Berlin';
			}
			if(location == 'Weihnachtsfeier Nürnberg'){
				location = 'Weihnachtsfeier-Nürnberg';
			}
			window.location.href = "/bildergalerien/"+location;
		} else {
			window.location.href = "/bildergalerien";
		}
	} 
});

$(document).on("click","#documents_categories_search_chosen_chosen li.active-result",function(){
	var category = $(this).text();
	if(category != 'Alle Kategorien'){
		window.location.href = "/projectintern/"+category;
	} else {
		window.location.href = "/projectintern";
	}
});

$("#documents_categories_search_chosen_chosen").bind('keyup',function(e) {
	if(e.which === 13) {
		var category = $('#documents_categories_search_chosen_chosen a span').html();
		if(category != 'Alle Kategorien'){
			window.location.href = "/projectintern/"+category;
		} else {
			window.location.href = "/projectintern";
		}
	} 
});



$(".doc-category-span2").on('click', function(){
	$('.doc-subcat-divs').slideToggle();
});

$('.doc-subcat-div').on('click', function(){
	city = $(this).data('value');
	getDocumentsByCityAndTelefon(city);
});

$( "#feedback-form" ).submit(function( event ) {

	var data = {
		'name' : $('#feedback-form').find('input[name="name"]').val(),
		'body' : $('#feedback-form').find('textarea[name="body"]').val(),
	};

	$.ajax({
		type: 'POST',
		url: '/service/sendFeedbackEmail',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'value': data }
	})

	.done(function(data){
		if(data){
			$('.feedback-container-form-title').text('Nachricht wurde gesendet. Vielen Dank für Ihr Feedback!');
			$('#feedback-form').hide();
		}
	});

	event.preventDefault();
});

$( "#support-form" ).submit(function( event ) {

	var data = {
		'email' : $('#support-form').find('input[name="email"]').val(),
		'name' : $('#support-form').find('input[name="name"]').val(),
		'body' : $('#support-form').find('textarea[name="body"]').val(),
	};

	$.ajax({
		type: 'POST',
		url: '/service/sendSupportEmail',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'value': data }
	})

	.done(function(data){
		if(data){
			$('.support-container-form-title').hide();
			$('.support-container-form-title2').text('Nachricht wurde gesendet. Vielen Dank für Ihre Anfrage!').fadeIn(1000);
			$('#support-form').hide();
		}
	});

	event.preventDefault();
});

$('.doc-category-span ').on('click', function(){
	var categoryName = $(this).text();
	categoryName.replace(/\s/g, '');
	getDocumentsByCategoryName(categoryName);
});

$('#documents_search_chosen_chosen').on("click",function(){
	$('.searchbar-document-wrap').hide();
});

$("#documents_search_chosen_chosen").bind('keyup',function(e) {
	if(e.which === 13) {
		var categoryName = $('#documents_search_chosen_chosen a span').html();
		categoryName.replace(/\s/g, '');
		getDocumentsByCategoryName(categoryName);

		$('.searchbar-field2').val('');
	} else {
		if($('.active-result').hasClass('result-selected')){
			$('.active-result').removeClass('result-selected');
		} 
	}

});

$(".searchbar-field2").on('input', function(e) {
	var value = $(this).val();

	if(value.length >= 3){
		getAllDocumentsWithValueAndPopupList(value);
	} else {
		$('.searchbar-document-wrap').hide();
	}
});

$(".searchbar-field2").on('focus', function(e) {
	var value = $(this).val();

	if(value.length >= 3){
		getAllDocumentsWithValueAndPopupList(value);
	} else {
		$('.searchbar-document-wrap').hide();
	}
});

$(".faqSearchInputField").on('input', function(e) {
	var value = $(this).val();

	if(value.length >= 3){
		getAllFAQsWithValueAndPopupList(value);
	} else {
		$('.searchbar-document-wrap2').hide();
	}
});

$(".faqSearchInputField").on('focus', function(e) {
	var value = $(this).val();

	if(value.length >= 3){
		getAllFAQsWithValueAndPopupList(value);
	} else {
		$('.searchbar-document-wrap2').hide();
	}
});

$(document).on('click', '.more-document-results', function(){
	var documentValue = $(this).data('value');
	getAllDocumentsWithValue(documentValue);
	$('.searchbar-document-wrap').hide();
	$('#documents_search_chosen_chosen a span').text('Kategorie wählen');
});

$(document).on('click', '.searchbar-document-result', function(){
	var documentId = $(this).data('id');
	getDocumentWithId(documentId);
	$('.searchbar-document-wrap').hide();
	$('#documents_search_chosen_chosen a span').text('Kategorie wählen');
});

$('.searchbar-span2').on('click', function(){
	var value = $('.searchbar-field2').val();
	getAllDocumentsWithValue(value);
	$('.searchbar-document-wrap').hide();
	$('#documents_search_chosen_chosen a span').text('Kategorie wählen');
});

$(window).click(function() {
	$('.searchbar-document-wrap').hide();
});



$(".searchbar-field2").bind('keyup',function(e) {
	if(e.which === 13) 
	{
		var value = $('.searchbar-field2').val();
		getAllDocumentsWithValue(value);

		$('.searchbar-document-wrap').hide();
		$('#documents_search_chosen_chosen a span').text('Kategorie wählen');
	} 
});
});

function getDocumentWithId(documentId){
	$('.pagination').hide();
	$('.loading-container').show();

	$('.divTableCell').slideUp();
	setTimeout(function(){
		$('.divTableBody').html('');
	}, 500);

	$.ajax({
		type: 'POST',
		url: '/service/getDocumentWithId',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'documentId': documentId }
	})
	.done(function(data){
		if(data.length > 0){
			$.each(data, function(index, value){
				var valuePFAD = value.pfad;
				var imageExtension = valuePFAD.substr(valuePFAD.length - 3);
				setTimeout(function(){
					$('.divTableBody').append(
						'<div class="divTableRow">' +
						'<a href="' + value.pfad + '" target="_blank">'+
						'<div class="divTableCell hidden">' +
						'<div>' +
						'<img class="documents-pdf-image" src="/images/' + imageExtension + '.png">' +
						'</div>' +
						'<div class="documents-pdf-name">' +
						value.name +
						'</div>' +
						'<div class="documents-pdf-date">' +
						value.groesse +
						'Kb' +
						'</div>' +
						'</div>' +
						'</a>' +
						'</div>'
						);
				}, 1000);
			});
		} else {
			setTimeout(function(){
				$('.divTableBody').append('<div class="employees-no-results"> Es konnten keine passenden Dokumente gefunden werden! <br> Bitte versuchen Sie es mit einem anderen Suchbegriff oder wählen Sie eine Kategorie aus. </div>');
			}, 1000);
		}

		setTimeout(function(){
			$('.divTableCell').slideToggle();
			$('.loading-container').hide();
			$('.divTableCell').css('display','flex');
		}, 1000);
	});
}

function getDocumentsByCityAndTelefon(city){


	$('.documents-container-description').html('Telefonanleitungen');

	$('.pagination').hide();
	$('.loading-container').show();

	$('.divTableCell').slideUp();
	setTimeout(function(){
		$('.divTableBody').html('');
	}, 500);

	$.ajax({
		type: 'POST',
		url: '/service/getDocumentsByCityAndTelefon',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'city': city }
	})
	.done(function(data){
		if(data.length > 0){
			$('.documents-container-telefon').html('Bitte beachten Sie, dass die jeweilige Anleitung NUR am angegebenen Bürostandort gültig ist. Wählen Sie daher die passende Anleitung für Ihren Bürostandort aus.');
			$.each(data, function(index, value){
				var valuePFAD = value.pfad;
				var imageExtension = valuePFAD.substr(valuePFAD.length - 3);
				setTimeout(function(){
					$('.divTableBody').append(
						'<div class="divTableRow">' +
						'<a href="' + value.pfad + '" target="_blank">'+
						'<div class="divTableCell hidden">' +
						'<div>' +
						'<img class="documents-pdf-image" src="/images/' + imageExtension + '.png">' +
						'</div>' +
						'<div class="documents-pdf-name">' +
						value.name +
						'</div>' +
						'<div class="documents-pdf-date">' +
						value.groesse +
						'Kb' +
						'</div>' +
						'</div>' +
						'</a>' +
						'</div>'
						);
				}, 1000);
			});
		} else {
			setTimeout(function(){
				$('.divTableBody').append('<div class="employees-no-results"> Es konnten keine passenden Dokumente gefunden werden! <br> Bitte versuchen Sie es mit einem anderen Suchbegriff oder wählen Sie eine Kategorie aus. </div>');
			}, 1000);
		}

		setTimeout(function(){
			$('.divTableCell').slideToggle();
			$('.loading-container').hide();
			$('.divTableCell').css('display','flex');
		}, 1000);
	});
}

function getAllDocumentsWithValue(givenValue){
	var page = findGetParameter('page');
	var url = null;

	if(givenValue == 0){
		url = '/service/getAllDocuments?page=' + page;
	} else {
		url = '/service/getAllDocumentsLikeValue';
	}

	$('.divTableCell').slideUp();
	$('.pagination').hide();
	$('.loading-container').show();
	setTimeout(function(){
		$('.divTableBody').html('');
	}, 500);

	$.ajax({
		type: 'POST',
		url: url,
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'value': givenValue }
	})
	.done(function(data){
		if(data.data.length > 0){
			$.each(data.data, function(index, value){
				var valuePFAD = value.pfad;
				var imageExtension = valuePFAD.substr(valuePFAD.length - 3);
				setTimeout(function(){
					$('.divTableBody').append(
						'<div class="divTableRow">' +
						'<a href="' + value.pfad + '" target="_blank">'+
						'<div class="divTableCell hidden">' +
						'<div>' +
						'<img class="documents-pdf-image" src="/images/' + imageExtension + '.png">' +
						'</div>' +
						'<div class="documents-pdf-name">' +
						value.name +
						'</div>' +
						'<div class="documents-pdf-date">' +
						value.groesse +
						'Kb' +
						'</div>' +
						'</div>' +
						'</a>' +
						'</div>'
						);
				}, 1000);
			});
		} else {
			setTimeout(function(){
				$('.divTableBody').append('<div class="employees-no-results"> Es konnten keine passenden Dokumente gefunden werden! <br> Bitte versuchen Sie es mit einem anderen Suchbegriff oder wählen Sie eine Kategorie aus. </div>');
			}, 1000);
		}

		setTimeout(function(){
			$('.divTableCell').slideToggle();
			$('.loading-container').hide();
			$('.divTableCell').css('display','flex');

			if(givenValue == 0){
				$('.pagination').show();
			}
		}, 1000);
	});
}

function getAllDocumentsWithValueAndPopupList(givenValue){

	$('.pagination').hide();

	var data = [];
	$.ajax({
		type: 'POST',
		url: '/service/getAllDocumentsLikeValueFirst5',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'value': givenValue }
	})
	.done(function(data){
		var docs = data.documents;
		var total = data.total;
		if(docs.length > 0){
			$('.searchbar-document-wrap').html('');
			$('.searchbar-document-wrap').append('<ul class="searchbar-document-list">');
			$.each(docs, function(index, value){
				$('.searchbar-document-list').append('<li class="searchbar-document-result searchbar-document-result-' + value.id + '" data-id="'+ value.id + '">' + value.name + '</li>');
				highlight(givenValue, value.id);
			});
			if(total > 5){
				$('.searchbar-document-list').append('<li class="more-document-results" data-value="' + givenValue + '  " style="background: white !important; color: #F29400 !important">... weitere Ergebnisse anzeigen</li>');
			}
			$('.searchbar-document-wrap').append('</ul>');

			$('.searchbar-document-wrap').show();

		}else{
			$('.searchbar-document-wrap').html('');
			$('.searchbar-document-wrap').append('<ul class="ceva">');
			$('.ceva').append('<li> Keine Ergebnisse </li>');
			$('.searchbar-document-wrap').append('</ul>');

			$('.searchbar-document-wrap').show();
		}
	});
}

function getAllFAQsWithValueAndPopupList(givenValue){

	$('.pagination').hide();

	var data = [];
	$.ajax({
		type: 'POST',
		url: '/service/getAllDocumentsLikeValueFirst5',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'value': givenValue }
	})
	.done(function(data){
		var docs = data.documents;
		var total = data.total;
		if(docs.length > 0){
			$('.searchbar-document-wrap2').html('');
			$('.searchbar-document-wrap2').append('<ul class="searchbar-document-list">');
			$.each(docs, function(index, value){
				$('.searchbar-document-list').append('<li class="searchbar-document-result searchbar-document-result-' + value.id + '" data-id="'+ value.id + '">' + value.name + '</li>');
				highlight(givenValue, value.id);
			});
			if(total > 5){
				$('.searchbar-document-list').append('<li class="more-document-results" data-value="' + givenValue + '  " style="background: white !important; color: #F29400 !important">... weitere Ergebnisse anzeigen</li>');
			}
			$('.searchbar-document-wrap2').append('</ul>');

			$('.searchbar-document-wrap2').show();

		}else{
			$('.searchbar-document-wrap2').html('');
			$('.searchbar-document-wrap2').append('<ul class="ceva">');
			$('.ceva').append('<li> Keine Ergebnisse </li>');
			$('.searchbar-document-wrap2').append('</ul>');

			$('.searchbar-document-wrap2').show();
		}
	});
}

function getDocumentsByCategoryAndSubcategory(categoryId, subCategoryId){
	$('.pagination').hide();
	$('.loading-container').show();

	var page = findGetParameter('page');
	var url = null;

	if(subCategoryId == 0){
		if(page == null){
			url = '/service/'+categoryId+'/'+subCategoryId;
		} else {
			url = '/service/getAllDocuments?page=' + page;
		}
	} else {
		url = '/service/'+categoryId+'/'+subCategoryId;
	}

	$('.divTableCell').slideUp();
	setTimeout(function(){
		$('.divTableBody').html('');
	}, 500);

	$.ajax({
		url: url
	})
	.done(function(data){
		$.each(data.data, function(index, value){
			var valuePFAD = value.pfad;
			var imageExtension = valuePFAD.substr(valuePFAD.length - 3);
			setTimeout(function(){
				$('.divTableBody').append(
					'<div class="divTableRow">' +
					'<a href="' + value.pfad + '" target="_blank">'+
					'<div class="divTableCell hidden">' +
					'<div>' +
					'<img class="documents-pdf-image" src="/images/' + imageExtension + '.png">' +
					'</div>' +
					'<div class="documents-pdf-name">' +
					value.name +
					'</div>' +
					'<div class="documents-pdf-date">' +
					value.groesse +
					'Kb' +
					'</div>' +
					'</div>' +
					'</a>' +
					'</div>'
					);
			}, 1000);
		});

		setTimeout(function(){
			$('.divTableCell').slideToggle();
			$('.loading-container').hide();
			$('.divTableCell').css('display','flex');

			if(subCategoryId == 0){
				$('.pagination').show();
			}
		}, 1000);
	});
};

function getDocumentsByCategoryName(categoryName){

	$('.documents-container-telefon').html('');
	$('.pagination').hide();
	$('.loading-container').show();

	var page = findGetParameter('page');
	var url = null;

	if(categoryName == 'Meisgenutzte Dokumente' || categoryName == 'Alle Dokumente'){
		$('.documents-container-description').html('Meisgenutzte Dokumente');
		if(page == null){
			window.location.href = "/dokumente-support/viewAllDocuments";
		} else {
			var subCategoryId = 0;
			url = '/service/getAllDocuments?page=' + page;
		}
	} else {
		$('.documents-container-description').html(categoryName);
		url = '/service/0/'+categoryName;
	}

	$('.divTableCell').slideUp();
	setTimeout(function(){
		$('.divTableBody').html('');
	}, 500);

	$.ajax({
		url: url
	})
	.done(function(data){
		if(data.data.length > 0){
			$.each(data.data, function(index, value){
				var valuePFAD = value.pfad;
				var imageExtension = valuePFAD.substr(valuePFAD.length - 3);
				setTimeout(function(){
					$('.divTableBody').append(
						'<div class="divTableRow">' +
						'<a href="' + value.pfad + '" target="_blank">'+
						'<div class="divTableCell hidden">' +
						'<div>' +
						'<img class="documents-pdf-image" src="/images/' + imageExtension + '.png">' +
						'</div>' +
						'<div class="documents-pdf-name">' +
						value.name +
						'</div>' +
						'<div class="documents-pdf-date">' +
						value.groesse +
						'Kb' +
						'</div>' +
						'</div>' +
						'</a>' +
						'</div>'
						);
				}, 1000);
			});
		} else {
			setTimeout(function(){
				$('.divTableBody').append('<div class="employees-no-results"> Es konnten keine passenden Dokumente gefunden werden! <br> Bitte versuchen Sie es mit einem anderen Suchbegriff oder wählen Sie eine Kategorie aus. </div>');
			}, 1000);
		}

		setTimeout(function(){
			$('.divTableCell').slideToggle();
			$('.loading-container').hide();
			$('.divTableCell').css('display','flex');

			if(subCategoryId == 0){
				$('.pagination').show();
			}
		}, 1000);
	});
};
function getAllDocuments(){
	
	var page = findGetParameter('page');

	if(page == null){
		url = '/service/getAllDocuments';
	} else {
		url = '/service/getAllDocuments?page=' + page;
	}

	$('.loading-container').show();

	$('.divTableCell').slideUp();
	setTimeout(function(){
		$('.divTableBody').html('');
	}, 500);

	$.ajax({
		url: url,
	})
	.done(function(data){
		if(data.data.length > 0){
			$.each(data.data, function(index, value){
				var valuePFAD = value.pfad;
				var imageExtension = valuePFAD.substr(valuePFAD.length - 3);
				setTimeout(function(){
					$('.divTableBody').append(
						'<div class="divTableRow">' +
						'<a href="' + value.pfad + '" target="_blank">'+
						'<div class="divTableCell hidden">' +
						'<div>' +
						'<img class="documents-pdf-image" src="/images/' + imageExtension + '.png">' +
						'</div>' +
						'<div class="documents-pdf-name">' +
						value.name +
						'</div>' +
						'<div class="documents-pdf-date">' +
						value.groesse +
						'Kb' +
						'</div>' +
						'</div>' +
						'</a>' +
						'</div>'
						);
				}, 1000);
			});

		} else {
			setTimeout(function(){
				$('.divTableBody').append('<div class="employees-no-results"> Es konnten keine passenden Dokumente gefunden werden! <br> Bitte versuchen Sie es mit einem anderen Suchbegriff oder wählen Sie eine Kategorie aus. </div>');
			}, 1000);
		}

		setTimeout(function(){
			$('.divTableCell').slideToggle();
			$('.loading-container').hide();
			$('.divTableCell').css('display','flex');
			$('.pagination').show();
		}, 1000);
	});
}

function highlight(text, id)
{
	inputText = $('.searchbar-document-result-'+id);
	var innerHTML = inputText.html();
	var innerHTMLMinimized = inputText.html().toLowerCase();
	var textMinimized = text.toLowerCase();
	var index = innerHTMLMinimized.indexOf(textMinimized);
	if ( index >= 0 )
	{ 
		innerHTML = innerHTML.substring(0,index) + "<span class='highlight2'>" + innerHTML.substring(index,index+text.length) + "</span>" + innerHTML.substring(index + text.length);
		inputText.html(innerHTML);
	}
}

function getDocumentsBySubcategory(subCategoryId){
	$('.documents-container-telefon').html('');

	$('.divTableCell').slideUp();
	$('.loading-container').show();
	setTimeout(function(){
		$('.divTableBody').html('');
	}, 500);

	$.ajax({
		url: '/service/0/' + subCategoryId
	})
	.done(function(data){
		data = $.parseJSON(data);
		if(data.length > 0){
			$.each(data, function(index, value){

				setTimeout(function(){
					$('.divTableBody').append(
						'<div class="divTableRow">' +
						'<a href="' + value.pfad + '" target="_blank">'+
						'<div class="divTableCell hidden">' +
						'<div>' +
						'<img class="documents-pdf-image" src="/images/pdf2.png">' +
						'</div>' +
						'<div class="documents-pdf-name">' +
						value.name +
						'</div>' +
						'<div class="documents-pdf-date">' +
						value.groesse +
						'Kb' +
						'</div>' +
						'</div>' +
						'</a>' +
						'</div>'
						);
				}, 1000);
			});

		} else {
			setTimeout(function(){
				$('.divTableBody').append('<div class="employees-no-results"> Es konnten keine passenden Dokumente gefunden werden! <br> Bitte versuchen Sie es mit einem anderen Suchbegriff oder wählen Sie eine Kategorie aus. </div>');
			}, 1000);
		}

		setTimeout(function(){
			$('.divTableCell').slideToggle();
			$('.loading-container').hide();
			$('.divTableCell').css('display','flex');
		}, 1000);
	});
}

function findGetParameter(parameterName) {
	var result = null,
	tmp = [];
	var items = location.search.substr(1).split("&");
	for (var index = 0; index < items.length; index++) {
		tmp = items[index].split("=");
		if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
	}
	return result;
}

$('.faq-it-fragenX').on('click', function(){
	$('.faq-fragen').hide();
	$('.faq-it-fragen').hide().fadeIn(1000);
});

$('.faq-bueroorganisation-fragenX').on('click', function(){
	$('.faq-fragen').hide();
	$('.faq-bueroorganisation-fragen').hide().fadeIn(1000);
});

$('.faq-personal-fragenX').on('click', function(){
	$('.faq-fragen').hide();
	$('.faq-personal-fragen').hide().fadeIn(1000);
});

$('.faq-facilityManagement-fragenX').on('click', function(){
	$('.faq-fragen').hide();
	$('.faq-facilityManagement-fragen').hide().fadeIn(1000);
});

$('.faq-reisestelle-fragenX').on('click', function(){
	$('.faq-fragen').hide();
	$('.faq-reisestelle-fragen').hide().fadeIn(1000);
});

$('.faq-fuhrpark-fragenX').on('click', function(){
	$('.faq-fragen').hide();
	$('.faq-fuhrpark-fragen').hide().fadeIn(1000);
});

$('.faq-datenschutz-fragenX').on('click', function(){
	$('.faq-fragen').hide();
	$('.faq-datenschutz-fragen').hide().fadeIn(1000);
});

var $topRightNav = $(document).find('.nav-right.nav-menu');

$(document).find('.navbar-burger').click(function()
{

	$(this).toggleClass('is-active').next().toggleClass('is-active');
	$(this).toggleClass('is-active').next().toggleClass('is-active');
});

$(document).click(function(e)
{
	if ( ! $(e.target).closest('.h-top').length)
	{
		$(document).find('.navbar-burger').removeClass('is-active').next().removeClass('is-active');
		$topRightNav.css('height', '')
	}
});

document.addEventListener('touchmove', function(e)
{
	event = e.originalEvent || e;

	if (event.scale > 1)
	{
		event.preventDefault()
	}

}, false);

$('.documentsTable .divTableRow').on('click', function(e){
	updateClicksDocument($(this).data('documentid'));
});

function updateClicksDocument(documentId){
	$.ajax({
		type: 'POST',
		url: '/service/updateClicksDocument',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'id': documentId }
	});
}