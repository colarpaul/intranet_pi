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

		@foreach($faqs as $category => $faqNew)
		<div class="admin-table-container" style="margin-bottom: 2rem">
			<div style="font-size: 22px; margin: 1rem 0"><span class="subcategory-span" style="margin: 0">{{ $category }}</span></div>
			<table class="table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Titel</th>
						<th scope="col">Meldung</th>
						<th scope="col">Kategorie</th>
						<th scope="col">Unterkategorie</th>
						<th scope="col">Sortable</th>
					</tr>
				</thead>
				<tbody class="faqsSortable">
					@foreach($faqNew as $key => $faq)
					<tr class="ui-state-default" data-faqid="{{ $faq->id }}">
						<th scope="row">{{ $faq->id }}</th>
						<td style="text-overflow: ellipsis;	max-width: 350px; white-space: nowrap; overflow: hidden; padding-right: 50px;" class="documentName-{{ $key }}" data-documentName="{{ $faq->titel }}" data-documentId="{{ $faq->id }}">{{ $faq->titel }}</td>
						<td style="text-overflow: ellipsis;	max-width: 600px; white-space: nowrap; overflow: hidden; padding-right: 50px;">{{ $faq->meldung }}</td>
						<td scope="row"><span class="category-span" style="white-space: nowrap;">@if(strtolower($faq->kategorie) == 'it') IT @else {{ ucfirst($faq->kategorie) }} @endif</span></td>
						<td>
							@if($faq->unterkategorie)
							<span class="subcategory-span">
								{{ $faq->unterkategorie }}
							</span>
							@else
							-
							@endif
						</td>
						<td>{{ $faq->sortable }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@endforeach
	</div>
</div>

@endsection