@extends('adminPanel.layouts.app')

@section('content')
<style>.chosen-container { width: 100% !important; } </style>
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Objects</a></li>
                </ol>
            </div>
        </div>

        <div class="admin-table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Zentrale</th>
                        <th scope="col">Strasse</th>
                        <th scope="col">Telefon</th>
                        <th scope="col">Standort</th>
                        <th scope="col">Abteilung</th>
                        <th scope="col">Sekretariat</th>
                        <th scope="col">Aktion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($centrals as $key => $central)
                    <tr>
                        <th scope="row">{{ $central->id }}</th>
                        <td class="objectPLZ-{{ $key }}" data-objectPLZ="{{ $central->zentrale }}" data-objectId="{{ $central->id }}">{{ $central->zentrale }}</td>
                        <td class="objectStadt-{{ $key }}" data-objectStadt="{{ $central->strasse }}" data-objectId="{{ $central->id }}">{{ $central->strasse }}</td>
                        <td class="objectStadt-{{ $key }}" data-objectStadt="{{ $central->telefon }}" data-objectId="{{ $central->id }}">{{ $central->telefon }}</td>
                        <td class="objectNiederlassung-{{ $key }}" data-objectNiederlassung="{{ $central->standort }}" data-objectId="{{ $central->id }}">
                            <span class="category-span">
                                {{ $central->standort }}
                            </span>
                        </td>
                        <td class="objectObjekt-{{ $key }}" data-objectObjekt="{{ $central->abteilung }}" data-objectId="{{ $central->id }}">
                            <span class="subcategory-span">
                                {{ $central->abteilung }}</td>
                            </span>
                        </td>
                        <td class="objectDatum-{{ $key }}" data-objectDatum="{{ $central->sekretariat }}" data-objectId="{{ $central->id }}">
                            @if(count(json_decode($central->sekretariat))>0)
                            @foreach(json_decode($central->sekretariat) as $employee)
                            <div><a href="#">{{ $employee }}</a></div>
                            @endforeach
                            @endif
                        </td>
                        <td>
                            <span class="edit-button central-edit-button" data-buttonId="{{ $central->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></span> 
                            <span class="delete-button central-delete-button" data-name="{{ $central->zentrale }}" data-buttonId="{{ $central->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $centrals->links() }}
        </div>
        <div class="row" style="width: 33.33%; margin: auto; margin-top: 1rem">
            <div class="col col-add-form">
                <div class="col-add-form-title">Zentrale hinzufügen</div>
                <div>
                    <form method="POST" action="{{ action('EmployeesController@addCentral') }}" enctype="multipart/form-data" class="form-add-document" style="margin-top: 20px;">
                        <table style="height: 255px">
                            <tr>
                                <td class="add-description">
                                    Zentrale: 
                                </td>
                                <td>
                                    <input type="text" name="centralZentrale" required style="width: 100%"></input>
                                </td>
                            </tr>
                            <tr>
                                <td class="add-description">
                                    Strasse: 
                                </td>
                                <td>
                                    <input type="text" name="centralStrasse" required style="width: 100%"></input>
                                </td>
                            </tr>
                            <tr>
                                <td class="add-description">
                                    Telefon: 
                                </td>
                                <td>
                                    <input type="text" name="centralTelefon" style="width: 100%"></input>
                                </td>
                            </tr>
                            <tr>
                                <td class="add-description">
                                    Abteilung: 
                                </td>
                                <td>
                                    <select name="centralAbteilung" required>
                                        @foreach($abteilungen as $key => $abteilung)
                                        <option value="{{ ucfirst($abteilung) }}">{{ ucfirst($abteilung) }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="add-description">
                                    Standort: 
                                </td>
                                <td>
                                    <select name="centralStandort" required>
                                        @foreach($standorte as $key => $standort)
                                        @if(!empty($standort))
                                        <option value="{{ ucfirst($standort) }}">{{ ucfirst($standort) }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="add-description">
                                    Sekretariat: 
                                </td>
                                <td>
                                    <div class="side-by-side clearfix">
                                        <div>
                                            <select data-placeholder="Wählen Sie einige Sekretariat" class="chosen-select chosen-add-document-subcategory" name="centralSekretariat[]" multiple tabindex="2">
                                                @foreach($employees as $key => $employee)
                                                <option value="{{ $employee }}">{{ $employee }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div>
                            <input type="submit" class="custom-save-button" style="position: relative" value="Einfügen"></input>
                        </div>
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-container modal-news-container" style="display: none; padding: 2rem;">
        <form method="POST" action="{{ action('EmployeesController@updateCentral') }}" enctype="multipart/form-data" class="form-add-document" id="updateNewsForm" style="margin-top: 20px;">
            <div class="row">
                <div class="col col-md-12" >
                    <div class="divTable">
                        <div class="divTableBody">
                            <div class="divTableRow">
                                <div class="divTableCell" style="text-align: right; width: 150px;">
                                    ZENTRALE ID:
                                </div>
                                <div class="divTableCell">
                                    <input type="text" class="centralIdInput" name="centralId" disabled required></input>
                                    <input type="hidden" class="centralIdInputNeu" name="centralId" required></input>
                                </div>
                            </div>
                            <div class="divTableRow">
                                <div class="divTableCell" style="text-align: right; width: 150px;">
                                    Zentrale:
                                </div>
                                <div class="divTableCell">
                                    <input type="text" class="centralZentraleInput" name="centralZentrale" required></input>
                                </div>
                            </div>
                            <div class="divTableRow">
                                <div class="divTableCell" style="text-align: right; width: 150px;">
                                    Strasse:
                                </div>
                                <div class="divTableCell">
                                    <input type="text" class="centralStrasseInput" name="centralStrasse" required></input>
                                </div>
                            </div>
                            <div class="divTableRow">
                                <div class="divTableCell" style="text-align: right; width: 150px;">
                                    Telefon:
                                </div>
                                <div class="divTableCell">
                                    <input type="text" class="centralTelefonInput" name="centralTelefon"></input>
                                </div>
                            </div>
                            <div class="divTableRow">
                                <div class="divTableCell" style="text-align: right; width: 150px;">
                                    Abteilung:
                                </div>
                                <div class="divTableCell">
                                    <select name="centralAbteilung" required>
                                        @foreach($abteilungen as $key => $abteilung)
                                        <option class="centralAbteilungOption centralAbteilungOption-{{ str_replace(' ', '', ucfirst($abteilung)) }}" value="{{ ucfirst($abteilung) }}">{{ ucfirst($abteilung) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="divTableRow">
                                <div class="divTableCell" style="text-align: right; width: 150px;">
                                    Standort:
                                </div>
                                <div class="divTableCell">
                                    <select name="centralStandort" required>
                                        @foreach($standorte as $key => $standort)
                                        @if(!empty($standort))
                                        <option class="centralStandortOption centralStandortOption-{{ str_replace(' ', '', ucfirst($standort)) }}" value="{{ ucfirst($standort) }}">{{ ucfirst($standort) }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="divTableRow">
                                <div class="divTableCell" style="text-align: right; width: 150px;">
                                    Unterkategorie:
                                </div>
                                <div class="divTableCell">
                                    <select data-placeholder="Wählen Sie einige Sekretariat" class="chosen-select chosen-edit-document-subcategory" name="centralSekretariat[]" multiple tabindex="2" style="width: 100%">
                                        @foreach($employees as $key => $employee)
                                        <option value="{{ $employee }}">{{ $employee }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <input type="submit" class="custom-edit-button" style="position: relative;">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        </div>
                    </div>
                </div>
            </div>
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        </form>
    </div>
    @endsection