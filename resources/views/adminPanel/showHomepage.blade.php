@extends('adminPanel.layouts.app')

@section('content')
<div class="page-wrapper">
	
	<div class="row" style="width: 50%; margin: auto; margin-top: 1rem">
		<div class="col col-add-form">
			<div class="col-add-form-title">Homepage Data hinzufügen</div>
			<div>
				<form method="POST" action="{{ action('DocumentsController@updateHomepageData') }}" enctype="multipart/form-data" style="margin-top: 20px;">
					<table style="height: 255px; width: 100%;">
						<tr>
							<div class="divTableCell" style="text-align: right; width: 150px;">Bild Liste: </div>
							<div class="divTableCell" style="padding: 0">
								<label for="teaser-upload" style="width: auto" class="custom-file-upload">
									<i class="fa fa-cloud-upload"></i> Bild Liste Hochladen
								</label>
								(2000x575)
								<input id="teaser-upload" type="file" name="homepageWallpaper"></input>
							</div>
						</tr>
						<tr>
							<td style="width: 150px;" class="add-description">
								Titel: 
							</td>
							<td>
								<input style="width: 100%" type="text" name="homepageTitel" value="{{ $homepageData->titel }}" required></input>
							</td>
						</tr>
						<tr>
							<td class="add-description">
								Untertitel: 
							</td>
							<td>
								<textarea style="width: 100%" type="text" name="homepageUntertitel" required>{{ $homepageData->untertitel }}</textarea>
							</td>
						</tr>
						<tr>
							<td class="add-description">
								WEB Button URL: 
							</td>
							<td>
								<input style="width: 100%" type="text" name="homepageWEB" placeholder="/projectintern/xx" value="{{ $homepageData->button_url }}"></input>
							</td>
						</tr>
						<tr>
							<td class="add-description">
								WEB Button Text: 
							</td>
							<td>
								<input style="width: 100%" type="text" name="homepageWEBName" placeholder="weiterleiten.. project intern.." value="{{ $homepageData->button_name }}"></input>
							</td>
						</tr>
						<tr>

						</tr>
					</table>
					<button type="submit" class="custom-save-button">Submit</button>
					<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
				</form>
			</div>
		</div>
	</div>
	
	<div class="row" style="width: 50%; margin: auto; margin-top: 1rem">
		<div class="col col-add-form">
			<div class="col-add-form-title">Home Message Settings</div>
			<div>
				<form method="POST" action="{{ action('DocumentsController@updateHomeMessageData') }}" enctype="multipart/form-data" style="margin-top: 20px;">
					<table style="width: 100%;">
						<tr>
							<td style="width: 150px;">
								Title: 
							</td>
							<td>
								<input style="width: 100%" type="text" name="messageTitle" value="{{ $homeMessageData->title }}" required></input>
							</td>
						</tr>
						<tr>
							<td style="width: 150px;">
								Message: 
							</td>
							<td>
								<textarea type="text" name="messageMessage" class="addFaqMeldunInput" required>{{ $homeMessageData->message }}</textarea>
								Fontawesome Icons: <a href="https://fontawesome.com/icons?d=gallery" target="_blank">https://fontawesome.com/icons?d=gallery</a><br>
								Titel: 18px <br>
								Untertitel: 14px</span>
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



@endsection