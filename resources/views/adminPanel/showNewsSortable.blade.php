@extends('adminPanel.layouts.app')

@section('content')
<div class="page-wrapper">
	<div class="container-fluid">
		<div class="row page-titles">
			<div class="col-md-5 col-8 align-self-center">
				<h3 class="text-themecolor">Dashboard</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">News - Sortable</a></li>
				</ol>
			</div>
		</div>

		<div class="admin-table-container">
			<table class="table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Titel</th>
						<th scope="col">Teaser Bild</th>
						<th scope="col">Wallpaper Bild</th>
						<th scope="col">Art</th>
						<th scope="col">Datum</th>
						<th scope="col">Sortable #</th>
					</tr>
				</thead>
				<tbody  id="sortable">
					@foreach($news as $key => $new)
					<tr class="ui-state-default" data-sortable="{{ $key+1 }}" data-newid="{{ $new->id }}">
						<th scope="row">{{ $new->id }}</th>
						<td class="documentName-{{ $key }}" data-documentName="{{ $new->titel }}" data-documentId="{{ $new->id }}">{{ $new->titel }}</td>
						<td><a href="{{ $new->bild_teaser }}" target="_blank" style="font-size: 25px;"><i class="fa fa-picture-o" aria-hidden="true"></i></a></td>
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
						<th scope="row">{{ $new->sortable }}</th>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection