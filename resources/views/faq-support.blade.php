@extends('layouts.app')

@section('content.css')
<link href="{{ asset('css/custombox/custombox.min.css') }}" rel="stylesheet">
@endsection

@section('content.wallpaper-navbar')
<nav class="navbar wallpaper-service relative" role="navigation" aria-label="dropdown navigation" style="background-image: url(/images/bg_faq.jpg);">

    <div class="documents-search-background has-text-right">
        <div class="documents-search-title">Haben Sie eine Frage?</div>
        <div class="documents-search-description">Antworten auf die häufigsten Fragen und nützliche Informationen zum Arbeitsalltag</div>
        <!-- <div class="faqSearchInput" style="display:block">
            <input class="faqSearchInputField" type="text" placeholder="Suchbegriff eingeben"><i class="searchbar-span2 fa fa-search" aria-hidden="true"></i>
            <div class="searchbar-document-wrap2 searchbar-faq-wrap2">
                <ul>
                    <li>No results</li>
                </ul>
            </div>
        </div> -->
    </div>

    <div class="container documents-search-container">
        <div class="category-options-spans">
            <!-- <div class="category-option-span category-option-1 category-option-is-active" data-value="documents">Dokumente</div> -->
            <div class="category-option-span category-option-2 category-option-is-active" data-value="faq">FAQ</div>
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

<div class="container faq-container">
    <div class="columns is-mobile is-multiline is-centered">
        <div class="column is-8-desktop is-10-tablet is-10-mobile">
            <div class="faq-container-title">FAQ - Themen</div>
            <div class="columns is-12-desktop is-12-tablet is-10-mobile is-mobile is-multiline is-centered is-gapless">
                @foreach($faqsData as $category => $values)
                <div class="column is-6-desktop is-6-tablet is-10-mobile display-flex faq-{{ $values['translation'] }}-fragenX faq-fragenX" style="margin-bottom: 1rem;">
                    <div>
                        <img src="/images/icons/{{ $values['translation'] }}.png" alt="{{ $category }} Icon" style="margin: .5rem">
                    </div>
                    <div class="faq-text display-block" style="margin: 1rem 0 1rem 0;">
                        <div class="faq-categories-title">{{ $category }}</div>
                    </div>
                </div>
                @endforeach

                @if(count($faqsData) % 2 != 0)
                <div class="column is-6-desktop is-6-tablet is-10-mobile display-flex" style="margin-bottom: 1rem;">
                </div>
                @endif
            </div>

            <div class="faqs-answers-div">
                @foreach($faqsData as $category => $values)
                <ul class="faq faq-{{ $values['translation'] }}-fragen faq-fragen" style="display: none">
                    @foreach($values['subcategories'] as $subcategory => $faqs)

                    @if($subcategory != '' AND $subcategory != '-')
                    <div class="faq-subcategory-div">{{ $subcategory }}</div>
                    @endif

                    @foreach($faqs as $faq)
                    <li class="accordian is-flex" data-faqid="{{ $faq->id }}">
                        <i class="fa fa-angle-down"></i>
                        {{ $faq->titel }}
                    </li>

                    <li class="accordian-content">
                        {!! nl2br($faq->meldung) !!}
                    </li>
                    @endforeach
                    @endforeach
                </ul>
                @endforeach
            </div>
        </div>

        <div class="column is-4-desktop is-10-tablet">
            <div class="faq-container-categories">
                <div class="faq-categories-spans">
                    <ul class="faq faq-best-questions">
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
                <form action="/dokumente/sendSupportEmail" method="get" id="support-form">
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
                <form action="/dokumente/sendFeedbackEmail" method="get" id="feedback-form">
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
