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

          <form class="form form-horizontal" action="core/mngCollaboratori.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
            <div class="form-body">

              <div class="row">

                <div class="col-md-3">
                    <label>Mese </label>
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
                <!-- DA CORREGGERE -->
                <input type="hidden" name="operation" value="query">
                <input type="hidden" name="origin" value="allUtiliCollaboratori">


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
            <th>Collaboratore</th>
            <th>Polizze stipulate</th>
            <th>Utili totali</th>
            <th>Esporta XLSX</th>
          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $collaboratori->fetch(PDO::FETCH_ASSOC))
        {
          extract($row);
          $cfa->id_collaboratore = $row['id'] ;
          $cfa->table = 'polizze' ;
          if(filter_input(INPUT_GET,'time'))
          {

            $time = filter_input(INPUT_GET,'time') ;

            // FILTRI PER MESE, TRIMESTRE E ANNO

          }
          else
          {

            $stmt1 = $cfa->showAllWhere('id',['id_collaboratore']);
            $count = $stmt1->rowCount();
            
          }

          // ciclo polizze
          while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
          {

            extract($row1) ;

            
          }
        ?>
          <tr>
            <td>
              <?=$row['cognome']?> <?=$row['nome']?>
            </td>
            <td>
              <?=$count?>
            </td>
            <td>
              <!-- calcolo utili -->
            </td>
            <td>
              <!-- button -->
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
