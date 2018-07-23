@extends('adminPanel.layouts.app')

<style>
.newsPDFInput::active {
	color: red !important;
}
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
					<li class="breadcrumb-item"><a href="javascript:void(0)">Documents</a></li>
				</ol>
			</div>
		</div>

		<div class="admin-table-container">
			<table class="table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Titel</th>
						<th scope="col">Bild Liste</th>
						<th scope="col">Bild News</th>
						<th scope="col">Bild Header</th>
						<th scope="col">Art</th>
						<th scope="col">Datum</th>
						<!-- <th scope="col">GO-LIVE</th> -->
						<th scope="col">Home</th>
						<th scope="col">Publish</th>
						<th scope="col">Aktion</th>
					</tr>
				</thead>
				<tbody>
					@foreach($news as $key => $new)
					<tr>
						<th scope="row">{{ $new->id }}</th>
						<td class="documentName-{{ $key }}" data-documentName="{{ $new->titel }}" data-documentId="{{ $new->id }}"><a href="/projectintern/{{ $new->id }}" target="_blank">{{ $new->titel }}</a></td>
						<td><a href="{{ $new->bild_teaser }}" target="_blank" style="font-size: 25px;"><i class="fa fa-picture-o" aria-hidden="true"></i></a></td>
						<td><a href="{{ $new->bild }}" target="_blank" style="font-size: 25px;"><i class="fa fa-picture-o" aria-hidden="true"></i></a></td>
						<td><a href="{{ $new->wallpaper_bild }}" target="_blank" style="font-size: 25px;"><i class="fa fa-picture-o" aria-hidden="true"></i></a></td>
						<td>
							<span class="category-span">
								{{ $new->news_art }}
							</span>
						</td>
						<td>
							<span class="subcategory-span">
								{{ date('d M Y', strtotime($new->datum)) }}
							</span>
						</td>
						<!-- <td>
							<span class="subcategory-span" style="background: #3bb8e2">
								{{ date('d M Y', strtotime($new->datum)) }}
							</span>
						</td> -->
						<td>
							<label class="new-homepublish-switcher" ><input type="checkbox" data-newId="{{ $new->id }}" class="ios-switch green" {{ $new->home_publish == 1 ? 'checked' : '' }} /><div><div></div></div></label>
						</td>
						<td>
							<label class="new-publish-switcher" ><input type="checkbox" data-newId="{{ $new->id }}" class="ios-switch green" {{ $new->publish == 1 ? 'checked' : '' }} /><div><div></div></div></label>
						</td>
						<td>
							<span class="edit-button news-edit-button" data-buttonId="{{ $new->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></span> 
							<span class="delete-button news-delete-button" data-name="{{ $new->titel }}" data-buttonId="{{ $new->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table><a href="/cms/news/sortable">Sortable</a>
			{{ $news->links() }}
		</div>
		<div class="row" style="width: 80%; margin: auto; margin-top: 1rem">
			<div class="col col-add-form">
				<div class="col-add-form-title">News hinzufügen</div>
				<div>
					<form method="POST" action="{{ action('NewsController@addNews') }}" enctype="multipart/form-data" class="form-add-document" style="margin-top: 20px;">
						<div class="row">
							<div class="col col-md-12" >
								<div class="divTable">
									<div class="divTableBody">
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												News Art: <span style="color: red">*</span>
											</div>
											<div class="divTableCell">
												<select name="newsArt" class="select-newsArt active">
													@foreach($newsArt as $art)
													<option name="newsArt" value="{{ $art->news_art }}">{{ $art->news_art }}</option>
													@endforeach
												</select>
												<input type="hidden" disabled class="input-newsArt" name="newsArt" required></input>
												<span class="newsArtNewButton"><i class="fa fa-exchange" aria-hidden="true"></i></span>
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												Datum: <span style="color: red">*</span>
											</div>
											<div class="divTableCell">
												<input type="date" name="newsDate" required style=""></input>
											</div>
										</div>
										<!-- <div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												GO-LIVE Datum: <span style="color: red">*</span>
											</div>
											<div class="divTableCell">
												<input type="date" name="newsGoLiveDate" required style=""></input>
											</div>
										</div> -->
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												Titel: <span style="color: red">*</span>
											</div>
											<div class="divTableCell">
												<input type="text" name="newsTitel" required></input>
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												Untertitel: <span style="color: red">*</span>
											</div>
											<div class="divTableCell">
												<textarea name="newsUntertitel" class="addNewsUntertitelInput"></textarea>
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												Meldung: <span style="color: red">*</span>
											</div>
											<div class="divTableCell addNewsMeldungInputCell">
												<textarea cols="50" name="newsMeldung"  class="addNewsMeldungInput" required></textarea>
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												Bild Untertext:
											</div>
											<div class="divTableCell addNewsBildUntertextInputCell">
												<textarea cols="50" name="newsBildUntertext"  class="addNewsBildUntertextInput"></textarea>
											</div>
										</div>
										<div class="divTableRow" style="text-align: center; color: #18a73d; font-size: 18px; font-weight: 500;">
											<div class="divTableCell" colspan="2" style="text-align: right; width: 150px;">
												Bild
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">Bild Liste: <span style="color: red">*</span></div>
											<div class="divTableCell">
												<label for="teaser-upload" style="width: auto" class="custom-file-upload">
													<i class="fa fa-cloud-upload"></i> Bild Liste Hochladen
												</label>
												(400x265)
												<input id="teaser-upload" type="file" name="newsTeaser" required></input>
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">Bild News:</div>
											<div class="divTableCell">
												<label for="bild-upload" style="width: auto" class="custom-file-upload">
													<i class="fa fa-cloud-upload"></i> Bild News Hochladen
												</label>
												(Breite 650)
												<input id="bild-upload" type="file" name="newsBild"></input>
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">Bild Header: <span style="color: red">*</span></div>
											<div class="divTableCell">
												<label for="wallpaper-upload" style="width: auto" class="custom-file-upload">
													<i class="fa fa-cloud-upload"></i> Bild Header Hochladen
												</label>
												(2000x575)
												<input id="wallpaper-upload" type="file" name="newsWallpaper" required></input>
											</div>
										</div>
										<div class="divTableRow" style="text-align: center; color: #18a73d; font-size: 18px; font-weight: 500;">
											<div class="divTableCell" colspan="2" style="text-align: right; width: 150px;">
												Buttons
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">PDF: </div>
											<div class="divTableCell">
												<label for="pdf-upload" style="width: auto" class="custom-file-upload">
													<i class="fa fa-cloud-upload"></i> PDF Hochladen
												</label>
												<input id="pdf-upload" type="file" name="newsPDF"></input>
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												PDF Button Text:
											</div>
											<div class="divTableCell">
												<input type="text" name="newsPDFName"></input>
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												Web Button URL:
											</div>
											<div class="divTableCell">
												<input type="text" name="newsWEB" placeholder="www.project-immobilien.com"></input>
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 175px;">
												Web Button Text:
											</div>
											<div class="divTableCell">
												<input type="text" name="newsWEBName"></input>
											</div>
										</div>
										<div class="divTableRow" style="text-align: center; color: #18a73d; font-size: 18px; font-weight: 500;">
											<div class="divTableCell" colspan="2" style="text-align: right; width: 150px;">
												Google
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												Latitude:
											</div>
											<div class="divTableCell">
												<input type="text" name="newsLatitude"></input>
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												Longitude:
											</div>
											<div class="divTableCell">
												<input type="text" name="newsLongitude"></input>
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												Google PIN:
											</div>
											<div class="divTableCell">
												<input type="text" name="newsGooglePIN"></input>
											</div>
										</div>
										<div class="divTableRow" style="text-align: center; color: #18a73d; font-size: 18px; font-weight: 500;">
											<div class="divTableCell" colspan="2" style="text-align: right; width: 150px;">
												Youtube
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												Youtube LINK:
											</div>
											<div class="divTableCell">
												<input type="text" name="newsYoutube"></input>
											</div>
										</div>
										<div class="divTableRow">
											<div class="divTableCell" style="text-align: right; width: 150px;">
												<span style="color: red">[LEGEND]</span></div>
												<div class="divTableCell">
													<span style="color: red"> * = required</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div style="float: right">
								<input type="submit" class="custom-save-button news-edit-save-button" value="Add" style="margin:0;"></input>
							</div>
						</div>
						<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal-container modal-news-container" style="display: none">
	<form method="POST" action="{{ action('NewsController@updateNews') }}" enctype="multipart/form-data" class="form-add-document" id="updateNewsForm" style="margin-top: 20px;">
		<div class="row">
			<div class="col col-md-12" >
				<div class="divTable">
					<div class="divTableBody">
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								News ID: <span style="color: red">*</span>
							</div>
							<div class="divTableCell">
								<input type="text" class="newsIdInput" name="newsId" disabled required></input>
								<input type="hidden" class="newsIdInput" name="newsId" required></input>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								News Art: <span style="color: red">*</span>
							</div>
							<div class="divTableCell">
								<input type="text" class="newsArtInput" name="newsArt" required></input>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Datum: <span style="color: red">*</span>
							</div>
							<div class="divTableCell">
								<input type="date" class="newsDateInput" name="newsDate" required style=""></input>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Titel: <span style="color: red">*</span>
							</div>
							<div class="divTableCell">
								<input type="text" class="newsTitelInput" name="newsTitel" required></input>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Untertitel:
							</div>
							<div class="divTableCell newsUntertitelInputCell">
								<textarea class="newsUntertitelInput" name="newsUntertitel"></textarea>
								<!-- <textarea class="newsUntertitelInput hidden" name="newsUntertitel"></textarea> -->
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Meldung: <span style="color: red">*</span>
							</div>
							<div class="divTableCell newsMeldungInputCell">
								<textarea cols="50" class="newsMeldungInput" name="newsMeldung"></textarea>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Bild Untertext: 
							</div>
							<div class="divTableCell newsBildUntertextInputCell">
								<textarea cols="50" class="newsBildUntertextInput" name="newsBildUntertext"></textarea>
							</div>
						</div><div class="divTableRow" style="text-align: center; color: #18a73d; font-size: 18px; font-weight: 500;">
							<div class="divTableCell" colspan="2" style="text-align: right; width: 150px;">
								Bild
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Bild Liste 
							</div>
							<div class="divTableCell">								
								<input type="file" class="newsTeaserInput" name="newsTeaser" style="display: block"></input>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Bild News 
							</div>
							<div class="divTableCell">								
								<input type="file" class="newsBildInput" name="newsBild" style="display: block"></input>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Bild Header
							</div>
							<div class="divTableCell">								
								<input type="file" class="newsWallpaperInput" name="newsWallpaper" style="display: block"></input>
							</div>
						</div>
						<div class="divTableRow" style="text-align: center; color: #18a73d; font-size: 18px; font-weight: 500;">
							<div class="divTableCell" colspan="2" style="text-align: right; width: 150px;">
								Buttons
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								PDF 
							</div>
							<div class="divTableCell">								
								<input type="file" class="newsPDFInput" name="newsPDF" style="display: block"></input>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								PDF Button Text
							</div>
							<div class="divTableCell">					
								<input type="text" class="newsPDFNameInput" name="newsPDFName"></input>			
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								WEB Button URL:
							</div>
							<div class="divTableCell">
								<input type="text" class="newsWEBURLInput" name="newsWEBURL" placeholder="www.project-immobilien.com"></input>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								WEB Button Text
							</div>
							<div class="divTableCell">					
								<input type="text" class="newsWEBNameInput" name="newsWEBName"></input>			
							</div>
						</div>
						<div class="divTableRow" style="text-align: center; color: #18a73d; font-size: 18px; font-weight: 500;">
							<div class="divTableCell" colspan="2" style="text-align: right; width: 150px;">
								Google
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Latitude
							</div>
							<div class="divTableCell">
								<input type="text" class="newsLatitudeInput" name="newsLatitude"></input>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Longitude 
							</div>
							<div class="divTableCell">								
								<input type="text" class="newsLongitudeInput" name="newsLongitude"></input>
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Google PIN
							</div>
							<div class="divTableCell">
								<input type="text" class="newsGooglePINInput" name="newsGooglePIN"></input>
							</div>
						</div>
						<div class="divTableRow" style="text-align: center; color: #18a73d; font-size: 18px; font-weight: 500;">
							<div class="divTableCell" colspan="2" style="text-align: right; width: 150px;">
								Youtube
							</div>
						</div>
						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								Youtube Link 
							</div>
							<div class="divTableCell">								
								<input type="text" class="newsYoutubeInput" name="newsYoutube"></input>
							</div>
						</div>


						<div class="divTableRow">
							<div class="divTableCell" style="text-align: right; width: 150px;">
								<span style="color: red">[LEGEND]</span></div>
								<div class="divTableCell">
									<span style="color: red"> * = required</span>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div style="float: right">
				<input type="submit" class="custom-edit-button" style="margin:-25px;"></div>
				<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
			</div>
		</div>
		<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
	</form>
</div>

@endsection