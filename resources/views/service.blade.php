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

    <div class="container documents-search-container">
        <div class="category-options-spans">
            <div class="category-option-span category-option-1 category-option-is-active" data-value="documents">Dokumente</div>
            <div class="category-option-span category-option-2" data-value="faq">FAQ</div>
            <div class="category-option-span category-option-3" data-value="support">Support</div>
        </div>
    </div>
</nav>
@endsection

@section('content')
<div class="modal-container modal-faq-employee-container">
    <div class="imageModalEmployee"></div>
    <div class="nameModalEmployee"><span>Name: </span><span class="spanName"></span></div>
    <div class="titleModalEmployee"><span>Titel: </span><span class="spanTitle"></span></div>
    <div class="departmentModalEmployee"><span>Abteilung: </span><span class="spanDepartment"></span></div>
    <div class="locationModalEmployee"><span>Ort: </span><span class="spanLocation"></span></div>
    <div class="companyModalEmployee"><span>Unternehmen: </span><span class="spanCompany"></span></div>
    <div class="phoneModalEmployee"><span>Telefon: </span><a class="phone-web spanPhone"></a></div>
    <div class="emailModalEmployee"><span>Email: </span><a class="mail-web spanEmail"></a></div>
</div>

<div class="container documents-container wrap-container">

    <div class="columns">
        <div class="column is-8">
            <div class="documents-container-title">Dokumente</div>
            <div class="documents-container-description">@if (Route::current()->uri == 'dokumente-support/alleDokumente') Alle Dokumente @else Meistgenutzte Dokumente @endif</div>
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
            @if (Route::current()->uri == 'dokumente-support/alleDokumente')
            {{ $documents->appends(request()->input())->links() }}
            @endif
            <div class="div-all-documents">
                @if (Route::current()->uri != 'dokumente-support/alleDokumente') 
                <a class="pi-color" href="/dokumente-support/alleDokumente">[Alle Dokumente anzeigen]</a>
                @endif 
            </div>
        </div>
        <div class="column is-4">
            <div class="documents-container-categories">
                <div class="doc-categories-title">
                    Alle Kategorien
                </div>
                <div class="doc-categories-spans">
                    @if(Route::current()->uri != 'dokumente-support/alleDokumente')
                    <div><a class="pi-color" href="/dokumente-support/alleDokumente"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Alle Dokumente</a></div>
                    @else
                    <div><a class="pi-color" href="/dokumente-support"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Meistgenutzte Dokumente</a></div>
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

