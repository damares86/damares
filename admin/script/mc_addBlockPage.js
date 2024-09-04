$(document).ready(function(){    
    //var i=1;
    $('#add').click(function(){
        i++;
        $('#dynamic_field').append('<div class="row" id="block_'+i+'">'+
            '<div class="col-md-3 mt-3 mb-3 p-3">'+
                '<label><b>Block <span>'+i+'</span></b></label>'+
            '</div>'+
            '<div class="col-md-5 mt-3 mb-3 p-3">'+
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
                                    '<?php'+
                                        '$plugin->pluginname = "post";'+
                                        'if ($plugin->itemExists("pluginname") && $plugin->isActive() == 1) {'+
                                    '?>'+
                                        '<option value="post_'+i+'">Latest post</option>'+
                                    '<?php'+
                                        '}'+
                                    '?>'+

                                '</select>'+
                            '</fieldset>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>'+
            '<div class="col-md-4 mt-3 mb-3 p-3">'+
                '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button>'+
            '</div>'+
            '<div class="col-12 mt-3 mb-3 p-5 border-bottom">'+
                '<div class="row page text_'+i+'">'+
                    '<input type="hidden" name="text_'+i+'" value="t">'+
                    'text'+
                '</div>'+
                '<div class="row page img_'+i+'">'+
                    '<input type="hidden" name="img_'+i+'" value="img">'+
                    'img'+
                '</div>'+
                '<div class="row page info_'+i+'">'+
                    '<input type="hidden" name="info_'+i+'" value="info">'+
                    'info'+
                '</div>'+
                '<div class="row page gallery_'+i+'">'+
                    '<input type="hidden" name="gallery_'+i+'" value="g">'+
                    'gallery'+
                '</div>'+
                '<div class="row page quote_'+i+'">'+
                    '<input type="hidden" name="quote_'+i+'" value="q">'+
                    'quote'+
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
    });
    
    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id"); 
        $('#block_'+button_id+'').remove();
    });
  });