$(document).on('click','.employee-wraper',function(e){
	var modalName = '.modal-container';

	var modal = new Custombox.modal({
		content: {
			effect: 'blur',
			target: modalName
		}
	});

	var employeeEmail = $(this).data('email');

	$.when(
		appendEmployeeToModal(employeeEmail)
		)
	.then(
		setTimeout(function(){
			modal.open()
		}, 150)
		)
});

function appendEmployeeToModal(email){
	$.ajax({
		type: 'POST',
		url: '/mitarbeiter/getEmployeeByEmail',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'email': email }
	})
	.done(function(employee){
		console.log(employee);
		var imageSRC = ((employee.thumbnailphoto) ? 'url("data:image/jpeg;base64, ' + employee.thumbnailphoto + '")' : 'url("/images/profile-image-example.png")');
		var telephone = (employee.telephonenumber) ? employee.telephonenumber : '-';
		var mobile = (employee.mobile) ? employee.mobile : '-';

		$('.modal-container.employeeModal .downloadVCard').attr('href', '/mitarbeiter/downloadVCard/'+employee.mail);
		$('.modal-container.employeeModal .employeeThumbnailphoto').css('background-image', imageSRC);
		$('.modal-container.employeeModal .employeeName').html(employee.cn);
		$('.modal-container.employeeModal .employeeTitle').html(employee.title);
		$('.modal-container.employeeModal .employeeAbteilung').html(employee.department);
		$('.modal-container.employeeModal .employeeUnternehmen').html(employee.company);
		$('.modal-container.employeeModal .employeeLocation').html(employee.streetaddress + ', ' + employee.postalcode + ', ' + employee.l);
		$('.modal-container.employeeModal .employeeTelefonnumberLink').attr("href", 'tel:'+telephone);
		$('.modal-container.employeeModal .employeeTelefonnumber').html(telephone);
		if(mobile != '-'){
			$('.modal-container.employeeModal .employeeMobileLink').attr("href", 'tel:'+mobile);
		} else {
			$('.modal-container.employeeModal .employeeMobileLink').attr("href", '#');
		}
		$('.modal-container.employeeModal .employeeMobile').html(mobile);
		$('.modal-container.employeeModal .employeeMailLink').attr("href", 'mailto:'+employee.mail);
		$('.modal-container.employeeModal .employeeMail').html(employee.mail);
	});
}

$(".search-employee1").on('click', function(){
	$('.searchbar-employees-wrap').hide();
});
$(".search-employee2").on('click', function(){
	$('.searchbar-employees-wrap').hide();
});

$(window).click(function() {
	$('.searchbar-employees-wrap').hide();
});

$(".searchbar-field-employees").on('input', function(e) {
	var value = $(this).val();

	if(value.length >= 3){
		getAllEmployeesWithNameAndPopupList(value);
	} else {
		$('.searchbar-employees-wrap').hide();
	}
});

$(".searchbar-field-employees").on('focus', function(e) {
	var value = $(this).val();

	if(value.length >= 3){
		getAllEmployeesWithNameAndPopupList(value);
	} else {
		$('.searchbar-employees-wrap').hide();
	}
});

$(document).on('click', '.searchbar-employees-result', function(){
	var employeeName = $(this).data('name');

	if(employeeName.length >= 1){
		$('#location_search_chosen_chosen a span').html('Ort auswählen');
		$('#position_search_chosen_chosen a span').html('Abteilung auswählen');
		getEmployeeByName(employeeName);
		$('.searchbar-employees-wrap').hide();
	} else {
		getAllEmployees();
	}
});

$('.searchbar-span-employees').on('click', function(){
	var employeeName = $('.searchbar-field-employees').val();

	$('.employee-title-start').text('Mitarbeiter');
	$('.employee-title-location1').text('');
	$('.employee-title-location').text('');
	$('.employee-title-position1').text('');
	$('.employee-title-position').text('');

	if(employeeName.length >= 1){
		$('#location_search_chosen_chosen a span').html('Ort auswählen');
		$('#position_search_chosen_chosen a span').html('Abteilung auswählen');
		getEmployeesByName(employeeName);
		$('.searchbar-employees-wrap').hide();
	} else {
		getAllEmployees();
	}
});

$(".searchbar-field-employees").bind('keyup',function(e) {
	if(e.which === 13) {

		$('.employee-title-start').text('Mitarbeiter');
		$('.employee-title-location1').text('');
		$('.employee-title-location').text('');
		$('.employee-title-position1').text('');
		$('.employee-title-position').text('');

		var employeeName = $('.searchbar-field-employees').val();
		if(employeeName.length >= 1){
			$('#location_search_chosen_chosen a span').html('Ort auswählen');
			$('#position_search_chosen_chosen a span').html('Abteilung auswählen');
			getEmployeesByName(employeeName);

			$('.searchbar-employees-wrap').hide();
		} else {
			getAllEmployees();
		}
	} 
});

$(document).on("click","#location_search_chosen_chosen li.active-result",function(){
	var position = $('#position_search_chosen_chosen a span').html();
	position = position.replace('<em>','');
	position = position.replace('</em>','');
	var location = $(this).html();
	location = location.replace('<em>','');
	location = location.replace('</em>','');

	if((location == 'Ort auswählen' || location == 'Alle Orte') && (position == 'Abteilung auswählen' || position == 'Alle Abteilungen')){
		getAllEmployees();
	} else {
		if((location != 'Ort auswählen' && location != 'Alle Orte') && (position == 'Abteilung auswählen' || position == 'Alle Abteilungen')){
			getEmployeesByLocation(location);
		} else if(location == 'Alle Orte' && (position != 'Abteilung auswählen' || position != 'Alle Abteilungen')) {
			getEmployeesByPosition(position);
		} else {
			getEmployeesByLocationAndPosition(location, position);
		}
	}

});

$(document).on("click","#position_search_chosen_chosen li.active-result",function(){
	var position = $(this).html();
	position = position.replace('<em>','');
	position = position.replace('</em>','');
	var location = $('#location_search_chosen_chosen a span').html();
	location = location.replace('<em>','');
	location = location.replace('</em>','');

	if((position == 'Abteilung auswählen' || position == 'Alle Abteilungen') && (location == 'Ort auswählen' || location == 'Alle Orte')){
		getAllEmployees();
	} else {
		if((position != 'Abteilung auswählen' && position != 'Alle Abteilungen') && (location == 'Ort auswählen' || location == 'Alle Orte')){
			getEmployeesByPosition(position);
		} else if(position == 'Alle Abteilungen' && (location != 'Ort auswählen' || location != 'Alle Orte')) {
			getEmployeesByLocation(location);
		} else {
			getEmployeesByLocationAndPosition(location, position);
		}
	}
});

$("#location_search_chosen_chosen").bind('keyup',function(e) {
	if(e.which === 13) {
		var position = $('#position_search_chosen_chosen a span').html();
		var location = $('#location_search_chosen_chosen a span').html();

		if((location == 'Ort auswählen' || location == 'Alle Orte') && (position == 'Abteilung auswählen' || position == 'Alle Abteilungen')){
			getAllEmployees();
		} else {
			if((location != 'Ort auswählen' && location != 'Alle Orte') && (position == 'Abteilung auswählen' || position == 'Alle Abteilungen')){
				getEmployeesByLocation(location);
			} else if(location == 'Alle Orte' && (position != 'Abteilung auswählen' || position != 'Alle Abteilungen')) {
				getEmployeesByPosition(position);
			} else {
				getEmployeesByLocationAndPosition(location, position);
			}
		}
	}
});