<div class="container faq-container hidden">
    <div class="columns is-mobile is-multiline is-centered">
        <div class="column is-8-desktop is-10-tablet is-10-mobile">
            <div class="faq-container-title">FAQ - Themen</div>
            <div class="columns is-mobile is-multiline is-centered is-gapless">
                <div class="column is-6-desktop is-6-tablet is-10-mobile">
                    <div class="display-flex faq-it-fragenX faq-fragenX">
                        <div>
                            <img src="/images/icons/it.png" alt="IT Icon">
                        </div>
                        <div class="faq-text display-block">
                            <div class="faq-categories-title">IT</div>
                        </div>
                    </div>

                    <div class="display-flex faq-personal-fragenX faq-fragenX">
                        <div>
                            <img src="/images/icons/personal.png" alt="Personal Icon">
                        </div>
                        <div class="faq-text display-block">
                            <div class="faq-categories-title">Personal</div>
                        </div>
                    </div>

                    <div class="display-flex faq-reisestelle-fragenX faq-fragenX">
                        <div>
                            <img src="/images/icons/reisestelle.png" alt="Reisestelle Icon">
                        </div>
                        <div class="faq-text display-block">
                            <div class="faq-categories-title">Reisestelle</div>
                        </div>
                    </div>

                    <div class="display-flex faq-datenschutz-fragenX faq-fragenX">
                        <div>
                            <img src="/images/icons/datenschutz.png" alt="Datenschutz Icon">
                        </div>
                        <div class="faq-text display-block">
                            <div class="faq-categories-title">Datenschutz</div>
                        </div>
                    </div>


                </div>
                <div class="column is-6-desktop is-6-tablet is-10-mobile">
                    <div class="display-flex faq-bueroorganisation-fragenX faq-fragenX">
                        <div>
                            <img src="/images/icons/bueroorganisation.png" alt="Büroorganisation Icon">
                        </div>
                        <div class="faq-text display-block">
                            <div class="faq-categories-title">Büroorganisation</div>
                        </div>
                    </div>

                    <div class="display-flex  faq-facilityManagement-fragenX faq-fragenX">
                        <div>
                            <img src="/images/icons/facility_management.png" alt="Facility Management Icon">
                        </div>
                        <div class="faq-text display-block">
                            <div class="faq-categories-title">Facility Management</div>
                        </div>
                    </div>

                    <div class="display-flex faq-fuhrpark-fragenX faq-fragenX">
                        <div>
                            <img src="/images/icons/fuhrpark.png" alt="Fuhrpark Icon">
                        </div>
                        <div class="faq-text display-block">
                            <div class="faq-categories-title">Fuhrpark</div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="faqs-answers-div">
                <ul class="faq faq-it-fragen faq-fragen">
                    @foreach($faqSubcategoriesIT as $key => $subcategory)
                    <div class="faq-subcategory-div">{{ $subcategory->unterkategorie }}</div>
                    @foreach($faqsIT as $key => $faq)
                    @if(trim($faq->unterkategorie) == trim($subcategory->unterkategorie))
                    <li class="accordian is-flex" data-faqid="{{ $faq->id }}">
                        <i class="fa fa-angle-down"></i>
                        {{ $faq->titel }}
                    </li>

                    <li class="accordian-content">
                        {!! nl2br($faq->meldung) !!}
                    </li>
                    @endif
                    @endforeach
                    @endforeach
                </ul>

                <ul class="faq faq-bueroorganisation-fragen faq-fragen">

                    @foreach($faqsBuero as $key => $faq)
                    <li class="accordian is-flex" data-faqid="{{ $faq->id }}">
                        <i class="fa fa-angle-down"></i>
                        {{ $faq->titel }}
                    </li>

                    <li class="accordian-content">
                        {!! nl2br($faq->meldung) !!}
                    </li>
                    @endforeach

                </ul>

                <ul class="faq faq-personal-fragen faq-fragen">

                    @foreach($faqsPersonal as $key => $faq)
                    <li class="accordian is-flex" data-faqid="{{ $faq->id }}">
                        <i class="fa fa-angle-down"></i>
                        {{ $faq->titel }}
                    </li>

                    <li class="accordian-content">
                        {!! nl2br($faq->meldung) !!}
                    </li>
                    @endforeach

                </ul>

                <ul class="faq faq-facilityManagement-fragen faq-fragen">

                    @foreach($faqsFacilityManagement as $key => $faq)
                    <li class="accordian is-flex" data-faqid="{{ $faq->id }}">
                        <i class="fa fa-angle-down"></i>
                        {{ $faq->titel }}
                    </li>

                    <li class="accordian-content">
                        {!! nl2br($faq->meldung) !!}
                    </li>
                    @endforeach

                </ul>

                <ul class="faq faq-reisestelle-fragen faq-fragen">

                    @foreach($faqsReisestelle as $key => $faq)
                    <li class="accordian is-flex" data-faqid="{{ $faq->id }}">
                        <i class="fa fa-angle-down"></i>
                        {{ $faq->titel }}
                    </li>

                    <li class="accordian-content">
                        {!! nl2br($faq->meldung) !!}
                    </li>
                    @endforeach

                </ul>

                <ul class="faq faq-fuhrpark-fragen faq-fragen">
                    @foreach($faqSubcategoriesFuhrpark as $key => $subcategory)
                    <div class="faq-subcategory-div">{{ $subcategory->unterkategorie }}</div>
                    @foreach($faqsFuhrpark as $key => $faq)
                    @if($faq->unterkategorie == $subcategory->unterkategorie)
                    <li class="accordian is-flex" data-faqid="{{ $faq->id }}">
                        <i class="fa fa-angle-down"></i>
                        {{ $faq->titel }}
                    </li>

                    <li class="accordian-content">
                        {!! nl2br($faq->meldung) !!}
                    </li>
                    @endif
                    @endforeach
                    @endforeach

                </ul>

                <ul class="faq faq-datenschutz-fragen faq-fragen">
                    @if(!empty($faqsDatenschutz))
                    @foreach($faqsDatenschutz as $key => $faq)
                    <li class="accordian is-flex" data-faqid="{{ $faq->id }}">
                        <i class="fa fa-angle-down"></i>
                        {{ $faq->titel }}
                    </li>

                    <li class="accordian-content">
                        {!! nl2br($faq->meldung) !!}
                    </li>
                    @endforeach
                    @endif
                </ul>


            </div>
        </div>
        <div class="column is-4-desktop is-10-tablet">
            <div class="faq-container-categories">
                <div class="faq-categories-spans">
                    <ul class="faq faq-it-fragen faq-best-questions">
                        <div class="faq-categories-title">
                            Beliebte Fragen
                        </div>
                        @foreach($faqBestQuestions as $key => $faq)
                        <li class="accordian is-flex" data-faqid="{{ $faq->id }}">
                            <i class="fa fa-angle-down"></i>
                            {{ $faq->titel }}
                        </li>

                        <li class="accordian-content">
                            {!! nl2br($faq->meldung) !!}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="documents-container-help">
                <div class="doc-help-title">Benötigen Sie Hilfe?</div>
                <div class="doc-help-description">Falls Ihre Frage noch nicht beantwortet wurde, schicken Sie einfach eine Nachricht an den Support!</div>
                <div class="doc-help-button">zum Support</div>
            </div>
        </div>
    </div>
