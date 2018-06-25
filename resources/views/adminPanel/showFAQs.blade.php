@extends('adminPanel.layouts.app')

<style>

.fr-wrapper, .fr-element {
	height: 500px !important;	
}

</style>

@section('content')
<div class="page-wrapper">
	<div class="container-fluid">
		<div class="row page-titles">
			<div class="col-md-5 col-8 align-self-center">
				<h3 class="text-themecolor">Dashboard</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">FAQs</a></li>
				</ol>
			</div>
		</div>

		<div class="admin-table-container">
			<table class="table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Titel</th>
						<th scope="col">Meldung</th>
						<th scope="col">Kategorie</th>
						<th scope="col">Unterkategorie</th>
						<th scope="col">Clicks</th>
						<th scope="col">Publish</th>
						<th scope="col">Aktion</th>
					</tr>
				</thead>
				<tbody>
					@foreach($faqs as $key => $faq)
					<tr>
						<th scope="row">{{ $faq->id }}</th>
						<td style="text-overflow: ellipsis;	max-width: 350px; white-space: nowrap; overflow: hidden; padding-right: 50px;">{{ $faq->titel }}</td>
						<td style="text-overflow: ellipsis;	max-width: 600px; white-space: nowrap; overflow: hidden; padding-right: 50px;">{{ $faq->meldung }}</td>
						<td scope="row"><span class="category-span">@if(strtolower($faq->kategorie) == 'it') IT @else {{ ucfirst($faq->kategorie) }} @endif</span></td>
						<td scope="row">@if(!empty($faq->unterkategorie))<span class="subcategory-span">{{ $faq->unterkategorie }}</span>@else - @endif</td>
						<td scope="row"><span class="subcategory-span" style="background: #74d1e0">{{ $faq->clicks }}</span></td>
						<td>
							<label class="faq-publish-switcher" ><input type="checkbox" data-faqId="{{ $faq->id }}" class="ios-switch green" {{ $faq->publish == 1 ? 'checked' : '' }} /><div><div></div></div></label>
						</td>
						<td>
							<span class="edit-button faq-edit-button" data-buttonId="{{ $faq->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></span> 
							<span class="delete-button faq-delete-button" data-name="{{ $faq->titel }}" data-buttonId="{{ $faq->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<table>
				<tr class="text-center">
					<td><a href="/cms/faqs/sortable"><i class="fa fa-sort-numeric-asc" aria-hidden="true"></i></a></td>
					<td><a href="/cms/faqs/sortable">Sortable</a></td>
				</tr>
				<tr class="text-center">
					<td><a href="/cms/faqs/statistics"><i class="fa fa-bar-chart" aria-hidden="true"></i></a></td>
					<td><a href="/cms/faqs/statistics">Statistics</a></td>
				</tr>
			</table>
			{{ $faqs->links() }}
		</div>
	</div>
	<div class="row" style="width: 80%; margin: auto; margin-top: 1rem">
		<div class="col col-add-form">
			<div class="col-add-form-title">Dokument hinzufügen</div>
			<div>
				<form method="POST" action="{{ action('ServiceController@addFAQs') }}" enctype="multipart/form-data" class="form-add-document" style="margin-top: 20px;">
					<table style="width: 100%;">
						<tr>
							<td class="add-description">
								Titel: 
							</td>
							<td>
								<input type="text" name="faqTitel" required></input>
							</td>
						</tr>
						<tr>
							<td class="add-description">
								Meldung: 
							</td>
							<td>
								<textarea type="text" name="faqMeldung" class="addFaqMeldunInput" required></textarea>
								LINK: <span style="color: blue">href</span><span style="color: red">="/documents/Beispiel.pdf"</span> <span style="color: blue">target</span><span style="color: red">="_blank"</span> <br>
								EMAIL: <span style="color: blue">class</span><span style="color: red">="faq-employee-mail"</span> <span style="color: blue"> data-email</span><span style="color: red">="i.kilgenstein@project-immobilien.com"</span><span style="color: blue"> target</span><span style="color: red">="_blank"</span>
							</td>
						</tr>
						<tr>
							<td class="add-description">
								Kategorie: 
							</td>
							<td>
								<input type="text" name="faqKategorie" required></input>
							</td>
						</tr>
						<tr>
							<td class="add-description">
								Unterkategorie: 
							</td>
							<td>
								<input type="text" name="faqUnterkategorie" required></input>
							</td>
						</tr>
					</table>
					<button type="submit" class="custom-save-button">Submit</button>
					<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal-container modal-news-container" style="display: none">
	<form method="POST" action="{{ action('ServiceController@updateFAQs') }}" enctype="multipart/form-data" class="form-add-document" id="updateNewsForm" style="margin-top: 20px;">
		<div class="row">
			<div class="col col-md-12" >
				<div class="divTable">
					<div class="divTableBody">
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								FAQ ID:
							</div>
							<div class="divTableCell">
								<input type="text" class="faqsIdInput" name="faqId" disabled required></input>
								<input type="hidden" class="faqsIdInputNeu" name="faqId" required></input>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Titel:
							</div>
							<div class="divTableCell">
								<input type="text" class="faqTitelInput" name="faqTitel" required></input>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Meldung:
							</div>
							<div class="divTableCell faqMeldungTextarea">
								<textarea type="text" class="editFaqMeldungInput" name="faqMeldung" style=""></textarea>
								LINK: <span style="color: blue">href</span><span style="color: red">="/documents/Beispiel.pdf"</span> <span style="color: blue">target</span><span style="color: red">="_blank"</span> <br>
								EMAIL: <span style="color: blue">class</span><span style="color: red">="faq-employee-mail"</span> <span style="color: blue"> data-email</span><span style="color: red">="i.kilgenstein@project-immobilien.com"</span><span style="color: blue"> target</span><span style="color: red">="_blank"</span>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Kategorie:
							</div>
							<div class="divTableCell">
								<input type="text" class="faqKategorieInput" name="faqKategorie" required></input>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Unterkategorie:
							</div>
							<div class="divTableCell">
								<input type="text" class="faqUnterkategorieInput" name="faqUnterkategorie"></input>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="float: right">
				<input type="submit" class="custom-edit-button" style="margin:-25px;">
				<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
			</div>
		</div>
		<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
	</form>
</div>

@endsection