$("#position_search_chosen_chosen").bind('keyup',function(e) {
	if(e.which === 13) {
		var position = $('#position_search_chosen_chosen a span').html();
		var location = $('#location_search_chosen_chosen a span').html();

		if((position == 'Abteilung auswählen' || position == 'Alle Abteilungen') && (location == 'Ort auswählen' || location == 'Alle Orte')){
			getAllEmployees();
		} else {
			if((position != 'Abteilung auswählen' && position != 'Alle Abteilungen') && (location == 'Ort auswählen' || location == 'Alle Orte')){
				getEmployeesByPosition(position);
			} else if(position == 'Alle Abteilungen' && (location != 'Ort auswählen' || location != 'Alle Orte')) {
				getEmployeesByLocation(location);
			} else {
				getEmployeesByLocationAndPosition(location, position);
			}
		}
	}
});

function getAllEmployees(name){
	window.location.href = "/mitarbeiter/";
}

function getEmployeesByLocationAndPosition(location, position){
	$('.employee-title-start').text('Mitarbeiter');
	$('.employee-title-position1').text(' der Abteilung ');
	$('.employee-title-position').text(position.replace(/&amp;/g, '&'));
	$('.employee-title-location1').text(' aus ');
	$('.employee-title-location').text(location);
	$('.pagination').hide();

	$('.employees-table').slideUp();
	setTimeout(function(){
		$('.loading-container').show();
	}, 500);

	$.ajax({
		type: 'POST',
		url: '/mitarbeiter/getEmployeesByLocationAndPosition',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'location': location, 'position': position.replace(/&amp;/g, '&') }
	})
	.done(function(data){
		$('.employees-table').html('');
		if(data != undefined && (data.length > 0 || data.length == undefined)){
			$.each(data, function(location, employees){
				$('.employees-table').append('<div class="columns is-multiline is-mobile location-'+location.replace(/\s/g,'')+'" style="width: 100%;"></div>');

				Object.keys(employees).sort().forEach(function(key){
					var value = employees[key];
					delete employees[key];
					employees[key] = value;
				});

				$.each(employees, function(key, employee){
					setTimeout(function(){
						var imageSRC = ((employee.thumbnailphoto) ? 'data:image/jpeg;base64, ' + employee.thumbnailphoto : '/images/profile-image-example.png');
						var telephone = (employee.telephonenumber) ? '<div><span style="color: #cacaca">Telefon: </span>  <a class="phone-web" href="tel:' + employee.telephonenumber + '"> ' + employee.telephonenumber + '</a></div>' : '';
						var mobile = (employee.mobile) ? '<div><span style="color: #cacaca">Mobil: </span><a class="phone-web" href="tel:' + employee.mobile + '"> ' + employee.mobile + '</a></div>' : '';
						var mail = (employee.mail) ? employee.mail : '';
						replacedMail = mail.replace(/\s/g,'').replace('@','').replace('.','').replace('-','').replace('.com','');

						$('.location-'+location.replace(/\s/g,'')).append(
							'<div class="column is-12-touch is-4-desktop employee-wraper employeeMail-'+ replacedMail +'" data-email="' + mail + '" data-id="' + key.replace(/\s/g,'').replace(',','') + '">' +
							'<div class="employee-wraper-special">' +
							'<div class="employee-image" style="background: url(\'' + imageSRC + '\')">'+
							'</div>' +
							'<div class="employee-info1">' +
							'<div><span style="color: #cacaca">Name: </span>' + employee.cn + '</div>' +
							'<div><span style="color: #cacaca">Position: </span>' + employee.title + '</div>' +
							'<div><span style="color: #cacaca">Ort: </span>' + employee.l + '</div>' +
							'</div>' +
							'</div>' +
							'</div>'
							);
					}, 500);
				});
			});
			$('.employees-table').append('</div>');

			getCentralEmployeesByLocationAndPosition(location, position);
		} else {
			setTimeout(function(){
				$('.employees-table').append('<div class="employees-no-results"> Es konnten keine passenden Mitarbeiter gefunden werden! <br> Bitte versuchen Sie es mit einer anderen Schreibweise oder wählen Sie einen anderen Ort oder eine andere Abteilung aus. </div>');
			}, 1000);
		}

		setTimeout(function(){
			$('.employees-table').slideToggle();
			$('.loading-container').hide();
			$('.employees-table').css('display','flex');
		}, 1000);
	});
}


