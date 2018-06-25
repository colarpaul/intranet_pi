@extends('adminPanel.layouts.app')

@section('content')
<div class="page-wrapper">
	<div class="container-fluid">
		<div class="row page-titles">
			<div class="col-md-5 col-8 align-self-center">
				<h3 class="text-themecolor">Dashboard</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">FAQs - Statistics</a></li>
				</ol>
			</div>
		</div>

		<div class="admin-table-container" style="margin-bottom: 2rem">
			<div style="font-size: 22px; margin: 1rem 0"><span class="subcategory-span" style="margin: 0">Clicks</span></div>
			<table class="table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Titel</th>
						<th scope="col">Meldung</th>
						<th scope="col">Kategorie</th>
						<th scope="col">Unterkategorie</th>
						<th scope="col">Clicks</th>
					</tr>
				</thead>
				<tbody>
					@foreach($top5faqs as $key => $faq)
					<tr>
						<th scope="row">{{ $faq->id }}</th>
						<td style="text-overflow: ellipsis;	max-width: 350px; white-space: nowrap; overflow: hidden; padding-right: 50px;">{{ $faq->titel }}</td>
						<td style="text-overflow: ellipsis;	max-width: 600px; white-space: nowrap; overflow: hidden; padding-right: 50px;">{{ $faq->meldung }}</td>
						<td scope="row"><span class="category-span">@if(strtolower($faq->kategorie) == 'it') IT @else {{ ucfirst($faq->kategorie) }} @endif</span></td>
						<td scope="row">@if(!empty($faq->unterkategorie))<span class="subcategory-span">{{ $faq->unterkategorie }}</span>@else - @endif</td>
						<td scope="row"><span class="subcategory-span" style="background: #74d1e0">{{ $faq->clicks }}</span></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection