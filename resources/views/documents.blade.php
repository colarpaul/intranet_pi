@extends('layouts.app')

@section('content.css')
<link href="{{ asset('css/custombox/custombox.min.css') }}" rel="stylesheet">
@endsection

@section('content.wallpaper-navbar')
<nav class="navbar wallpaper-service relative" role="navigation" aria-label="dropdown navigation">

    <div class="documents-search-background has-text-right">
        <div class="documents-search-title">Dokumentensuche</div>
        <div class="documents-search-description">Vorlagen, Anleitungen und wichtige Informationen zum Download</div>
        <div  class="documents-search-wrap">
            <div class="relative">
                <input class="searchbar-field2 searchbar-field2-doc" type="text" placeholder="Suchbegriff eingeben"><i class="searchbar-span2 fa fa-search" aria-hidden="true"></i>
            </div>
            <div class="searchbar-document-wrap">
                <ul>
                    <li>No results</li>
                </ul>
            </div>
            <select data-placeholder="Kategorie wählen" class="chosen-select documents-search-chosen" id="documents-search-chosen" tabindex="2">
                <option value=""></option>
                <option value="0">Alle Dokumente</option>
                @foreach ($documentCategories as $documentCategory)
                <option value="{{ $documentCategory->id }}">{{ ucFirst($documentCategory->name) }} </option>
                @endforeach
            </select>
        </div>
        <div class="faqSearchInput">
            <input class="faqSearchInputField" type="text" placeholder="Suchbegriff eingeben"><i class="searchbar-span2 fa fa-search" aria-hidden="true"></i>
            <div class="searchbar-document-wrap2">
                <ul>
                    <li>No results</li>
                </ul>
            </div>
        </div>
    </div>
</nav>
@endsection

@section('content')
<div class="container documents-container wrap-container">
    <div class="columns">
        <div class="column is-8">
            <div class="documents-container-title">Dokumente</div>
            <div class="documents-container-description">@if (Route::current()->uri == 'dokumente/alleDokumente') Alle Dokumente @else Meistgenutzte Dokumente @endif</div>
            <div class="documents-container-telefon"></div>
            <div class="loading-container hidden">
                <a class="button is-loading">Loading</a>
            </div>
            <div class="divTable documentsTable">
                <div class="divTableBody">
                    @foreach ($documents as $document)
                    <div class="divTableRow" data-documentId="{{ $document->id }}">
                        <a target="_blank" href="{{ $document->pfad }}">
                            <div class="divTableCell">
                                <div>
                                    <img class="documents-pdf-image" src="@if(strtotime($document->created_at) > strtotime('-30 days'))/images/{{substr($document->pfad, -3)}}_new.png @else /images/{{substr($document->pfad, -3)}}.png @endif" />
                                </div>
                                <div class="documents-pdf-name">
                                    {{ $document->name }}
                                </div>
                                <div class="documents-pdf-date">
                                    {{ $document->groesse . 'Kb' }}
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @if (Route::current()->uri == 'dokumente/alleDokumente')
            {{ $documents->appends(request()->input())->links() }}
            @endif
            <div class="div-all-documents">
                @if (Route::current()->uri != 'dokumente/alleDokumente') 
                <a class="pi-color" href="/dokumente/alleDokumente">[Alle Dokumente anzeigen]</a>
                @endif 
            </div>
        </div>
        <div class="column is-4">
            <div class="documents-container-categories">
                <div class="doc-categories-title">
                    Alle Kategorien
                </div>
                <div class="doc-categories-spans">
                    @if(Route::current()->uri != 'dokumente/alleDokumente')
                    <div><a class="pi-color" href="/dokumente/alleDokumente"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Alle Dokumente</a></div>
                    @else
                    <div><a class="pi-color" href="/dokumente"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Meistgenutzte Dokumente</a></div>
                    @endif
                    @foreach ($documentCategories as $documentCategory)
                    <div class="@if(ucFirst($documentCategory->name) == 'Telefonanleitungen') doc-category-span2 @else doc-category-span @endif" data-id="{{ $documentCategory->id }}"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ ucFirst($documentCategory->name) }}</div>
                    @if(ucFirst($documentCategory->name) == 'Telefonanleitungen')
                    <div class="doc-subcat-divs">
                        <div class="doc-subcat-div" data-value="Berlin"><i class="fa fa-plus-circle" aria-hidden="true"></i> Berlin </div>
                        <div class="doc-subcat-div" data-value="Rhein-Main"><i class="fa fa-plus-circle" aria-hidden="true"></i> Rhein-Main </div>
                        <div class="doc-subcat-div" data-value="Hamburg"><i class="fa fa-plus-circle" aria-hidden="true"></i> Hamburg </div>
                        <div class="doc-subcat-div" data-value="Nürnberg"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nürnberg </div>
                        <div class="doc-subcat-div" data-value="Rheinland"><i class="fa fa-plus-circle" aria-hidden="true"></i> Rheinland </div>
                        <div class="doc-subcat-div" data-value="München"><i class="fa fa-plus-circle" aria-hidden="true"></i> München </div>
                        <div class="doc-subcat-div" data-value="Wien"><i class="fa fa-plus-circle" aria-hidden="true"></i> Wien </div>
                    </div>
                    @endif
                    @endforeach
                </span>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('content.js')
<script src="{{ asset('js/custombox/custombox.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/custombox/custombox.legacy.min.js') }}" type="text/javascript" charset="utf-8"></script>
@endsection
