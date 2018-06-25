/*
Template Name: Material Pro Admin
Author: Themedesigner
Email: niravjoshi87@gmail.com
File: js
*/
$(function() {
    "use strict";
    $(function() {
        $(".preloader").fadeOut();
    });

    // ============================================================== 
    // This is for the top header part and sidebar part
    // ==============================================================  
    var set = function() {
        var width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width;
        var topOffset = 70;
        if (width < 1170) {
            $("body").addClass("mini-sidebar");
            $('.navbar-brand span').hide();
            $(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
            $(".sidebartoggler i").addClass("ti-menu");
        } else {
            $("body").removeClass("mini-sidebar");
            $('.navbar-brand span').show();
            //$(".sidebartoggler i").removeClass("ti-menu");
        }

        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $(".page-wrapper").css("min-height", (height) + "px");
        }
    };
    $(window).ready(set);
    $(window).on("resize", set);

    $('.copyText1').on('click', function(e){
        /* Get the text field */
        var copyText = document.getElementById("copyText1Value");
        console.log(copyText);

        /* Select the text field */
        copyText.select();

        /* Copy the text inside the text field */
        document.execCommand("Copy");

        /* Alert the copied text */
        alert("Copied the text: " + copyText.value);
    });   

    $(document).on('click','.news-edit-button',function(e){
        var modalName = '.modal-news-container';
        var newsId = $(this).data('buttonid');

        var modal = new Custombox.modal({
            content: {
                backdrop: 'static',
                keyboard: false,
                effect: 'blur',
                target: modalName
            }
        });

        getNewsInfo(newsId);
        $('.modal-news-container .newsIdInput').val(newsId);
        $('.modal-news-container .newsIdInputNeu').val(newsId);

        modal.open();
    });

    $(document).on('click','.faq-edit-button',function(e){
        var modalName = '.modal-news-container';
        var faqId = $(this).data('buttonid');

        var modal = new Custombox.modal({
            content: {
                backdrop: 'static',
                keyboard: false,
                effect: 'blur',
                target: modalName
            }
        });

        getFAQsInfo(faqId);
        $('.modal-news-container .faqsIdInput').val(faqId);
        $('.modal-news-container .faqsIdInputNeu').val(faqId);

        modal.open();
    });

    $(document).on('click','.central-edit-button',function(e){
        var modalName = '.modal-news-container';
        var centralId = $(this).data('buttonid');

        var modal = new Custombox.modal({
            content: {
                backdrop: 'static',
                keyboard: false,
                effect: 'blur',
                target: modalName
            }
        });

        getCentralInfo(centralId);
        $('.modal-news-container .centralIdInput').val(centralId);
        $('.modal-news-container .centralIdInputNeu').val(centralId);

        modal.open();
    });

    $(document).on('click','.document-edit-button',function(e){

        var modalName = '.modal-document-container';
        var documentId = $(this).data('buttonid');

        var modal = new Custombox.modal({
            content: {
                backdrop: 'static',
                keyboard: false,
                effect: 'blur',
                target: modalName
            }
        });

        getDocumentInfo(documentId);
        $('.modal-document-container .documentIdInput').val(documentId);
        $('.modal-document-container .documentIdInputNeu').val(documentId);

        modal.open();
    });

    $('.news-edit-save-button').on('click', function(e){
        var latitude = $('input[name=newsLatitude]').val();
        var longitude = $('input[name=newsLongitude]').val();
        if(latitude.length > 0 && longitude.length > 0){
            $('input[name=newsWallpaper]').attr('required', false);
        } else {
            $('input[name=newsWallpaper]').attr('required', true);
        }
    });

    // // topbar stickey on scroll
    // $(".fix-header .topbar").stick_in_parent({});

    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").click(function() {
        $("body").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("ti-menu");
        $(".nav-toggler i").addClass("ti-close");
    });
    $(".sidebartoggler").on('click', function() {
        //$(".sidebartoggler i").toggleClass("ti-menu");
    });
    $(".search-box a, .search-box .app-search .srh-btn").on('click', function() {
        $(".app-search").toggle(200);
    });

    // ============================================================== 
    // Auto select left navbar
    // ============================================================== 
    $(function() {
        var url = window.location;
        var element = $('ul#sidebarnav a').filter(function() {
            return this.href == url;
        }).addClass('active').parent().addClass('active');
        while (true) {
            if (element.is('li')) {
                element = element.parent().addClass('in').parent().addClass('active');
            } else {
                break;
            }
        }
    });
    // ============================================================== 
    //tooltip
    // ============================================================== 
    // $(function() {
    //         $('[data-toggle="tooltip"]').tooltip()
    //     })
        // ============================================================== 
        // Sidebarmenu
        // ============================================================== 
    // $(function() {
    //     $('#sidebarnav').metisMenu();
    // });
    // ============================================================== 
    // Slimscrollbars
    // ============================================================== 
    // $('.scroll-sidebar').slimScroll({
    //     position: 'left',
    //     size: "5px",
    //     height: '100%',
    //     color: '#dcdcdc'
    // });
    // ============================================================== 
    // Resize all elements
    // ============================================================== 
    $("body").trigger("resize");

    $.FroalaEditor.DefineIcon('imageInfo', {NAME: 'info'});
    $.FroalaEditor.RegisterCommand('imageInfo', {
        title: 'Info',
        focus: false,
        undo: true,
	height: 500,
        refreshAfterCallback: false,
        callback: function () 
        {
            var $img = this.image.get();
            alert($img.attr('src'));
        }
    });

    $('.newsUntertitelInput').froalaEditor({
	height: 500,
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageInfo', 'imageRemove'],
    });

    $('.addNewsUntertitelInput').froalaEditor({
	height: 500,
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageInfo', 'imageRemove']
    });

    $('.newsMeldungInput').froalaEditor({
	height: 500,
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageInfo', 'imageRemove']
    });

    $('.addNewsMeldungInput').froalaEditor({
	height: 500,
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageInfo', 'imageRemove']
    });

    $('.newsBildUntertextInput').froalaEditor({
	height: 500,
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageInfo', 'imageRemove']
    });

    $('.addNewsBildUntertextInput').froalaEditor({
	height: 500,
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageInfo', 'imageRemove']
    });

    $('.addFaqMeldunInput').froalaEditor({
	height: 500,
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageInfo', 'imageRemove']
    });

    $('.editFaqMeldungInput').froalaEditor({
	heightMin: 500,
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageInfo', 'imageRemove']
    });

    $("#sortable").sortable();
    $( "#sortable" ).disableSelection();
    $( "#sortable" ).droppable({
        drop: function( ) {
            setTimeout(function()
            {
                var sortable = {};
                $('#sortable tr').each(function(index, value) {
                    sortable[$(this).data('newid')] = index+1;
                });
                var sortable = JSON.stringify(sortable);
                console.log(sortable);

                $.ajax({
                    type: 'GET',
                    url: '/news/updateNewsSortable',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { 'sortable' : sortable }
                });
            }, 500);
        }
    });

    $("#sortableDocuments").sortable();
    $( "#sortableDocuments" ).disableSelection();
    $( "#sortableDocuments" ).droppable({
        drop: function( ) {
            setTimeout(function()
            {
                var sortable = {};
                $('#sortableDocuments tr').each(function(index, value) {
                    sortable[$(this).data('documentid')] = index+1;
                });
                var sortable = JSON.stringify(sortable);
                console.log(sortable);

                $.ajax({
                    type: 'GET',
                    url: '/service/updateDocumentsSortable',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { 'sortable' : sortable }
                });
            }, 500);
        }
    });


    $(".faqsSortable").sortable();
    $( ".faqsSortable" ).disableSelection();
    $( ".faqsSortable" ).droppable({
        drop: function() {
            $('.faqsSortable').removeClass('faqsSortableActive');
            $(this).addClass('faqsSortableActive');
            setTimeout(function()
            {
                var sortable = {};
                $('.faqsSortableActive').find('tr').each(function(index, value) {
                    sortable[$(this).data('faqid')] = index+1;
                });
                var sortable = JSON.stringify(sortable);

                $.ajax({
                    type: 'GET',
                    url: '/service/updateFAQsSortable',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { 'sortable' : sortable }
                });
            }, 500);
        }
    });
    

    // $('.document-edit-button').on('click', function(){
    //     var id = $(this).data('buttonid');
    //     if($(this).hasClass('editing')){
    //         var inputValue = $('.inputDocumentSpan'+id).val();
    //         var documentId = $('.documentName-'+id).data('documentid');
    //         $('.documentName-'+id).html(inputValue);
    //         $('.documentName-'+id).data('documentname', inputValue);
    //         updateDocumentName(documentId, inputValue);
    //         $(this).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
    //         $(this).removeClass('editing');
    //     } else {
    //         var documentValue = $('.documentName-'+id).data('documentname');
    //         $('.documentName-'+id).html('<input class="inputDocumentSpan'+id+'" type="text" value="'+ documentValue +'">');
    //         $(this).html('<i class="fa fa-check" aria-hidden="true"></i>');
    //         $(this).addClass('editing');
    //     }
    // });

    $('.document-delete-button').on('click', function(){
        var id = $(this).data('buttonid');
        var documentName = $(this).data('name');
        var result = confirm("Are you sure you want to delete Document: `"+ documentName +"`?");
        if (result) {
            removeDocumentById(id);
        }
    });

    $('.object-edit-button').on('click', function(){
        var modalName = '.modal-object-container';
        var objectId = $(this).data('buttonid');

        var modal = new Custombox.modal({
            content: {
                backdrop: 'static',
                keyboard: false,
                effect: 'blur',
                target: modalName
            }
        });

        getObjectInfo(objectId);
        $('.modal-object-container .objectIdInput').val(objectId);
        $('.modal-object-container .objectIdInputNeu').val(objectId);

        modal.open();
    });

    $('.object-delete-button').on('click', function(){
        var id = $(this).data('buttonid');
        var objectName = $(this).data('name');
        var result = confirm("Are you sure you want to delete Object: `"+ objectName +"`?");
        if (result) {
            removeObjectById(id);
        }
    });

    $('.central-delete-button').on('click', function(){
        var id = $(this).data('buttonid');
        var centralName = $(this).data('name');
        var result = confirm("Are you sure you want to delete Central: `"+ centralName +"`?");
        if (result) {
            removeCentralById(id);
        }
    });

    $('.faq-delete-button').on('click', function(){
        var id = $(this).data('buttonid');
        var faqName = $(this).data('name');
        var result = confirm("Are you sure you want to delete FAQs: `"+ faqName +"`?");
        if (result) {
            removeFAQsById(id);
        }
    });

    $('.news-delete-button').on('click', function(){
        var id = $(this).data('buttonid');
        var newsName = $(this).data('name');
        var result = confirm("Are you sure you want to delete News: `"+ newsName +"`?");
        if (result) {
            removeNewsById(id);
        }
    });

    $('.category-delete-button').on('click', function(){
        var id = $(this).data('buttonid');
        var categoryName = $(this).data('name');
        var result = confirm("Are you sure you want to delete Category: `"+ categoryName +"`?");
        if (result) {
            removeCategoryById(id);
        }
    });

    $('.subcategory-delete-button').on('click', function(){
        var id = $(this).data('buttonid');
        var subcategoryName = $(this).data('name');
        var result = confirm("Are you sure you want to delete Subcategory: `"+ subcategoryName +"`?");
        if (result) {
            removeSubcategoryById(id);
        }
    });


    $( "#selectDocumentCategory" ).change(function() {
        var documentCategoryId = $(this).val();
    });

    $('.object-status-switcher .ios-switch').click(function(){
        var objectId = $(this).data('objectid');
        if($(this).is(':checked')){
            // Status: active
            $(this).attr("checked", true);
            updateObjectStatus(objectId, 1);
        } else {
            // Status: inactive
            $(this).attr("checked", false);
            updateObjectStatus(objectId, 0);

        }
    });

    $('.document-publish-switcher .ios-switch').click(function(){
        var documentId = $(this).data('documentid');
        if($(this).is(':checked')){
            // Status: active
            $(this).attr("checked", true);
            updateDocumentStatus(documentId, 1);
        } else {
            // Status: inactive
            $(this).attr("checked", false);
            updateDocumentStatus(documentId, 0);

        }
    });

    $('.new-homepublish-switcher .ios-switch').click(function(){
        var newId = $(this).data('newid');
        if($(this).is(':checked')){
            // Status: active
            $(this).attr("checked", true);
            updateNewHomePublishStatus(newId, 1);
        } else {
            // Status: inactive
            $(this).attr("checked", false);
            updateNewHomePublishStatus(newId, 0);

        }
    });

    $('.new-publish-switcher .ios-switch').click(function(){
        var newId = $(this).data('newid');
        if($(this).is(':checked')){
            // Status: active
            $(this).attr("checked", true);
            updateNewPublishStatus(newId, 1);
        } else {
            // Status: inactive
            $(this).attr("checked", false);
            updateNewPublishStatus(newId, 0);

        }
    });

    $('.faq-publish-switcher .ios-switch').click(function(){
        var faqId = $(this).data('faqid');
        if($(this).is(':checked')){
            // Status: active
            $(this).attr("checked", true);
            updateFAQPublishStatus(faqId, 1);
        } else {
            // Status: inactive
            $(this).attr("checked", false);
            updateFAQPublishStatus(faqId, 0);

        }
    });

    

    function getNewsInfo(newsId){

        $.ajax({
            type: 'GET',
            url: '/news/getNewsInfo',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'newsId': newsId },
        })
        .done(function(data){
            $('.modal-news-container .newsArtInput').val(data.news_art);
            $('.modal-news-container .newsDateInput').val(data.datum);
            $('.modal-news-container .newsTitelInput').val(data.titel);
            $('.newsUntertitelInputCell .fr-element.fr-view').html('').append($.parseHTML(data.untertitel));
            $('.newsMeldungInputCell .fr-element.fr-view').html('').append($.parseHTML(data.meldung));
            $('.newsBildUntertextInputCell .fr-element.fr-view').html('').append($.parseHTML(data.bild_unter));
            $('.modal-news-container .newsWebURLInput').val(data.web_button_url);
            $('.modal-news-container .newsLatitudeInput').val(data.latitude);
            $('.modal-news-container .newsLongitudeInput').val(data.longitude);
            $('.modal-news-container .newsYoutubeInput').val(data.youtube_url);
            $('.modal-news-container .newsGooglePINInput').val(data.pin_google);
            $('.modal-news-container .newsPDFNameInput').val(data.pdf_button_name);
            $('.modal-news-container .newsWEBNameInput').val(data.web_button_name);
        });
    }

    function getFAQsInfo(faqId){

        $.ajax({
            type: 'GET',
            url: '/service/getFAQsInfo',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'faqId': faqId },
        })
        .done(function(data){
            $('.modal-news-container .faqTitelInput').val(data.titel);
            $('.faqMeldungTextarea .fr-element.fr-view').html('').append($.parseHTML(data.meldung));
            $('.modal-news-container .faqKategorieInput').val(data.kategorie);
            $('.modal-news-container .faqUnterkategorieInput').val(data.unterkategorie);
        });
    }

    function getCentralInfo(centralId){

        $.ajax({
            type: 'GET',
            url: '/employees/getCentralInfo',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'centralId': centralId },
        })
        .done(function(data){
            var abteilung = data.abteilung;
            var standort = data.standort;
            $('.modal-news-container .centralZentraleInput').val(data.zentrale);
            $('.modal-news-container .centralStrasseInput').val(data.strasse);
            $('.modal-news-container .centralTelefonInput').val(data.telefon);
            $('.centralAbteilungOption-'+abteilung.replace(/\s/g,'')).attr('selected', true);
            $('.centralStandortOption-'+standort.replace(/\s/g,'')).attr('selected', true);
        });
    }

    function getObjectInfo(objectId){
        $.ajax({
            type: 'GET',
            url: '/service/getObjectInfo',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'objectId': objectId },
        })
        .done(function(data){
            $('.modal-object-container .objectNameInput').val(data.name);
            $('.modal-object-container .objectStrasseInput').val(data.strasse);
            $('.modal-object-container .objectPLZInput').val(data.plz);
            $('.modal-object-container .objectStadtInput').val(data.stadt);
            $('.modal-object-container .objectNiederlassungInput').val(data.niederlassung);
            $('.modal-object-container .objectObjektInput').val(data.objekt);
            $('.modal-object-container .objectDatumInput').val(data.datum);
        });
    }

    function getDocumentInfo(documentId){

        $('.documentCategoryOption').attr('selected', false);

        $.ajax({
            type: 'GET',
            url: '/service/getDocumentInfo',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'documentId': documentId },
        })
        .done(function(data){
            $('.modal-document-container .documentNameInput').val(data.name);
            $('.documentCategoryOption-'+data.kategorie).attr('selected', true);
            $('.modal-document-container .documentDatumInput').val(data.datum);
        });
    }

    function updateDocumentStatus(documentId, documentStatus){
        $.ajax({
            type: 'GET',
            url: '/service/updateDocumentStatus',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'id': documentId, 'status': documentStatus }
        });
    }

    function updateObjectStatus(objectId, objectStatus){
        $.ajax({
            type: 'GET',
            url: '/objects/updateObjectStatus',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'id': objectId, 'status': objectStatus }
        });
    }

    function updateNewHomePublishStatus(newId, newStatus){
        $.ajax({
            type: 'GET',
            url: '/news/updateNewHomePublishStatus',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'id': newId, 'home_publish': newStatus }
        });
    }

    function updateNewPublishStatus(newId, newStatus){
        $.ajax({
            type: 'GET',
            url: '/news/updateNewPublishStatus',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'id': newId, 'publish': newStatus }
        });
    }

    function updateFAQPublishStatus(faqId, newStatus){
        $.ajax({
            type: 'GET',
            url: '/service/updateFAQPublishStatus',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'id': faqId, 'publish': newStatus }
        });
    }

    function updateNews(data){
        $.ajax({
            type: 'GET',
            url: '/news/updateNews',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'data': data }
        });
    }

    function updateObject(data){
        $.ajax({
            type: 'GET',
            url: '/objects/updateObject',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'data': data }
        });
    }

    function updateDocumentName(documentId, documentName){
        $.ajax({
            type: 'GET',
            url: '/service/updateDocumentName',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'id': documentId, 'value': documentName }
        });
    }

    function removeObjectById(objectId){
        $.ajax({
            type: 'GET',
            url: '/objects/removeObject',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'objectId': objectId },
            success: location.reload()
        });
    }

    function removeNewsById(newsId){
        $.ajax({
            type: 'GET',
            url: '/news/removeNews',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'newsId': newsId },
            success: location.reload()
        });
    }

    function removeFAQsById(faqId){
        $.ajax({
            type: 'GET',
            url: '/service/removeFAQsById',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'id': faqId },
            success: location.reload()
        });
    }

    function removeCentralById(centralId){
        $.ajax({
            type: 'GET',
            url: '/employees/removeCentralById',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'id': centralId },
            success: location.reload()
        });
    }

    function removeDocumentById(documentId){
        $.ajax({
            type: 'GET',
            url: '/service/removeDocument',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'documentId': documentId },
            success: location.reload()
        });
    }

    function removeCategoryById(categoryId){
        $.ajax({
            type: 'GET',
            url: '/service/removeCategory',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'categoryId': categoryId },
            success: location.reload()
        });
    }

    function removeSubcategoryById(subcategoryId){
        $.ajax({
            type: 'GET',
            url: '/service/removeSubcategory',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'subcategoryId': subcategoryId },
            success: location.reload()
        });
    }

    $('.custombox-container').on('click', function(e){
        e.preventDefault;
    });



    $('.newsArtNewButton').on('click', function(){
        if($('.select-newsArt').hasClass('active')){
            $('.input-newsArt').attr('type', 'text');
            $('.select-newsArt').attr('disabled', true);
            $('.select-newsArt').removeClass('active');
            $('.select-newsArt').css('display', 'none');
            $('.input-newsArt').attr('disabled', false);
        } else {
            $('.select-newsArt').addClass('active');
            $('.select-newsArt').attr('disabled', false);
            $('.select-newsArt').css('display', 'initial');
            $('.input-newsArt').attr('type', 'hidden');
            $('.input-newsArt').attr('disabled', true);
        }
    });
});
