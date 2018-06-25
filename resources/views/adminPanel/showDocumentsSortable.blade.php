@extends('adminPanel.layouts.app')

@section('content')
<div class="page-wrapper">
	<div class="container-fluid">
		<div class="row page-titles">
			<div class="col-md-5 col-8 align-self-center">
				<h3 class="text-themecolor">Dashboard</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">Documents - Sortable</a></li>
				</ol>
			</div>
		</div>

		<div class="admin-table-container">
			<table class="table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Name</th>
						<th scope="col">Sortable #</th>
					</tr>
				</thead>
				<tbody  id="sortableDocuments">
					@foreach($documents as $key => $document)
					<tr class="ui-state-default" data-sortable="{{ $key+1 }}" data-documentid="{{ $document->id }}">
						<th scope="row">{{ $document->id }}</th>
						<td class="documentName-{{ $key }}" data-documentName="{{ $document->name }}" data-documentId="{{ $document->id }}">{{ $document->name }}</td>
						<th scope="row">{{ $document->sortable }}</th>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection