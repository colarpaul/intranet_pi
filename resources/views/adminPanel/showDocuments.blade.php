@extends('adminPanel.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Documents</a></li>
                </ol>
            </div>
        </div>

        <div class="admin-table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Kategorie</th>
                        <th scope="col">Unterkategorie</th>
                        <th scope="col">Datum</th>
                        <th scope="col">Home</th>
                        <th scope="col">Aktion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $key => $document)
                    <tr>
                        <th scope="row">{{ $document->id }}</th>
                        <td class="documentName-{{ $key }}" data-documentName="{{ $document->name }}" data-documentId="{{ $document->id }}">{{ $document->name }}</td>
                        <td>
                            <span class="category-span">
                                @foreach($documentCategories as $documentCategory)
                                @if($documentCategory->id == $document->kategorie)
                                {{ $documentCategory->name }}
                                @endif
                                @endforeach
                            </span>
                        </td>
                        <td>
                            @if(count(json_decode($document->unterkategorie)) > 0)
                            @foreach(json_decode($document->unterkategorie) as $category)
                            <span class="subcategory-span">
                                @foreach($documentSubcategories as $documentSubcategory)
                                @if($category == $documentSubcategory->id)
                                {{ $documentSubcategory->name }}
                                @endif
                                @endforeach
                            </span>
                            @endforeach <br>
                            @endif
                        </td>
                        <td class="documentDatum-{{ $key }}" data-documentDatum="{{ $document->datum }}" data-documentId="{{ $document->id }}">{{ $document->datum }}</td>
                        <td>
                            <label class="document-publish-switcher" ><input type="checkbox" data-documentId="{{ $document->id }}" class="ios-switch green" {{ $document->publish == 1 ? 'checked' : '' }} /><div><div></div></div></label>
                        </td>
                        <td>
                            <span class="edit-button document-edit-button" data-buttonId="{{ $document->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></span> 
                            <span class="delete-button document-delete-button" data-name="{{ $document->name }}" data-buttonId="{{ $document->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table><a href="/cms/documents/sortable">Sortable Home</a>
            {{ $documents->links() }}
        </div>
        <div class="row" style="width: 100%; margin: auto; margin-top: 1rem">
            <div class="col col-add-form">
                <div class="col-add-form-title">Dokument hinzufügen</div>
                <div>
                    <form method="POST" action="{{ action('ServiceController@addDocument') }}" enctype="multipart/form-data" class="form-add-document" style="margin-top: 20px;">
                        <table style="height: 255px">
                            <tr>
                                <td class="add-description">
                                    Name: 
                                </td>
                                <td>
                                    <input type="text" name="documentName" required></input>
                                </td>
                            </tr>
                            <tr>
                                <td class="add-description">
                                    Kategorie: 
                                </td>
                                <td>
                                    <select name="documentCategory" required>
                                        @foreach($documentCategories as $documentCategory)
                                        <option value="{{ $documentCategory->id }}">{{ ucfirst($documentCategory->name) }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="add-description">
                                    Unterkategorie: 
                                </td>
                                <td>
                                    <div class="side-by-side clearfix">
                                        <div>
                                            <select data-placeholder="Wählen Sie einige Unterkategorien" class="chosen-select chosen-add-document-subcategory" name="documentSubcategory[]" multiple tabindex="2">
                                                @foreach($documentSubcategories as $documentSubcategory)
                                                <option value="{{ $documentSubcategory->id }}">{{ $documentSubcategory->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
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
                                        <input id="file-upload" type="file" name="documentFile" required></input>
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
            <div class="col col-add-form">
                <div class="col-add-form-title">Kategorie hinzufügen</div>
                <div>
                    <form method="POST" action="{{ action('ServiceController@addCategory') }}" enctype="multipart/form-data" style="margin-top: 20px;">
                        <table>
                            <tr>
                                <td class="add-description">
                                    Kategoriename: 
                                </td>
                                <td>
                                    <input type="text" name="documentCategory" required></input>
                                    <input type="submit" class="custom-save-button" value="Add" style="position: relative; margin: 1rem 1.5rem"></input>
                                </td>
                            </tr>
                        </table>
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <div class="table-category" style="width: 80%; height: 150px; overflow: auto; display: block; padding: 10px 20px; float: left; margin-top: 15px; margin-bottom: 10px; -webkit-box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1);
                        box-shadow: 1px 0 5px rgba(0, 0, 0, 0.48);     line-height: 30px; font-size: 15px;">
                        <div style="display: flex; font-weight: 500">
                            <div style="width: 85%">Kategorie</div>
                            <div style="width: 15%">Aktion</div>
                        </div>
                        @foreach ($documentCategories as $documentCategory)
                        <div style="display: flex;">
                            <div style="width: 85%">{{ ucfirst($documentCategory->name) }}</div>
                            <div style="width: 15%; text-align: center"><span class="category-delete-button" data-name="{{ ucfirst($documentCategory->name) }}" data-buttonid="{{ $documentCategory->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></span></div>
                        </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
        <div class="col col-add-form">
            <div class="col-add-form-title">Unterkategorie hinzufügen</div>
            <div>
                <form method="POST" action="{{ action('ServiceController@addSubcategory') }}" enctype="multipart/form-data" style="margin-top: 20px;">
                    <table>
                        <tr>
                            <td class="add-description">
                                Kategorie: 
                            </td>
                            <td>
                                <select name="documentCategory" required style="width: 200px;">
                                    @foreach($documentCategories as $documentCategory)
                                    <option value="{{ $documentCategory->id }}">{{ ucfirst($documentCategory->name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="add-description">
                                Unterkategoriename: 
                            </td>
                            <td>
                                <input type="text" name="documentSubcategory" required style="width: 200px;"></input>
                                <input type="submit" class="custom-save-button" value="Add" style="position: relative; margin: 1rem 1.5rem"></input>
                            </td>
                        </tr>
                    </table>
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <div class="table-category" style="width: 80%; height: 120px; overflow: auto; display: block; padding: 10px 20px; float: left; margin-top: 15px; margin-bottom: 10px; -webkit-box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1);
                    box-shadow: 1px 0 5px rgba(0, 0, 0, 0.48);     line-height: 30px; font-size: 15px;">
                    <div style="display: flex; font-weight: 500">
                        <div style="width: 45%">Unterkategorie</div>
                        <div style="width: 40%">Kategorie</div>
                        <div style="width: 15%">Aktion</div>
                    </div>
                    @foreach ($documentSubcategories as $documentSubcategory)
                    <div style="display: flex;">
                        <div style="width: 45%">{{ ucfirst($documentSubcategory->name) }}</div>
                        @foreach ($documentCategories as $documentCategory)
                        @if ($documentSubcategory->kategorie_id == $documentCategory->id)
                        <div style="width: 40%">{{ ucfirst($documentCategory->name) }}</div>
                        @endif
                        @endforeach
                        <div style="width: 15%; text-align: center"><span class="subcategory-delete-button" data-name="{{ ucfirst($documentSubcategory->name) }}" data-buttonid="{{ $documentSubcategory->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></span></div>
                    </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<div class="modal-container modal-document-container" style="display: none; background: white; min-width: 35%">
    <form method="POST" action="{{ action('ServiceController@updateDocumentName') }}" enctype="multipart/form-data" class="form-add-document" style="margin: 30px">
        <div class="row">
            <div class="col col-md-12" >
                <div class="divTable">
                    <div class="divTableBody">
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align: right; width: 150px;">
                                Document ID:
                            </div>
                            <div class="divTableCell">
                                <input type="text" class="documentIdInput" name="documentId" disabled required></input>
                                <input type="hidden" class="documentIdInputNeu" name="documentId" required></input>
                            </div>
                        </div>
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align: right; width: 150px;">
                                Name:
                            </div>
                            <div class="divTableCell">
                                <input type="text" class="documentNameInput" name="documentName" required style="width: 100%"></input>
                            </div>
                        </div>
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align: right; width: 150px;">PDF: </div>
                            <div class="divTableCell">
                                <label for="teaser-upload" style="width: auto" class="custom-file-upload">
                                    <i class="fa fa-cloud-upload"></i> PDF Hochladen
                                </label>
                                <input id="teaser-upload" type="file" name="documentPDF"></input>
                            </div>
                        </div>
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align: right; width: 150px;">
                                Kategorie:
                            </div>
                            <div class="divTableCell">
                               <select name="documentCategory" required>
                                @foreach($documentCategories as $documentCategory)
                                <option class="documentCategoryOption documentCategoryOption-{{ $documentCategory->id }}" value="{{ $documentCategory->id }}">{{ ucfirst($documentCategory->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="divTableRow">
                        <div class="divTableCell" style="text-align: right; width: 150px;">
                            Unterkategorie:
                        </div>
                        <div class="divTableCell">
                          <select data-placeholder="Wählen Sie einige Unterkategorien" class="chosen-select chosen-edit-document-subcategory" name="documentSubcategory[]" multiple tabindex="2">
                            @foreach($documentSubcategories as $documentSubcategory)
                            <option class="documentSubcategoryOption documentSubcategoryOption-{{ $documentSubcategory->id }}" value="{{ $documentSubcategory->id }}">{{ $documentSubcategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="divTableRow">
                    <div class="divTableCell" style="text-align: right; width: 150px;">
                        Datum:
                    </div>
                    <div class="divTableCell">
                        <input type="date" class="documentDatumInput" name="documentDatum" required style="width: 100%"></input>
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

<style>
.chosen-container {
    width: 100% !important;
}
</style>

@endsection