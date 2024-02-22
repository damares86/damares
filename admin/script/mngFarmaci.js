$(document).ready(function(){

    
    //var i=1;
    $('#add').click(function(){
        i++;
        $('#dynamic_field').append('<div class="row" id="row'+i+'">'+     
        '<div class="col-md-2">'+
            '<label>Principio attivo <span class="text-danger">*</span></label>'+
        '</div>'+
        '<div class="col-md-5">'+
            '<div class="form-group">'+
                '<div class="form-check mandatory">'+
                    '<div class="position-relative">'+
                    '<fieldset class="form-group">'+
                        '<select '+
                        'class="form-select"'+
                        'name="f_'+i+'">\n'+                        
                        '<?php\n'+
                            '\$rsa->table = "farmaci" ;\n'+
                            '\$stmt = \$rsa->showAll(\'id\');\n'+
                            'while(\$row = \$stmt-\>fetch(PDO::FETCH_ASSOC)){\n'+
                        '?>\n'+
                            '<option value="<?=\$row[\'id\']?>"><?=\$row[\'principio\']?></option>'+
                        '<?php'+
                        '}'+
                        '?>'+
                        '</select>'+
                    '</fieldset>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>'+
        '<div class="col-md-2">N° cpr die</div>'+
        '<div class="col-md-2">'+
            '<div class="form-group">'+
                '<div class="form-check mandatory">'+
                    '<div class="position-relative">'+
                        '<input '+
                        'type="text"'+
                        'class="form-control"'+
                        'placeholder="0"'+
                        'name="cpr_'+i+'"'+
                        'data-parsley-required="true"'+
                        '/>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>'+
        '<div class="col-md-1">'+
        '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove p-2 text-center">x</button>'+
        '</div>'+
        '<span class="mb-3"></span>'+
    '</div>');
                      $('#counter').val(i);
    });
    
    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id"); 
        $('#row'+button_id+'').remove();
    });
  });