function getEmployeesByPosition(position){
	$('.employee-title-start').text('Mitarbeiter');
	$('.employee-title-location1').text('');
	$('.employee-title-location').text('');
	$('.employee-title-position1').text(' der Abteilung ');
	$('.employee-title-position').text(position.replace(/&amp;/g, '&'));

	$('.pagination').hide();

	$('.employees-table').slideUp();
	setTimeout(function(){
		$('.loading-container').show();
	}, 500);

	$.ajax({
		type: 'POST',
		url: '/mitarbeiter/getEmployeesByPosition',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'position': position.replace(/&amp;/g, '&') }
	})
	.done(function(data){
		Object.keys(data).sort().forEach(function(key) {
			var value = data[key];
			delete data[key];
			data[key] = value;
		});

		$('.employees-table').html('');
		if(data != undefined && (data.length > 0 || data.length == undefined)){
			$.each(data, function(location, employees){
				$('.employees-table').append('<div class="columns is-multiline is-mobile location-'+location.replace(/\s/g,'')+'" style="width: 100%;"></div>');

				$('.location-'+location.replace(/\s/g,'')).append('<div class="employee-title-start" style="width: 100%; font-size: 27px; color: #F29400; margin-top: 1rem; margin-left: 12px;">'+location+'</div>');

				Object.keys(employees).sort().forEach(function(key){
					var value = employees[key];
					delete employees[key];
					employees[key] = value;
				});

				$.each(employees, function(key, employee){
					setTimeout(function(){
						if(employee.l != null){
							var imageSRC = ((employee.thumbnailphoto) ? 'data:image/jpeg;base64, ' + employee.thumbnailphoto : '/images/profile-image-example.png');
							var telephone = (employee.telephonenumber) ? '<div><span style="color: #cacaca">Telefon: </span>  <a class="phone-web" href="tel:' + employee.telephonenumber + '"> ' + employee.telephonenumber + '</a></div>' : '';
							var mobile = (employee.mobile) ? '<div><span style="color: #cacaca">Mobil: </span><a class="phone-web" href="tel:' + employee.mobile + '"> ' + employee.mobile + '</a></div>' : '';
							var mail = (employee.mail) ? employee.mail : '';
							replacedMail = mail.replace(/\s/g,'').replace('@','').replace('.','').replace('-','').replace('.com','');

							$('.location-'+location.replace(/\s/g,'')).append(
								'<div class="column is-12-touch is-4-desktop employee-wraper employeeMail-'+ replacedMail +'" data-email="' + mail + '" data-id="' + key.replace(/\s/g,'').replace(',','') + '">' +
								'<div class="employee-wraper-special">' +
								'<div class="employee-image" style="background: url(\'' + imageSRC + '\')">'+
								'</div>' +
								'<div class="employee-info1">' +
								'<div><span style="color: #cacaca">Name: </span>' + employee.cn + '</div>' +
								'<div><span style="color: #cacaca">Position: </span>' + employee.title + '</div>' +
								'<div><span style="color: #cacaca">Ort: </span>' + employee.l + '</div>' +
								'</div>' +
								'</div>' +
								'</div>'
								);
						}
					}, 600);
				});
			});
			$('.employees-table').append('</div>');
			console.log(position);
			getCentralEmployeesByPosition(position);
		} else {
			setTimeout(function(){
				$('.employees-table').append('<div class="employees-no-results"> Es konnten keine passenden Mitarbeiter gefunden werden! <br> Bitte versuchen Sie es mit einer anderen Schreibweise oder wählen Sie einen anderen Ort oder eine andere Abteilung aus. </div>');
			}, 1000);
		}

		setTimeout(function(){
			$('.employees-table').slideToggle();
			$('.loading-container').hide();
			$('.employees-table').css('display','flex');
		}, 1000);
	});
}

