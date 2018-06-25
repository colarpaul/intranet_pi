$(document).on("click","#objects_search_chosen_chosen li.active-result",function(){
	var branch = $(this).text();
	branch = branch.trim();

	if(branch == "Alle Standorte"){
		branch = '';
	}

	var subCategoryId = $(this).data('option-array-index');
	if(subCategoryId == 1){
		$('.object-title-niederlassungen1').text('');
		$('.object-title-niederlassungen').text('');
	} else {
		$('.object-title-niederlassungen1').text(' aus ');
		$('.object-title-niederlassungen').text(branch);
	}
	
	getObjectsByBranch(branch);
	$('.searchbar-field2').val('');
});

$(".searchbar-field-objects").on('input', function(e) {
	var name = $(this).val();

	if(name.length >= 3){
		getAllObjectsWithNameAndPopupList(name);
	} else {
		$('.searchbar-document-wrap').hide();
	}
});

$(".searchbar-field-objects").on('focus', function(e) {
	var name = $(this).val();

	if(name.length >= 3){
		getAllObjectsWithNameAndPopupList(name);
	} else {
		$('.searchbar-document-wrap').hide();
	}
});

$(document).on('click', '.searchbar-objects-result', function(){
	var objectId = $(this).data('id');
	getObjectWithId(objectId);
	$('.searchbar-document-wrap').hide();
	$('#objects_search_chosen_chosen a span').text('Niederlassung wählen');
});

$('.searchbar-span-objects').on('click', function(){
	var name = $('.searchbar-field-objects').val();
	getObjectsByName(name);
	$('.searchbar-document-wrap').hide();
	$('#objects_search_chosen_chosen a span').text('Niederlassung wählen');
});

$(".searchbar-field-objects").bind('keyup',function(e) {
	if(e.which === 13) {
		
		$('.object-title-niederlassungen1').text('');
		$('.object-title-niederlassungen').text('');

		var name = $('.searchbar-field-objects').val();
		getObjectsByName(name);

		$('.searchbar-document-wrap').hide();
		$('#objects_search_chosen_chosen a span').text('Niederlassung wählen');
	} 
});

$('.object-category-span').on('click', function(){
	var categoryId = $(this).data('id');	

	if(categoryId == 0){
		getAllObjects();
		$('.object-title-niederlassungen1').text('');
		$('.object-title-niederlassungen').text('');
	} else {
		var categoryName = $(this).data('name');
		$('.object-title-niederlassungen1').text(' aus ');
		$('.object-title-niederlassungen').text(categoryName);
		getObjectsByBranch(categoryName);
	}

	// if($(this).hasClass('active')){
	// 	console.log('e activ');
	// 	$(this).removeClass('active');
	// 	$('.object-subcategory-'+categoryId).slideUp();

	// } else {
	// 	console.log('nu e activ');
	// 	$('.object-category-span').removeClass('active');
	// 	$(this).addClass('active');
	// 	$('.object-subcategory-div').slideUp();
	// 	$('.object-subcategory-'+categoryId).slideToggle();
	// }
});

$('.object-subcategory-div').on('click', function(){
	var city = $(this).data('city');

	$('.object-subcategory-div').removeClass('subcategory-active');
	$(this).addClass('subcategory-active');

	getObjectsByCity(city);
});

