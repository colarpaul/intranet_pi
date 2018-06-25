@extends('layouts.app')

@section('content.css')
<link href="{{ asset('css/custombox/custombox.min.css') }}" rel="stylesheet">
@endsection

@section('content.wallpaper-navbar')
<nav class="navbar employees-service relative" role="navigation" aria-label="dropdown navigation">
    <div class="employees-search-background has-text-right">
        <div class="objects-search-title">Mitarbeitersuche</div>
        <div class="documents-search-description">Alle PROJECT Immobilien Kollegen im Überblick</div>
        <div  class="employees-search-wrap">
            <div  style="position: relative">
                <input class="searchbar-field-employees" type="text" placeholder="Namen eingeben"><i class="searchbar-span2 searchbar-span-employees fa fa-search" aria-hidden="true"></i>
            </div>
            <div class="searchbar-employees-wrap">
                <ul>
                    <li>No results</li>
                </ul>
            </div>
            <div  class="searchbar-employees-hidden">
                <input class="searchbar-field-employees" type="text" placeholder="Ort auswählen"><i class="searchbar-span2 searchbar-span-employees fa fa-caret-down" aria-hidden="true"></i>
            </div>
            <div  class="searchbar-employees-hidden">
                <input class="searchbar-field-employees" type="text" placeholder="Abteilung auswählen"><i class="searchbar-span2 searchbar-span-employees fa fa-caret-down" aria-hidden="true"></i>
            </div>
            <div class="width-100 search-employee1 hidden">
                <select data-placeholder="Ort auswählen" class="chosen-select location-search-chosen" id="location-search-chosen" tabindex="2">
                    <option value=""></option>
                    <option value="0">Alle Orte</option>
                    @foreach($employeesLocation as $location)
                    <option value="{{ $location }}">{{ $location }}</option>
                    @endforeach
                </select>
            </div>
            <div class="width-100 search-employee1 hidden">
                <select data-placeholder="Abteilung auswählen" class="chosen-select position-search-chosen" id="position-search-chosen" tabindex="2">
                    <option value=""></option>
                    <option value="0">Alle Abteilungen</option>
                    @foreach($employeesPosition as $position)
                    <option value="{{ $position }}">{{ $position }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</nav>
@endsection

@section('content')
<div class="wrap-container container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="employee-div-header1">
                    <span class="employee-title-start">Mitarbeiter</span>
                    <span class="employee-title-position1" style="color: #4a4a4a"></span>
                    <span class="employee-title-position"></span>
                    <span class="employee-title-location1" style="color: #4a4a4a"></span>
                    <span class="employee-title-location"></span>
                </div>
                <div class="loading-container hidden width-100">
                    <a class="button is-loading">Loading</a>
                </div>
                <div class="columns is-multiline is-mobile employees-table">
                    @foreach($employees as $key => $employee)
                    <div class="column is-12-mobile is-4-desktop employee-wraper" data-id="{{ $key }}" data-email=" {{ $employee['mail'] }} ">
                        <div class="employee-wraper-special">
                            @if(!empty($employee['thumbnailphoto']))
                            <div class="employee-image" style="background: url('data:image/jpeg;base64,{{ $employee['thumbnailphoto'] }}')"></div>
                            @else
                            <div class="employee-image" style="background: url('/images/profile-image-example.png')"></div>
                            @endif
                            <div class="employee-info1">
                                <div><span class="grau">Name: </span> {{ $employee['cn'] }}</div>
                                <div><span class="grau">Position: </span>{{ $employee['title'] }}</div>
                                <div><span class="grau">Ort: </span>{{ $employee['l'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-container employeeModal relative">
    <a class="downloadVCard"><i class="fa fa-address-card vCardImage"></i></a>
    <div class="employeeThumbnailphoto">
    </div>
    <div><span class="grau">Name: </span> <span class="employeeName"></span></div>
    <div><span class="grau">Position: </span> <span class="employeeTitle"></span></div>
    <div>
        <span class="grau">Abteilung: <span class="employeeAbteilung"></span></span> 
    </div>
    <div>
        <span class="grau">Ort: <span class="employeeLocation"></span></span> 
    </div>
    <div>
        <span class="grau">Unternehmen: <span class="employeeUnternehmen"></span></span> 
    </div>
    <div>
        <span class="grau">Telefon: </span> 
        <a class="phone-web employeeTelefonnumberLink"> <span class="employeeTelefonnumber"></span></a>
    </div>
    <div>
        <span class="grau">Mobil: </span> 
        <a class="phone-web employeeMobileLink"> <span class="employeeMobile"></span></a>
    </div>
    <div>
        <span class="grau">E-Mail: </span> 
        <a class="mail-web employeeMailLink"><span class="employeeMail"></span></a>
    </div>
</div>

@section('content.js')
<script src="{{ asset('js/custombox/custombox.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/custombox/custombox.legacy.min.js') }}" type="text/javascript" charset="utf-8"></script>
@endsection

@endsection