function getEmployeesByLocation (location){
	$('.employee-title-start').text('Mitarbeiter');
	$('.employee-title-location1').text(' aus ');
	$('.employee-title-location').text(location);
	$('.employee-title-position1').text('');
	$('.employee-title-position').text('');

	$('.pagination').hide();

	$('.employees-table').slideUp();
	setTimeout(function(){
		$('.employees-table').html('');
		$('.loading-container').show();
	}, 500);

	$.ajax({
		type: 'POST',
		url: '/mitarbeiter/getEmployeesByLocation',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'location': location }
	})
	.done(function(data){
		if(data.length > 0){
			$.each(data, function(index, value){
				var imageSRC = ((value.thumbnailphoto) ? 'data:image/jpeg;base64, ' + value.thumbnailphoto : '/images/profile-image-example.png');
				var telephone = (value.telephonenumber) ? '<div><span style="color: #cacaca">Telefon: </span>  <a class="phone-web" href="tel:' + value.telephonenumber + '"> ' + value.telephonenumber + '</a></div>' : '';
				var mobile = (value.mobile) ? '<div><span style="color: #cacaca">Mobil: </span><a class="phone-web" href="tel:' + value.mobile + '"> ' + value.mobile + '</a></div>' : '';
				setTimeout(function(){
					$('.employees-table').append(
						'<div class="column is-12-touch is-4-desktop employee-wraper" data-email="' + value.mail + '" data-id="' + index + '">' +
						'<div class="employee-wraper-special">' +
						'<div class="employee-image" style="background: url(\'' + imageSRC + '\')">'+
						'</div>' +
						'<div class="employee-info1">' +
						'<div><span style="color: #cacaca">Name: </span>' + value.cn + '</div>' +
						'<div><span style="color: #cacaca">Position: </span>' + value.title + '</div>' +
						'<div><span style="color: #cacaca">Ort: </span>' + value.l + '</div>' +
						'</div>' +
						'</div>' +
						'</div>'
						);
				}, 1000);
			});
		} else {
			setTimeout(function(){
				$('.employees-table').append('<div class="employees-no-results"> Es konnten keine passenden Mitarbeiter gefunden werden! <br> Bitte versuchen Sie es mit einer anderen Schreibweise oder wählen Sie einen anderen Ort oder eine andere Abteilung aus. </div>');
			}, 1000);
		}

		setTimeout(function(){
			$('.employees-table').slideToggle();
			$('.loading-container').hide();
			$('.employees-table').css('display','flex');
		}, 1000);
	});
}

function getEmployeeByName(name){
	$('.pagination').hide();
	$('.employees-table').slideUp();
	setTimeout(function(){
		$('.employees-table').html('');
		$('.loading-container').show();
	}, 500);

	$.ajax({
		type: 'POST',
		url: '/mitarbeiter/getEmployeeByName',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'name': name }
	})
	.done(function(data){
		if(data.length > 0){ 
			$.each(data, function(index, value){
				setTimeout(function(){
					var imageSRC = ((value.thumbnailphoto) ? 'data:image/jpeg;base64, ' + value.thumbnailphoto : '/images/profile-image-example.png');
					var telephone = (value.telephonenumber) ? '<div><span style="color: #cacaca">Telefon: </span>  <a class="phone-web" href="tel:' + value.telephonenumber + '"> ' + value.telephonenumber + '</a></div>' : '';
					var mobile = (value.mobile) ? '<div><span style="color: #cacaca">Mobil: </span><a class="phone-web" href="tel:' + value.mobile + '"> ' + value.mobile + '</a></div>' : '';
					var department = value.department
					if(department != null) {
						$('.employees-table').append(
							'<div class="column is-12-touch is-4-desktop employee-wraper" data-email="' + value.mail + '" data-id="' + index + '">' +
							'<div class="employee-image" style="background: url(\'' + imageSRC + '\')">'+
							'</div>' +
							'<div class="employee-info1">' +
							'<div><span style="color: #cacaca">Name: </span>' + value.cn + '</div>' +
							'<div><span style="color: #cacaca">Position: </span>' + value.title + '</div>' +
							'<div><span style="color: #cacaca">Ort: </span>' + value.l + '</div>' +
							'</div>' +
							'</div>'
							);
					} else {
						$('.employees-table').append(
							'<div class="column is-12-touch is-4-desktop employee-wraper" data-email="' + value.mail + '" data-id="' + index + '">' +
							'<div class="employee-image" style="background: url(\'' + imageSRC + '\')">'+
							'</div>' +
							'<div class="employee-info1">' +
							'<div><span style="color: #cacaca">Name: </span>' + value.cn + '</div>' +
							'<div><span style="color: #cacaca">Position: </span>' + value.title + '</div>' +
							'<div><span style="color: #cacaca">Ort: </span>' + value.l + '</div>' +
							'</div>' +
							'</div>'
							);
					}
				}, 1000);
			});
		} else {
			setTimeout(function(){
				$('.employees-table').append('<div class="employees-no-results"> Es konnten keine passenden Mitarbeiter gefunden werden! <br> Bitte versuchen Sie es mit einer anderen Schreibweise oder wählen Sie einen anderen Ort oder eine andere Abteilung aus. </div>');
			}, 1000);
		}

		setTimeout(function(){
			$('.employees-table').slideToggle();
			$('.loading-container').hide();
			$('.employees-table').css('display','flex');
		}, 1000);
	});
}

