@extends('adminPanel.layouts.app')

@section('content')
<div class="page-wrapper">
	
	<div class="row" style="width: 50%; margin: auto; margin-top: 1rem">
		<div class="col col-add-form">
			<div class="col-add-form-title">WLAN Banner Settings</div>
			<div>
				<form method="POST" action="{{ action('DocumentsController@updateWLANBanner') }}" enctype="multipart/form-data" style="margin-top: 20px;">
					<table style="width: 100%;">
						<tr>
							<td style="width: 150px;">
								WLAN Name: 
							</td>
							<td>
								<input style="width: 200px" type="text" name="wlanName" value="{{ $wlan->name }}" required></input>
							</td>
						</tr>
						<tr>
							<td style="width: 150px;">
								WLAN Password: 
							</td>
							<td>
								<input style="width: 200px" type="text" name="wlanPassword" value="{{ $wlan->password }}" required></input>
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