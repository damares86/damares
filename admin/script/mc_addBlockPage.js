function initializeSummernote() {
    $(".summernote").summernote({
        tabsize: 2,
        height: 400,
        lang:"it-IT",
        toolbar: [
        ['misc',['undo','redo']],
        ['style', ['style']],
        ['font', ['bold','italic','underline', 'clear']],
        ['fontname', ['fontname','fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']],
        ],
    })
    $("#hint").summernote({
        height: 100,
        toolbar: false,
        placeholder: "type with apple, orange, watermelon and lemon",
        hint: {
        words: ["apple", "orange", "watermelon", "lemon"],
        match: /\b(\w{1,})$/,
        search: function (keyword, callback) {
            callback(
            $.grep(this.words, function (item) {
                return item.indexOf(keyword) === 0
            })
            )
        },
        },
    })
}

$(document).ready(function(){    
    //var i=1;
    $('#add').click(function(){
        i++;
        $('#dynamic_field').append('<div class="row" id="block_'+i+'">'+
            '<div class="col-md-3 mt-3 p-3">'+
                '<label><b>Block <span>'+i+'</span></b></label>'+
            '</div>'+
            '<div class="col-md-5 mt-3 p-3">'+
                '<div class="form-group">'+
                    '<div class="form-check mandatory">'+
                        '<div class="position-relative">'+
                            '<fieldset class="form-group">'+
                                '<select class="form-select" id="block_'+i+'_type" name="block_'+i+'_type">'+
                                    '<option value="text_'+i+'">Text</option>'+
                                    '<option value="img_'+i+'">Image</option>'+
                                    '<option value="info_'+i+'">Box info</option>'+
                                    '<option value="gallery_'+i+'">Gallery</option>'+
                                    '<option value="quote_'+i+'">Quotes</option>'+
                                    postOptions+
                                '</select>'+
                            '</fieldset>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>'+
            '<div class="col-md-4 mt-3 p-3">'+
                '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button>'+
            '</div>'+
            '<div class="col-12 mt-3 mb-3 px-5 pb-3 border-bottom">'+
                '<div class="row page text_'+i+'">'+
                    '<textarea class="summernote" name="text_content_'+i+'"></textarea>'+
                    '<input type="hidden" name="text_'+i+'" value="t">'+
                '</div>'+
                '<div class="row page img_'+i+'">'+
                    '<label>Upload an image <span class="text-danger">*</span></label>'+
                    '<div class="form-group">'+
                        '<div class="form-check mandatory">'+
                            '<div class="position-relative">'+
                                '<input class="form-control" type="file" name="img_file_'+i+'" />'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<input type="hidden" name="img_'+i+'" value="img">'+
                '</div>'+
                '<div class="row page info_'+i+'">'+
                    '<label>Upload an image <span class="text-danger">*</span></label>'+
                    '<div class="form-group">'+
                        '<div class="form-check mandatory">'+
                            '<div class="position-relative">'+
                                '<input class="form-control" type="file" name="info_file_'+i+'" />'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<textarea class="summernote" class="mt-5" name="info_content_'+i+'"></textarea>'+
                    '<input type="hidden" name="info_'+i+'" value="info">'+
                '</div>'+
                '<div class="row page gallery_'+i+'">'+
                    '<div class="col-7">'+
                        '<label class="mb-3">Choose a gallery <span class="text-danger">*</span></label>'+
                        '<div class="form-group">'+
                            '<div class="form-check mandatory">'+
                                '<div class="position-relative">'+
                                    '<fieldset class="form-group">'+
                                        '<select class="form-select" name="gallery_name_'+i+'">'+
                                            galleryOptions+
                                        '</select>'+
                                    '</fieldset>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-5">&nbsp;</div>'+
                    '<input type="hidden" name="gallery_'+i+'" value="g">'+
                '</div>'+
                '<div class="row page quote_'+i+'">'+
                    '<p>Show a slideshow with quotes</p>'+
                    '<input type="hidden" name="quote_'+i+'" value="q">'+
                '</div>'+
                '<div class="row page post_'+i+'">'+
                    '<input type="hidden" name="post_'+i+'" value="p">'+
                    'post'+
                '</div>'+
            '</div>');

            $('#block_' + i + '_type').val('text_' + i);

            $('#block_' + i + '_type').on('change', function() {

                const selectedValue = $(this).val();
                const blockId = $(this).attr('id').replace('_type', '');
    
                // Nascondi tutte le righe relative al blocco corrente
                $('#' + blockId).find('.row.page').hide();
                $('#' + blockId).find('.row.page input').removeAttr('data-parsley-required'); // Rimuovi l'attributo quando la riga è nascosta
    
                // Mostra la riga corrispondente al valore selezionato
                $('#' + blockId).find('.' + selectedValue).show();
                $('#' + blockId).find('.' + selectedValue + ' input').attr('data-parsley-required', 'true');
            });
            $('#block_' + i + '_type').trigger('change');
    
            $('#counter').val(i);

            // Inizializza Summernote sulla nuova textarea aggiunta
            initializeSummernote();
    });
    
    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id"); 
        $('#block_'+button_id+'').remove();
    });
  });