function getEmployeesByName(name){

	$('.employees-table').slideUp();
	$('.pagination').hide();
	setTimeout(function(){
		$('.employees-table').html('');
		$('.loading-container').show();
	}, 500);

	$.ajax({
		type: 'POST',
		url: '/mitarbeiter/getEmployeesByName',
		dataType: 'json'
		,		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'name': name }
	})
	.done(function(data){
		if(data.length > 0 || data.length != undefined){
			$.each(data, function(index, value){
				setTimeout(function(){
					var imageSRC = ((value.thumbnailphoto) ? 'data:image/jpeg;base64, ' + value.thumbnailphoto : '/images/profile-image-example.png');
					var telephone = (value.telephonenumber) ? '<div><span style="color: #cacaca">Telefon: </span>  <a class="phone-web" href="tel:' + value.telephonenumber + '"> ' + value.telephonenumber + '</a></div>' : '';
					var mobile = (value.mobile) ? '<div><span style="color: #cacaca">Mobil: </span><a class="phone-web" href="tel:' + value.mobile + '"> ' + value.mobile + '</a></div>' : '';
					var department = value.department
					if(department != null) {
						$('.employees-table').append(
							'<div class="column is-12-touch is-4-desktop employee-wraper" data-email="' + value.mail + '" data-id="' + index + '">' +
							'<div class="employee-image" style="background: url(\'' + imageSRC + '\')">'+
							'</div>' +
							'<div class="employee-info1">' +
							'<div><span style="color: #cacaca">Name: </span>' + value.cn + '</div>' +
							'<div><span style="color: #cacaca">Position: </span>' + value.title + '</div>' +
							'<div><span style="color: #cacaca">Ort: </span>' + value.l + '</div>' +
							'</div>' +
							'</div>'
							);
					} else {
						$('.employees-table').append(
							'<div class="column is-12-touch is-4-desktop employee-wraper"  data-email="' + value.mail + '" data-id="' + index + '">' +
							'<div class="employee-image" style="background: url(\'' + imageSRC + '\')">'+
							'</div>' +
							'<div class="employee-info1">' +
							'<div><span style="color: #cacaca">Name: </span>' + value.cn + '</div>' +
							'<div><span style="color: #cacaca">Position: </span>' + value.title + '</div>' +
							'<div><span style="color: #cacaca">Ort: </span>' + value.l + '</div>' +
							'</div>' +
							'</div>'
							);
					}
				}, 1000);
			});
		} else {
			setTimeout(function(){
				$('.employees-table').append('<div class="employees-no-results"> Es konnten keine passenden Mitarbeiter gefunden werden! <br> Bitte versuchen Sie es mit einer anderen Schreibweise oder wählen Sie einen anderen Ort oder eine andere Abteilung aus. </div>');
			}, 1000);
		}

		setTimeout(function(){
			$('.employees-table').slideToggle();
			$('.loading-container').hide();
			$('.employees-table').css('display','flex');
		}, 1000);
	});
}

