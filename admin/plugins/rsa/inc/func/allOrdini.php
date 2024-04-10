<?php 

  $mese = filter_input(INPUT_GET,'mese');
  $anno = date('Y');

  $file='inc/ordini/ordine.json';

  $data = file_get_contents($file);
  $dataArr = json_decode($data,true);

?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Ordini</h3>
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
          Ordini
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>


<section class="section">
  <div class="card shadow">
    <div class="card-header">
    </div>
    <div class="card-body">

    <h4>Ordine  <?=$mese?>/<?=$anno?></h4> 
   
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
            <th>Principio attivo</th>
            <th>Totale compresse</th>
            <th>Scatole da ordinare</th>
            <th>Pazienti</th>
          </tr>
        </thead>
        <tbody>
          
        <?php

        for( $i=0; $i<count($dataArr); $i++ )
        {
          
        ?>
          <tr>
            <td><?=$dataArr[$i]['farmaco']?></td>
            <td>
              <?php
                $cpr = ceil($dataArr[$i]['compresse']);
                echo $cpr ;
                ?>
            </td>
            <td><?=$dataArr[$i]['scatole']?></td>
            <td>
              <?php
                for($idx = 0 ; $idx<(count($dataArr[$i]['pazienti'])); $idx++)
                {
                  echo $dataArr[$i]['pazienti'][$idx].'<br>';
                }
              ?>
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