</div>

<div class="container support-container hidden">
    <div class="columns">
        <div class="column is-8">
            <div class="support-container-answers">
                <div class="faq-container-title">An wen richtet sich Ihr Anliegen?</div>
                <a class="answer" href="mailto:it-anfragen@project-immobilien.com">Ich habe eine Frage an die IT-Abteilung</a>
                <a class="answer" href="mailto:fm-anfragen@project-immobilien.com">Ich habe eine Frage an das Facility Management</a>
                <a class="answer" href="mailto:software.support@project-immobilien.com">Ich habe eine Frage an die Software-Abteilung</a>
                <a class="answer" href="mailto:personal@project-immobilien.com">Ich habe eine Frage an die Personalabteilung (Deutschland)</a>
                <a class="answer" href="mailto:personal.at@project-immobilien.com">Ich habe eine Frage an die Personalabteilung (Österreich)</a>
                <a class="answer" href="mailto:reisestelle.de@project-immobilien.com">Ich habe eine Frage an die Reisestelle (Deutschland)</a>
                <a class="answer" href="mailto:reisestelle.at@project-immobilien.com">Ich habe eine Frage an die Reisestelle (Österreich)</a>
                <a class="answer" href="mailto:fuhrpark.de@project-immobilien.com">Ich habe eine Frage zum Fuhrpark (Deutschland)</a>
                <a class="answer" href="mailto:fuhrpark.at@project-immobilien.com">Ich habe eine Frage zum Fuhrpark (Österreich)</a>
                <a class="answer" href="mailto:support.intranet@project-immobilien.com">Ich habe eine Frage zum Intranet</a>
            </div>

            <div class="support-container-form">
                <div class="support-container-form-title">Anfrage an <span class="anfrage-an">IT - Support</span></div>
                <div class="support-container-form-title2"></div>
                <form action="/service/sendSupportEmail" method="get" id="support-form">
                    <!-- <form> -->
                        <input type="hidden" class="anfrage-email" name="email"><br>
                        <input type="text" placeholder="Ihr E-Mail-Benutzername" name="name" required> @project-immobilien.com
                        <textarea name="body" id="" cols="30" rows="10" placeholder="Ihre Nachricht" required></textarea>
                        <button type="submit">Absenden</button>
                    </form>
                </div>
            </div>
            <div class="column is-4">
                <div class="documents-container-help">
                    <div class="doc-help-title">Wie gefällt Ihnen das PROJECT Intranet?</div>
                    <div class="doc-help-description">Das Intranet lebt von der Beteiligung der Mitarbeiter. Was fehlt? Was können wir noch verbessern? Gestalten Sie die Seiten aktiv mit, indem Sie uns jetzt Ihr Feedback mitteilen!</div>
                    <a class="mailto-intranet" href="mailto:feedback.intranet@project-immobilien.com">Feedback abgeben</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container feedback-container hidden">
    <div class="columns">
        <div class="column is-8">
            <div class="feedback-container-form">
                <div class="feedback-container-form-title">FEEDBACK</div>
                <form action="/service/sendFeedbackEmail" method="get" id="feedback-form">
                    <input type="hidden" class="anfrage-email" name="email" value="feedback.intranet@project-immobilien.com"><br>
                    <input type="text" placeholder="Ihr E-Mail-Benutzername" name="name" required> @project-immobilien.com
                    <textarea name="body" id="" cols="30" rows="10" placeholder="Ihre Nachricht" required></textarea>
                    <button type="submit">Absenden</button>
                </form>
            </div>
        </div>
        <div class="column is-4">
            <div class="documents-container-help">
                <div class="doc-help-title">Haben Sie technische Schwierigkeiten?</div>
                <div class="doc-help-description">Falls Probleme beim Bedienen des Intranets auftreten, wenden Sie sich bitte an unseren technischen Intranet-Support!</div>
                <div class="zu-support-faq-link">Zum Support</div>
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