function getAllEmployeesWithNameAndPopupList(name){

	$.ajax({
		type: 'POST',
		url: '/mitarbeiter/getEmployeesByName',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'name': name }
	})
	.done(function(data){
		if(data.length > 0){
			$('.searchbar-employees-wrap').html('');
			$('.searchbar-employees-wrap').append('<ul class="searchbar-employees-list">');
			$.each(data, function(index, value){
				$('.searchbar-employees-list').append('<li class="searchbar-employees-result searchbar-employees-result-' + index + '" data-name="'+ value.cn + '">' + value.cn + '</li>');
				highlightEmployeesWrap(name, index);
			});
			$('.searchbar-employees-wrap').append('</ul>');

			$('.searchbar-employees-wrap').show();

		}else{
			$('.searchbar-employees-wrap').html('');
			$('.searchbar-employees-wrap').append('<ul class="ceva">');
			$('.ceva').append('<li> Keine Ergebnisse </li>');
			$('.searchbar-employees-wrap').append('</ul>');

			$('.searchbar-employees-wrap').show();
		}
	});
}

function getCentralEmployeesByPosition(position){
				console.log(position);
	$.ajax({
		type: 'POST',
		url: '/mitarbeiter/getCentralEmployeesByPosition',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'position': position }
	})
	.done(function(data){
		if(data != undefined && (data.length > 0 || data.length == undefined)){
			$.each(data, function(keyInfo, centralInfo){
				var location = centralInfo.standort;
				var central = centralInfo.zentrale;
				var street = centralInfo.strasse;
				console.log(location);
				$('.location-'+location+' .employee-title-start').append(
					'<div class="columns is-multiline is-12-touch is-12-desktop central-wraper centralNumber-'+keyInfo+'" style="padding: 0; display: flex;">' +
					'<div class="column is-12-touch is-4-desktop central-info-wraper" style="border: 1px transparent">' +
					'<div class="central-wraper-special" style="border: 1px solid #f29400 !important; color: #f29400 !important; border-radius: 10px; display: flex; margin: 0rem 0.7rem; padding: 1rem 1rem;">' +
					'<div class="employee-image" style="background: url(/images/home_image.png)">'+
					'</div>' +
					'<div class="employee-info1">' +
					'<div>' + central + '</div>' +
					'<div>' + street + '</div>' +
					'<div>Tel.: ' + centralInfo.telefon + '</div>' +
					'</div>' +
					'</div>' +
					'</div>'
					);

				var employees = JSON.parse(centralInfo.sekretariat);
				$.each(employees, function(key, email){
					$.ajax({
						type: 'POST',
						url: '/mitarbeiter/getEmployeeByEmail',
						dataType: 'json',
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
						data: { 'email': email }
					})
					.done(function(employee){
						$.when(
							setTimeout(function(){ 
								var imageSRC = ((employee.thumbnailphoto) ? 'data:image/jpeg;base64, ' + employee.thumbnailphoto : '/images/profile-image-example.png');
								var telephone = (employee.telephonenumber) ? '<div><span style="color: #cacaca">Telefon: </span>  <a class="phone-web" href="tel:' + employee.telephonenumber + '"> ' + employee.telephonenumber + '</a></div>' : '';
								var mobile = (employee.mobile) ? '<div><span style="color: #cacaca">Mobil: </span><a class="phone-web" href="tel:' + employee.mobile + '"> ' + employee.mobile + '</a></div>' : '';

								appendCentralEmployeesToTable(key, location, employee, imageSRC, telephone, mobile, keyInfo)
							})
							)
						.then(
							setTimeout(function(){ 
								var mail = (employee.mail) ? employee.mail : '';
								replacedMail = mail.replace(/\s/g,'').replace('@','').replace('.','').replace('-','').replace('.com','');
								hideEmployeeFromTableIfIsInCentral(replacedMail)
							}, 601)
							);
					});
				});
			});
		}
	});
}

