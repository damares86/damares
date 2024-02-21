$(document).ready(function(){

    
    //var i=1;
    $('#add').click(function(){
        i++;
        $('#dynamic_field').append('<div class="row" id="row'+i+'">'+
          '<div class="col-md-3 pt-3 border-top">'+
                          '<label>Domanda  <span class="text-danger">*</span></label><br>'+
                          '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button>'+
                      '</div>'+
                      '<div class="col-md-9 pt-3 border-top" id="q_'+i+'">'+
                        '<div class="form-group">'+
                                '<div class="position-relative">'+
                                '<textarea '+
                                  'rows="3" '+
                                  'class="form-control" '+
                                  'name="q_'+i+'" '+
                                  'data-parsley-required="true">Testo della domanda</textarea>'+
                                '</div>'+
                            '</div>'+
                          '</div>'+
                      '<div class="col-md-3 pt-3">'+
                          '<label>Risposte</label>'+
                      '</div>'+
                      '<div class="col-md-9 pt-3">'+
                          '<div class="form-group">'+
                              '<div class="form-check mandatory">'+
                                  '<div class="position-relative">'+
                                  '<div class="row mb-3">'+
                                      '<div class="col-md-2">'+
                                          '<label>1 <span class="text-danger">*</span></label>'+
                                      '</div>'+
                                      '<div class="col-md-10">'+
                                          '<input class="form-check-input" type="radio" name="a_'+i+'[]" value="0"> Corretta'+
                                      '</div>'+
                                  '</div>'+
                                  '<input type="text" class="form-control" placeholder="Risposta" name="o_'+i+'[]" data-parsley-required="true"/>'+
                                  '</div>'+
                              '</div>'+
                          '</div>'+
                          '<div class="form-group">'+
                              '<div class="form-check mandatory">'+
                                  '<div class="position-relative">'+
                                  '<div class="row mb-3">'+
                                      '<div class="col-md-2">'+
                                          '<label>2 <span class="text-danger">*</span></label>'+
                                      '</div>'+
                                      '<div class="col-md-10">'+
                                          '<input class="form-check-input" type="radio" name="a_'+i+'[]" value="1"> Corretta'+
                                      '</div>'+
                                  '</div>'+
                                  '<input type="text" class="form-control" placeholder="Risposta" name="o_'+i+'[]" data-parsley-required="true"/>'+
                                  '</div>'+
                              '</div>'+
                          '</div>'+
                          '<div class="form-group">'+
                              '<div class="form-check mandatory">'+
                                  '<div class="position-relative">'+
                                  '<div class="row mb-3">'+
                                      '<div class="col-md-2">'+
                                          '<label>3 </label>'+
                                      '</div>'+
                                      '<div class="col-md-10">'+
                                          '<input class="form-check-input" type="radio" name="a_'+i+'[]" value="2"> Corretta'+
                                      '</div>'+
                                  '</div>'+
                                  '<input type="text" class="form-control" placeholder="Risposta" name="o_'+i+'[]"/>'+
                                  '</div>'+
                              '</div>'+
                          '</div>'+
                          '<div class="form-group">'+
                              '<div class="form-check mandatory">'+
                                  '<div class="position-relative">'+
                                  '<div class="row mb-3">'+
                                      '<div class="col-md-2">'+
                                          '<label>4 </label>'+
                                      '</div>'+
                                      '<div class="col-md-10">'+
                                          '<input class="form-check-input" type="radio" name="a_'+i+'[]" value="3"> Corretta'+
                                      '</div>'+
                                  '</div>'+
                                  '<input type="text" class="form-control" placeholder="Risposta" name="o_'+i+'[]" />'+
                                  '</div>'+
                              '</div>'+
                          '</div>'+
                          
                          '<div class="form-group">'+
                              '<div class="form-check mandatory">'+
                                  '<div class="position-relative">'+
                                  '<div class="row mb-3">'+
                                      '<div class="col-md-2">'+
                                          '<label>4 </label>'+
                                      '</div>'+
                                      '<div class="col-md-10">'+
                                          '<input class="form-check-input" type="radio" name="a_'+i+'[]" value="4"> Corretta'+
                                      '</div>'+
                                  '</div>'+
                                  '<input type="text" class="form-control" placeholder="Risposta" name="o_'+i+'[]" />'+
                                  '</div>'+
                              '</div>'+
                          '</div>'+
                      '</div>');
                      $('#counter').val(i);
    });
    
    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id"); 
        $('#row'+button_id+'').remove();
    });
  });