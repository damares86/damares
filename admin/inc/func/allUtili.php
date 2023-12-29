<?php 
  $cfa->table = 'compagnie' ;
  $company = $cfa->showAll('id');
  $apex=true;
  // first field
  $title1 = "Netto" ;
  $data1 =  [44, 55, 57, 56, 61, 58, 63, 60, 66] ;
  $arr1 = implode(',',$data1);
  // second field
  $title2 = "Imponibile" ;
  $data2 =  [76, 85, 101, 98, 87, 105, 91, 114, 94] ;
  $arr2 = implode(',',$data2);
  // third field
  $title3 = "Dare" ;
  $data3 =  [35, 41, 36, 26, 45, 48, 52, 53, 41] ;
  $arr3 = implode(',',$data3);
?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Utili</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav
        aria-label="breadcrumb"
        class="breadcrumb-header float-start float-lg-end"
      >
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?=$common_dashboard?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
          Utili
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>


<section class="section">
  <div class="card">
    <div class="card-header">
      <h4>Utili CFA &nbsp; &nbsp; &nbsp;</h4> 
    </div>
    <div class="card-body">

    <!-- chart -->
      <!-- <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header">
              <h4>Bar Chart</h4>
            </div>
            <div class="card-body">
              <div id="bar"></div>
            </div>
          </div>
        </div>
      </div> -->

      <!-- query form -->
      <div class="row border-top border-bottom py-3 my-3">
        <div class="col">
          <h4>Filtra risultati &nbsp; &nbsp; &nbsp;</h4> 

          <form class="form form-horizontal" action="core/mngPolizze.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
            <div class="form-body">

              <div class="row">

                <div class="col-md-3">
                    <label>Data d'inizio </label>
                </div>
                <div class="col-md-3 mb-3">
                  <div class="form-group">
                      <div class="form-check">
                          <div class="position-relative">
                              <input
                              type="date"
                              class="startDate input form-control"
                              id="startDate"
                              name="st"
                              />
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-6 px-5">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" 
                    name="start_date" id="start_date1" value="before">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Prima di
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" 
                    name="start_date" id="start_date2" value="after" checked>
                    <label class="form-check-label" for="flexRadioDefault1">
                      Dopo
                    </label>
                  </div>
                </div>
                
                <script>
                    $('.startDate').change(function(){
                    var startDate = $('.startDate').val();

                    if(startDate != ''){
                        var d = new Date(Date.parse(startDate));      
                        var dmy = [d.getDate(),d.getMonth() + 1,d.getFullYear()];
                        
                        // Format date
                        for (var n = 0; n < 2; n++){
                        if (dmy[n].toString().length < 2){
                            dmy[n] = "0" + dmy[n];
                        }
                        }
                        
                        $('.endDate').attr('min',(dmy[2] + "-" + dmy[1] + "-" + dmy[0]));
                        
                        if($('.dateRange select').val() == 'Between' && $('.endDate').val() != ''){
                        $('.endDate').parsley().validate();
                        }
                    }
                    });
                </script>

                <div class="col-md-3">
                    <label>Data di fine </label>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="form-check">
                        <div class="position-relative">
                            <input
                            type="date"
                            class="endDate form-control"
                            name="et"
                            data-parsley-gt="#st"
                            />
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-6 px-5">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" 
                    name="end_date" id="end_date1" value="before" checked>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Prima di
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" 
                    name="end_date" id="end_date2" value="after">
                    <label class="form-check-label" for="flexRadioDefault1">
                      Dopo
                    </label>
                  </div>
                </div>
               
                <input type="hidden" name="operation" value="query">
                <input type="hidden" name="origin" value="allUtili">


                <div class="col-12 d-flex justify-content-end">
                  <button
                  type="submit"
                  class="btn btn-primary me-1 mb-1"
                  >
                  <?=$common_submit?>
                  </button>
                  <button
                  type="reset"
                  class="btn btn-light-secondary me-1 mb-1"
                  >
                  <?=$common_reset?>
                  </button>
              </div>
              </div>
            </div>
          </form>
          
        </div>
      </div>
      
      <!-- Basic Tables start -->
      <table class="table" id="table1">
        <thead>
          <tr>
            <th>Compagnia</th>
            <th>Da pagare compagnia</th>
            <th>Dare/avere compagnia</th>
            <th>Provv. Consul. Dare</th>




          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $company->fetch(PDO::FETCH_ASSOC))
        {
          extract($row);
          $cfa->id_compagnia = $row['id'] ;
          $cfa->table = 'polizze' ;
          if(filter_input(INPUT_GET,'query'))
          {
            $where = [] ;
            $stmt1 = '' ;

            if( filter_input(INPUT_GET,'st') && filter_input(INPUT_GET,'et') )
            {

              $cfa->st = filter_input(INPUT_GET,'st') ;
              $where[] = 'st' ;
              $op1 = '' ;
              if( filter_input(INPUT_GET,'st_op') == 'before' )
              {
                $op1 = '<' ;
              }
              else
              {
                $op1 = '>' ;
              }

              $cfa->et = filter_input(INPUT_GET,'et') ;
              $where[] = 'et' ;
              $op2 = '' ;
              if( filter_input(INPUT_GET,'et_op') == 'before' )
              {
                $op2 = '<' ;
              }
              else
              {
                $op2 = '>' ;
              }

              $cfa->showAllWhereBetween('id',$op1,$op2,$where);
            }

            if( filter_input(INPUT_GET,'st') )
            {
                $cfa->st = filter_input(INPUT_GET,'st') ;
                $where[] = 'st' ;
            }

            if( filter_input(INPUT_GET,'et') )
            {
                $cfa->et = filter_input(INPUT_GET,'et') ;
                $where[] = 'et' ;
            }
            
            $stmt1 = $cfa->showAllWhereGtLt('id','>',$where) ;

          }
          else
          {
            $stmt1 = $cfa->showAllWhere('id',['id_compagnia']);
          }

          // variable

          $da_pagare_compagnia = 0 ;
          $provv_consul_dare = 0 ;
          $provv_premio_dare = 0 ;

          while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC) )
          { 
            extract($row1);
            
            $da_pagare_compagnia += $row['lordo'] + $row1['pagato'] ;

            $provv_consul_dare += ( $row1['consulenza'] / 100 ) * $row1['broker'] ;

            // cercare collaboratore

            // $provv_premio_dare += ( $row['netto'] / 100 ) 

          }

          $dare_avere_compagnia = $da_pagare_compagnia - (($da_pagare_compagnia / 100) * $row['provv']) ;

        ?>
          <tr>
            <td><?=$row['nome']?></td>
            <td><?=$da_pagare_compagnia?></td>
            <td><?=$dare_avere_compagnia?></td>
            <td><?=$provv_consul_dare?></td>




          </tr>
                          

                        

        <?php
        
      }

        ?>



        </tbody>
      </table>
    </div>
  </div>
</section>