function appendCentralEmployeesToTable(key, location, employee, imageSRC, telephone, mobile, keyInfo){
	$('.location-'+location+' .centralNumber-'+keyInfo+'').append(
		'<div class="column is-12-touch is-4-desktop employee-wraper" data-email="' + employee.mail + '" data-id="centralEmployee' + location + key + '">' +
		'<div class="employee-wraper-special" style="border: 1px solid #f29400 !important; color: #f29400 !important; border-radius: 10px;">' +
		'<div class="employee-image" style="background: url(\'' + imageSRC + '\')">'+
		'</div>' +
		'<div class="employee-info1">' +
		'<div><span style="color: #f29400">Name: </span>' + employee.cn + '</div>' +
		'<div><span style="color: #f29400">Position: </span>' + employee.title + '</div>' +
		'<div><span style="color: #f29400">Ort: </span>' + employee.l + '</div>' +
		'</div>' +
		'</div>' +
		'</div>'
		);
}

function hideEmployeeFromTableIfIsInCentral(replacedMail){
	$('.employeeMail-'+replacedMail).hide();
}

function getCentralEmployeesByLocationAndPosition(location, position){
	$.ajax({
		type: 'POST',
		url: '/mitarbeiter/getCentralEmployeesByLocationAndPosition',
		dataType: 'json',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		data: { 'location': location, 'position': position }
	})
	.done(function(data){
		if(data != undefined && (data.length > 0 || data.length == undefined)){
			$.each(data, function(keyInfo, centralInfo){
				var location = centralInfo.standort;
				var central = centralInfo.zentrale;
				var street = centralInfo.strasse;
				$('.location-'+location).append(
					'<div class="columns is-multiline is-12-touch is-12-desktop central-wraper centralNumber-'+keyInfo+'" style="padding: 0; display: flex; margin: 0px; width: 100%;">' +
					'<div class="column is-12-touch is-4-desktop central-info-wraper" style="border: 1px transparent">' +
					'<div class="central-wraper-special" style="border: 1px solid #f29400 !important; color: #f29400 !important; border-radius: 10px; display: flex; margin: 0rem 0.7rem; padding: 1rem 1rem;">' +
					'<div class="employee-image" style="background: url(/images/home_image.png)">'+
					'</div>' +
					'<div class="employee-info1">' +
					'<div>' + central + '</div>' +
					'<div>' + street + '</div>' +
					'<div>Tel.: ' + centralInfo.telefon + '</div>' +
					'</div>' +
					'</div>' +
					'</div>'
					);

				var employees = JSON.parse(centralInfo.sekretariat);
				$.each(employees, function(key, email){
					$.ajax({
						type: 'POST',
						url: '/mitarbeiter/getEmployeeByEmail',
						dataType: 'json',
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
						data: { 'email': email }
					})
					.done(function(employee){
						$.when(
							setTimeout(function(){ 
								var imageSRC = ((employee.thumbnailphoto) ? 'data:image/jpeg;base64, ' + employee.thumbnailphoto : '/images/profile-image-example.png');
								var telephone = (employee.telephonenumber) ? '<div><span style="color: #cacaca">Telefon: </span>  <a class="phone-web" href="tel:' + employee.telephonenumber + '"> ' + employee.telephonenumber + '</a></div>' : '';
								var mobile = (employee.mobile) ? '<div><span style="color: #cacaca">Mobil: </span><a class="phone-web" href="tel:' + employee.mobile + '"> ' + employee.mobile + '</a></div>' : '';

								console.log(keyInfo);
								appendCentralEmployeesToTable(key, location, employee, imageSRC, telephone, mobile, keyInfo)
							})
							)
						.then(
							setTimeout(function(){ 
								var mail = (employee.mail) ? employee.mail : '';
								replacedMail = mail.replace(/\s/g,'').replace('@','').replace('.','').replace('-','').replace('.com','');
								hideEmployeeFromTableIfIsInCentral(replacedMail)
							}, 601)
							);
					});
				});
			});
		}
	});
}

function highlightEmployeesWrap(text, id)
{
	inputText = $('.searchbar-employees-result-'+id);
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