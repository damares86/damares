<?php 
  $cfa->table = 'pag_compagnia' ;
  $compagnie = $cfa->showAll('id');
?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Da pagare compagnie</h3>
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
          Da pagare compagnie
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>


<section class="section">
  <div class="card">
    
    <div class="card-body">


      <h4>Da pagare Compagnie</h4>
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
            <th>Compagnia</th>
            <th>Da pagare</th>
          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $compagnie->fetch(PDO::FETCH_ASSOC))
        {
          extract($row);
          if($row['da_pagare'] == 0 )
          {
            break;
          }

          $cfa->id = $row['id_compagnia'] ;
          $cfa->table = 'compagnie' ;
          $stmt1 = $cfa->showAllWhere('id',['id']) ;
          $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
          extract($row1);

        ?>
          <tr>
            <td>
              <?=$row1['nome']?>
            </td>
            <td>
              <?=$row['da_pagare']?>
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