function getObjectWithId(objectId)
{
	$('.object-title-niederlassungen1').text('');
	$('.object-title-niederlassungen').text('');

	$('.divTableCell').slideUp();
	setTimeout(function(){
		$('.divTableBody').html('');
		$('.loading-container').show();
	}, 500);

	$.ajax({
		type: 'POST',
		url: '/objects/getObjectWithId',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'objectId': objectId }
	})
	.done(function(data){
		$.each(data, function(index, value){
			var valuePFAD = value.pfad;
			var imageExtension = valuePFAD.substr(valuePFAD.length - 3);
			var valueNiederlassung = (value.niederlassung == 'Frankfurt') ? 'Rhein-Main' : value.niederlassung;
			var valueStadt = (value.stadt == 'Frankfurt') ? 'Rhein-Main' : value.stadt;

			var valueDate = new Date(value.datum);
			day=valueDate.getDate();
			month=valueDate.getMonth();
			month=month+1;
			if((String(day)).length==1)
				day='0'+day;
			if((String(month)).length==1)
				month='0'+month;
			valueDate=day+ '.' + month + '.' + valueDate.getFullYear();
			
			setTimeout(function(){
				$('.divTableBody').append(
					'<div class="divTableRow">' +
					'<a href="' + value.pfad + '" target="_blank">'+
					'<div class="divTableCell hidden">' +
					'<div>' +
					'<img class="documents-pdf-image" src="/images/' + imageExtension + '.png">' +
					'</div>' +
					'<div class="documents-pdf-name">' +
					value.objekt + ' | ' + value.strasse + ', ' + value.plz + ' ' + value.stadt +
					'</div>' +
					'<div class="documents-pdf-date">' +
					'(' + valueDate + ') ' +
					valueNiederlassung +
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
		}, 1000);
	});
}

function getAllObjects()
{
	$('.divTableCell').slideUp();
	$('.pagination').hide();
	setTimeout(function(){
		$('.loading-container').show();
		$('.divTableBody').html('');
	}, 500);

	$.ajax({
		url: '/objects/getAllObjects',
		dataType: 'json',
	})
	.done(function(data){
		$.each(data, function(index, value){
			var valuePFAD = value.pfad;
			var imageExtension = valuePFAD.substr(valuePFAD.length - 3);
			var valueNiederlassung = (value.niederlassung == 'Frankfurt') ? 'Rhein-Main' : value.niederlassung;
			var valueStadt = (value.stadt == 'Frankfurt') ? 'Rhein-Main' : value.stadt;

			var valueDate = new Date(value.datum);
			day=valueDate.getDate();
			month=valueDate.getMonth();
			month=month+1;
			if((String(day)).length==1)
				day='0'+day;
			if((String(month)).length==1)
				month='0'+month;
			valueDate=day+ '.' + month + '.' + valueDate.getFullYear();
			
			setTimeout(function(){
				$('.divTableBody').append(
					'<div class="divTableRow">' +
					'<a href="' + value.pfad + '" target="_blank">'+
					'<div class="divTableCell hidden">' +
					'<div>' +
					'<img class="documents-pdf-image" src="/images/' + imageExtension + '.png">' +
					'</div>' +
					'<div class="documents-pdf-name">' +
					value.objekt + ' | ' + value.strasse + ', ' + value.plz + ' ' + value.stadt +
					'</div>' +
					'<div class="documents-pdf-date">' +
					'(' + valueDate + ') ' +
					valueNiederlassung +
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
		}, 1000);
	});
}

function getObjectsByCity(city)
{
	$('.divTableCell').slideUp();
	$('.pagination').hide();
	setTimeout(function(){
		$('.loading-container').show();
		$('.divTableBody').html('');
	}, 500);

	$.ajax({
		type: 'POST',
		url: '/objects/getAllObjectsByCity',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'city': city }
	})
	.done(function(data){
		$.each(data, function(index, value){
			var valuePFAD = value.pfad;
			var imageExtension = valuePFAD.substr(valuePFAD.length - 3);
			var valueNiederlassung = (value.niederlassung == 'Frankfurt') ? 'Rhein-Main' : value.niederlassung;
			var valueStadt = (value.stadt == 'Frankfurt') ? 'Rhein-Main' : value.stadt;

			var valueDate = new Date(value.datum);
			day=valueDate.getDate();
			month=valueDate.getMonth();
			month=month+1;
			if((String(day)).length==1)
				day='0'+day;
			if((String(month)).length==1)
				month='0'+month;
			valueDate=day+ '.' + month + '.' + valueDate.getFullYear();

			setTimeout(function(){
				$('.divTableBody').append(
					'<div class="divTableRow">' +
					'<a href="' + value.pfad + '" target="_blank">'+
					'<div class="divTableCell hidden">' +
					'<div>' +
					'<img class="documents-pdf-image" src="/images/' + imageExtension + '.png">' +
					'</div>' +
					'<div class="documents-pdf-name">' +
					value.objekt + ' | ' + value.strasse + ', ' + value.plz + ' ' + valueStadt +
					'</div>' +
					'<div class="documents-pdf-date">' +
					'(' + valueDate + ') ' +
					valueNiederlassung +
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
		}, 1000);
	});
}

function getObjectsByName(name)
{
	$('.object-title-niederlassungen1').text('');
	$('.object-title-niederlassungen').text('');

	$('.divTableCell').slideUp();
	$('.pagination').hide();
	setTimeout(function(){
		$('.loading-container').show();
		$('.divTableBody').html('');
	}, 500);


	

	$.ajax({
		type: 'POST',
		url: '/objects/getAllObjectsWithName',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'name': name }
	})
	.done(function(data){
		if(data.length > 0){
			$.each(data, function(index, value){
				var valuePFAD = value.pfad;
				var imageExtension = valuePFAD.substr(valuePFAD.length - 3);
				var valueNiederlassung = (value.niederlassung == 'Frankfurt') ? 'Rhein-Main' : value.niederlassung;
				var valueStadt = (value.stadt == 'Frankfurt') ? 'Rhein-Main' : value.stadt;

				var valueDate = new Date(value.datum);
				day=valueDate.getDate();
				month=valueDate.getMonth();
				month=month+1;
				if((String(day)).length==1)
					day='0'+day;
				if((String(month)).length==1)
					month='0'+month;
				valueDate=day+ '.' + month + '.' + valueDate.getFullYear();

				setTimeout(function(){
					$('.divTableBody').append(
						'<div class="divTableRow">' +
						'<a href="' + value.pfad + '" target="_blank">'+
						'<div class="divTableCell hidden">' +
						'<div>' +
						'<img class="documents-pdf-image" src="/images/' + imageExtension + '.png">' +
						'</div>' +
						'<div class="documents-pdf-name">' +
						value.objekt + ' | ' + value.strasse + ', ' + value.plz + ' ' + valueStadt +
						'</div>' +
						'<div class="documents-pdf-date">' +
						'(' + valueDate + ') ' +
						valueNiederlassung +
						'</div>' +
						'</div>' +
						'</a>' +
						'</div>'
						);
				}, 1000);
			});
		} else {
			setTimeout(function(){
				$('.divTableBody').append('<div class="employees-no-results"> Keine Ergebnisse ! </div>');
			}, 1000);
		}

		setTimeout(function(){
			$('.divTableCell').slideToggle();
			$('.loading-container').hide();
			$('.divTableCell').css('display','flex');
		}, 1000);
	});
}

function getObjectsByBranch(branch){
	$('.pagination').hide();

	$('.divTableCell').slideUp();
	setTimeout(function(){
		$('.loading-container').show();
		$('.divTableBody').html('');
	}, 500);

	$.ajax({
		type: 'POST',
		url: '/objects/getObjectsByBranch',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'branch': branch }
	})
	.done(function(data){
		if(data.length > 0){
			$.each(data, function(index, value){
				var valuePFAD = value.pfad;
				var imageExtension = valuePFAD.substr(valuePFAD.length - 3);
				var valueNiederlassung = (value.niederlassung == 'Frankfurt') ? 'Rhein-Main' : value.niederlassung;
				var valueStadt = (value.stadt == 'Frankfurt') ? 'Rhein-Main' : value.stadt;

				var valueDate = new Date(value.datum);
				day=valueDate.getDate();
				month=valueDate.getMonth();
				month=month+1;
				if((String(day)).length==1)
					day='0'+day;
				if((String(month)).length==1)
					month='0'+month;
				valueDate=day+ '.' + month + '.' + valueDate.getFullYear();

				setTimeout(function(){
					$('.divTableBody').append(
						'<div class="divTableRow">' +
						'<a href="' + value.pfad + '" target="_blank">'+
						'<div class="divTableCell hidden">' +
						'<div>' +
						'<img class="documents-pdf-image" src="/images/' + imageExtension + '.png">' +
						'</div>' +
						'<div class="documents-pdf-name">' +
						value.objekt + ' | ' + value.strasse + ', ' + value.plz + ' ' + value.stadt +
						'</div>' +
						'<div class="documents-pdf-date">' +
						'(' + valueDate + ') ' +
						valueNiederlassung +
						'</div>' +
						'</div>' +
						'</a>' +
						'</div>'
						);
				}, 1000);
			});

			setTimeout(function(){
				$('.loading-container').hide();
				$('.divTableCell').slideToggle();
				$('.divTableCell').css('display','flex');
			}, 1000);
		}else{
			setTimeout(function(){
				$('.loading-container').hide();
				$('.divTableBody').append('<div class="employees-no-results">  Zur Zeit gibt es keine aktuellen Objekteindrücke aus dem '+ branch +'. </div>');
			}, 1000);
		}
	});
};

function getAllObjectsWithNameAndPopupList(name)
{
	$('.pagination').hide();

	var data = [];
	$.ajax({
		type: 'POST',
		url: '/objects/getAllObjectsWithName',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'name': name }
	})
	.done(function(data){
		if(data.length > 0){
			$('.searchbar-document-wrap').html('');
			$('.searchbar-document-wrap').append('<ul class="searchbar-document-list">');
			$.each(data, function(index, value){
				$('.searchbar-document-list').append('<li class="searchbar-objects-result searchbar-objects-result-' + value.id + '" data-id="'+ value.id + '">' + value.objekt + ' | ' + value.strasse + ', ' + value.plz + ' ' + value.stadt + '</li>');
				highlightObject(name, value.id);
			});
			$('.searchbar-document-wrap').append('</ul>');

			$('.searchbar-document-wrap').show();

		}else{
			$('.searchbar-document-wrap').html('');
			$('.searchbar-document-wrap').append('<ul class="ceva">');
			$('.ceva').append('<li> Keine Ergebnisse ! </li>');
			$('.searchbar-document-wrap').append('</ul>');

			$('.searchbar-document-wrap').show();
		}
	});
}

function updateClicksFAQ(faqId)
{
	$.ajax({
		type: 'POST',
		url: '/service/updateClicksFAQ',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'id': faqId }
	});
}

function highlightObject(text, id)
{
	inputText = $('.searchbar-objects-result-'+id);
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

var $faq = $('html').find('.faq');

if ($faq[0])
{
    // When the user clicks on an accordian element
    $faq.find('.accordian').click(function(e)
    {
    	var $this = $(this);

        // If the element isn't a link to the form and is already open
        if ( ! $(e.target).is('a') && $this.is('.open'))
        {
            // Close the next element
            $this.removeClass('open').next().slideUp(300);
        }
        // If the element isn't a link to the form
        else if ( ! $(e.target).is('a'))
        {
            // Close any other elements that are already open
            $this.parent().children('.open').removeClass('open').next().slideUp(300);

            // Display the next element
            $this.addClass('open').next().slideDown(300);

        	updateClicksFAQ($this.data('faqid'));
        }
    });

    // If the user clicks anywhere else other than the accordian area, close any open elements
    $faq.find('.delete').click(function(e)
    {
    	$(this).parent().slideUp(300).prev().removeClass('open')
    });

    // If the user clicks anywhere else other than the accordian area, close any open elements
    // $(document).click(function(e)
    // {
    // 	if ( ! $(e.target).closest('.faq').length && ! $(e.target).closest('.modal').length)
    // 	{
    // 		$faq.find('.open').removeClass('open').next().slideUp(300)
    // 	}
    // })
}