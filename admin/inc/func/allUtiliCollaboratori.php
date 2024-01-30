<?php 
  $cfa->table = 'collaboratori' ;
  $collaboratori = $cfa->showAll('id');
?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Utili collaboratori</h3>
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
          Utili collaboratori
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
      <h4>Utili collaboratori &nbsp; &nbsp; &nbsp;</h4> 
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
          <div class="row">

            <div class="col-4">
              <form class="form form-horizontal p-2 mb-5 border-bottom" action="core/mngCollaboratori.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
              <div class="form-body">

                <div class="row">

                  <div class="col-md-3">
                      <label>Mese </label>
                  </div>
                  <div class="col-md-9 mb-3">
                    <div class="form-group">
                        <div class="form-check">
                            <div class="position-relative">
                              <select class="form-select" id="basicSelect" name="mese">
                                  <option value="01">Gennaio</option>
                                  <option value="02">Febbraio</option>
                                  <option value="03">Marzo</option>
                                  <option value="04">Aprile</option>
                                  <option value="05">Maggio</option>
                                  <option value="06">Giugno</option>
                                  <option value="07">Luglio</option>
                                  <option value="08">Agosto</option>
                                  <option value="09">settembre</option>
                                  <option value="10">Ottobre</option>
                                  <option value="11">Novembre</option>
                                  <option value="12">Dicembre</option>
                              </select>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                        <label>Anno </label>
                    </div>
                    <div class="col-md-9 mb-3">
                      <div class="form-group">
                          <div class="form-check">
                              <div class="position-relative">
                                <select class="form-select" name="anno">
                                <?php

                                  for($year=2012;$year<2050;$year++)
                                  {
                                ?>
                                    <option value="<?=$year?>"><?=$year?></option>
                                <?php
                                  }
                                ?>
                                </select>
                              </div>
                          </div>
                      </div>
                    </div>

                  <input type="hidden" name="query" value="mese">
                  <input type="hidden" name="origin" value="allUtiliCollaboratori">


                  <div class="col-12 d-flex justify-content-start">
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

            <div class="col-4">

              <form class="form form-horizontal p-2 mb-5 border-bottom" action="core/mngCollaboratori.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                <div class="form-body">
    
                  <div class="row">
                    <div class="col-md-3">
                        <label>Trimestre </label>
                    </div>
                    <div class="col-md-9 mb-3">
                      <div class="form-group">
                          <div class="form-check">
                              <div class="position-relative">
                                <select class="form-select" name="trimestre">
                                    <option value="01">Gennaio-Marzo</option>
                                    <option value="02">Aprile-Giugno</option>
                                    <option value="03">Luglio-Settembre</option>
                                    <option value="04">Ottobre-Dicembre</option>
                                </select>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                        <label>Anno </label>
                    </div>
                    <div class="col-md-9 mb-3">
                      <div class="form-group">
                          <div class="form-check">
                              <div class="position-relative">
                                <select class="form-select" name="anno">
                                <?php

                                  for($year=2012;$year<2050;$year++)
                                  {
                                ?>
                                    <option value="<?=$year?>"><?=$year?></option>
                                <?php
                                  }
                                ?>
                                </select>
                              </div>
                          </div>
                      </div>
                    </div>

                    <input type="hidden" name="query" value="trimestre">
                    <input type="hidden" name="origin" value="allUtiliCollaboratori">
    
    
                    <div class="col-12 d-flex justify-content-start">
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

            <div class="col-4">

              <form class="form form-horizontal p-2 mb-5 border-bottom" action="core/mngCollaboratori.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                <div class="form-body">

                  <div class="row">
                    <div class="col-md-3">
                        <label>Anno </label>
                    </div>
                    <div class="col-md-9 mb-3">
                      <div class="form-group">
                          <div class="form-check">
                              <div class="position-relative">
                              <select class="form-select" name="anno">
                                <?php

                                  for($year=2012;$year<2050;$year++)
                                  {
                                ?>
                                    <option value="<?=$year?>"><?=$year?></option>
                                <?php
                                  }
                                ?>
                                </select>
                              </div>
                          </div>
                      </div>
                    </div>
                    
                    <input type="hidden" name="query" value="anno">
                    <input type="hidden" name="origin" value="allUtiliCollaboratori">


                    <div class="col-12 d-flex justify-content-start">
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

        </div>
      </div>
      <?php

        $mese = '' ;
        $anno_mese = '' ;
        $trim = '' ;
        $anno_trim = '' ;
        $anno = '' ;
        $periodo = '' ;

        $months_arr = array(
          '01' => 'Gennaio', 
          '02' => 'Febbraio',
          '03' => 'Marzo',
          '04' => 'Aprile',
          '05' => 'Maggio',
          '06' => 'Giugno',
          '07' => 'Luglio',
          '08' => 'Agosto',
          '09' => 'Settembre',
          '10' => 'Ottobre',
          '11' => 'Novembre',
          '02' => 'Dicembre');

        if(filter_input(INPUT_GET,'mese'))
        {
          $mese = filter_input(INPUT_GET,'mese') ;
          $anno_mese = filter_input(INPUT_GET,'anno_mese') ;
          $periodo = $months_arr[$mese] . ' ' . $anno_mese ;

        }
        else if(filter_input(INPUT_GET,'trim'))
        {
          // serve anche l'anno
          $trim_arr = array(
            '01' => "Gennaio-Marzo",
            '02' => "Aprile-Giugno",
            '03' => "Luglio-Settembre",
            '04' => "Ottobre-Dicembre",
          );
          $trim = filter_input(INPUT_GET,'trim') ;
          $anno_trim = filter_input(INPUT_GET,'anno_trim') ; 
          $periodo = $trim_arr[$trim]. ' ' . $anno_trim  ;
          
        }
        else if(filter_input(INPUT_GET,'anno'))
        {
          $anno = filter_input(INPUT_GET,'anno') ;
          $periodo = 'anno '.$anno ;
        }
        else
        {
          $mese = date('m') ;
          $anno_mese = date('Y');
          $periodo = $months_arr[$mese] . ' ' . $anno_mese ;
        }

      ?>
      <h4>Utili Collaboratori -  <?=$periodo?></h4>
      <style>
      .dataTables_filter label {
        margin-left:5em;
      } 
    </style>
    <script>
      $(document).ready(function() {
          $('#table2').DataTable( {
            searching:true,
              dom: 'Bfrtip',
              buttons: [
                  'excel','print'
              ]
          } );
      } );
    </script>
      <!-- Basic Tables start -->
      <table class="table" id="table2">
        <thead>
          <tr>
            <th>Collaboratore</th>
            <th>Polizze stipulate</th>
            <th>Utili totali</th>
          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $collaboratori->fetch(PDO::FETCH_ASSOC))
        {
          extract($row);
          $cfa->id_collaboratore = $row['id'] ;
          $cfa->table = 'polizze' ;

            $stmt1 = $cfa->showAllWhere('id',['id_collaboratore']);
            
            //conteggio polizze nel periodo
           
            $count = $stmt1->rowCount();
            
            if( $count == 0 )
            {
              break;
            }

        
            $utili_consulenza = 0 ;
            $utili_premio = 0 ;
            // ciclo polizze
            
            while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
            {
              $check_break=0;
              
            extract($row1) ;
            
            if($mese)
            {

              if($anno_mese != date("Y",strtotime($row1['st'])))
              {
                $check_break ++ ;
              }
              
              if($mese != date("m",strtotime($row1['st'])))
              {
                $check_break ++ ;
              }
            }

            if($trim)
            {
              $trim_check = array(
                '01' => ['01','02','03'],
                '02' => ['04','05','06'],
                '03' => ['07','08','09'],
                '04' => ['10','11','12']
              );

              if($anno_trim != date("Y",strtotime($row1['st'])))
              {
                $check_break ++ ;
              }
              
              $mese_trim = date("m",strtotime($row1['st']));
              if(!in_array($mese_trim,$trim_check[$trim]))
              {
                $check_break ++ ;
              }

            }



            if($anno && $anno != date("Y",strtotime($row1['st'])))
            {
              $check_break ++ ;
            }

            // calcollo consulenza

            if($check_break != 0)
            {
              break;
            }

            $utili_consulenza += (($row1['consulenza']/100)*$row['consulenza_collab']) ;

            // calcolo premio
            $utili_premio += ($row1['netto']/100)*$row['premio_collab'] ;
          }



            $tot_utili = $utili_consulenza + $utili_premio ;
        ?>
          <tr>
            <td>
              <?=$row['cognome']?> <?=$row['nome']?>
            </td>
            <td>
              <?=$count?>
            </td>
            <td>
              <?=$tot_utili?>
            </td>



          </tr>
                          

                        

        <?php
        
      }

        ?>



        </tbody>
      </table>
    </div>
  </div>
</section>
