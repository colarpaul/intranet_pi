@extends('adminPanel.layouts.app')

@section('content')
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
                        <th scope="col">Name</th>
                        <th scope="col">Straße</th>
                        <th scope="col">PLZ</th>
                        <th scope="col">Stadt</th>
                        <th scope="col">Niederlassung</th>
                        <th scope="col">Objekt</th>
                        <th scope="col">Datum</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aktion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($objects as $key => $object)
                    <tr>
                        <th scope="row">{{ $object->id }}</th>
                        <td class="objectName-{{ $key }}" data-objectName="{{ $object->name }}" data-objectId="{{ $object->id }}">{{ $object->name }}</td>
                        <td class="objectStrasse-{{ $key }}" data-objectStrasse="{{ $object->strasse }}" data-objectId="{{ $object->id }}">{{ $object->strasse }}</td>
                        <td class="objectPLZ-{{ $key }}" data-objectPLZ="{{ $object->plz }}" data-objectId="{{ $object->id }}">{{ $object->plz }}</td>
                        <td class="objectStadt-{{ $key }}" data-objectStadt="{{ $object->stadt }}" data-objectId="{{ $object->id }}">{{ $object->stadt }}</td>
                        <td class="objectNiederlassung-{{ $key }}" data-objectNiederlassung="{{ $object->niederlassung }}" data-objectId="{{ $object->id }}">
                            <span class="category-span">
                                {{ $object->niederlassung }}
                            </span>
                        </td>
                        <td class="objectObjekt-{{ $key }}" data-objectObjekt="{{ $object->objekt }}" data-objectId="{{ $object->id }}">
                            <span class="subcategory-span">
                                {{ $object->objekt }}</td>
                            </span>
                        </td>
                        <td class="objectDatum-{{ $key }}" data-objectDatum="{{ $object->datum }}" data-objectId="{{ $object->id }}">{{ $object->datum }}</td>
                        <td>
                            <label class="object-status-switcher" ><input type="checkbox" data-objectId="{{ $object->id }}" class="ios-switch green" {{ $object->status == 1 ? 'checked' : '' }} /><div><div></div></div></label>
                        </td>
                        <td>
                            <span class="edit-button object-edit-button" data-buttonId="{{ $object->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></span> 
                            <span class="delete-button object-delete-button" data-name="{{ $object->name }}" data-buttonId="{{ $object->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $objects->links() }}
        </div>
        <div class="row" style="width: 33.33%; margin: auto; margin-top: 1rem">
            <div class="col col-add-form">
                <div class="col-add-form-title">Objekt hinzufügen</div>
                <div>
                    <form method="POST" action="{{ action('ObjectsController@addObject') }}" enctype="multipart/form-data" class="form-add-document" style="margin-top: 20px;">
                        <table style="height: 255px">
                            <tr>
                                <td class="add-description">
                                    Name: 
                                </td>
                                <td>
                                    <input type="text" name="objectName" required></input>
                                </td>
                            </tr>
                            <tr>
                                <td class="add-description">
                                    Straße: 
                                </td>
                                <td>
                                    <input type="text" name="objectStrasse" required></input>
                                </td>
                            </tr>
                            <tr>
                                <td class="add-description">
                                    PLZ: 
                                </td>
                                <td>
                                    <input type="text" name="objectPLZ" required></input>
                                </td>
                            </tr>
                            <tr>
                                <td class="add-description">
                                    Stadt: 
                                </td>
                                <td>
                                    <input type="text" name="objectStadt" required></input>
                                </td>
                            </tr>
                            <tr>
                                <td class="add-description">
                                    Niederlassung: 
                                </td>
                                <td>
                                    <input type="text" name="objectNiederlassung" required></input>
                                </td>
                            </tr>
                            <tr>
                                <td class="add-description">
                                    Objekt: 
                                </td>
                                <td>
                                    <input type="text" name="objectObjekt" required></input>
                                </td>
                            </tr>
                            <tr>
                                <td class="add-description">
                                    Datum: 
                                </td>
                                <td>
                                    <input type="date" name="objectDatum" required></input>
                                </td>
                            </tr>
                            <tr>
                                <div style="margin: 10px 0;">
                                    <div style="float: left;">
                                        <td></td>
                                        <td>
                                            <label for="file-upload" class="custom-file-upload">
                                                <i class="fa fa-cloud-upload"></i> Custom Upload
                                            </label>
                                        </td>
                                        <input id="file-upload" type="file" name="objectFile" required></input>
                                    </div>
                                    <div style="float: right">
                                        <input type="submit" class="custom-save-button" value="Add"></input>
                                    </div>
                                </div>
                            </tr>
                        </table>
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal-container modal-object-container" style="display: none; background: white; min-width: 35%">
    <form method="POST" action="{{ action('ObjectsController@updateObject') }}" enctype="multipart/form-data" class="form-add-document" style="margin: 30px">
        <div class="row">
            <div class="col col-md-12" >
                <div class="divTable">
                    <div class="divTableBody">
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align: right; width: 150px;">
                                Object ID:
                            </div>
                            <div class="divTableCell">
                                <input type="text" class="objectIdInput" name="objectId" disabled required></input>
                                <input type="hidden" class="objectIdInputNeu" name="objectId" required></input>
                            </div>
                        </div>
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align: right; width: 150px;">
                                Name:
                            </div>
                            <div class="divTableCell">
                                <input type="text" class="objectNameInput" name="objectName" required style="width: 100%"></input>
                            </div>
                        </div>
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align: right; width: 150px;">
                                Straße:
                            </div>
                            <div class="divTableCell">
                                <input type="text" class="objectStrasseInput" name="objectStrasse" required style="width: 100%"></input>
                            </div>
                        </div>
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align: right; width: 150px;">
                                PLZ:
                            </div>
                            <div class="divTableCell">
                                <input type="text" class="objectPLZInput" name="objectPLZ" required style="width: 100%"></input>
                            </div>
                        </div>
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align: right; width: 150px;">
                                Stadt:
                            </div>
                            <div class="divTableCell">
                                <input type="text" class="objectStadtInput" name="objectStadt" required style="width: 100%"></input>
                            </div>
                        </div>
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align: right; width: 150px;">
                                Niederlassung:
                            </div>
                            <div class="divTableCell">
                                <input type="text" class="objectNiederlassungInput" name="objectNiederlassung" required style="width: 100%"></input>
                            </div>
                        </div>
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align: right; width: 150px;">
                                Objekt:
                            </div>
                            <div class="divTableCell">
                                <input type="text" class="objectObjektInput" name="objectObjekt" required style="width: 100%"></input>
                            </div>
                        </div>
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align: right; width: 150px;">
                                Datum:
                            </div>
                            <div class="divTableCell">
                                <input type="date" class="objectDatumInput" name="objectDatum" required style="width: 100%"></input>
                            </div>
                        </div>
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align: right; width: 150px;">PDF: </div>
                            <div class="divTableCell">
                                <label for="pdf-upload" style="width: auto" class="custom-file-upload">
                                    <i class="fa fa-cloud-upload"></i> Custom Upload
                                </label>
                                <input id="pdf-upload" type="file" name="objectPDF"></input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="float: right; position: absolute; bottom: 0; right: 0;">
                <input type="submit" class="custom-edit-button" style="margin:-25px; position: relative; float: right; margin-right: 10px;">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            </div>
        </div>
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
    </form>
</div>
@endsection