<?php 
  $cfa->table = 'pag_collaboratore' ;
  $collaboratori = $cfa->showAll('id');
?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Da pagare collaboratori</h3>
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
          Da pagare collaboratori
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
      <!-- query form -->
      <div class="row  border-bottom py-3 my-3">

      <h4>Da pagare Collaboratori</h4>
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
            <th>Da pagare</th>
          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $collaboratori->fetch(PDO::FETCH_ASSOC))
        {
          extract($row);
          if($row['da_pagare'] == 0 )
          {
            break;
          }

          $cfa->id = $row['id_collaboratore'] ;
          $cfa->table = 'collaboratori' ;
          $stmt1 = $cfa->showAllWhere('id',['id']) ;
          $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
          extract($row1);

        ?>
          <tr>
            <td>
              <?=$row1['cognome']?> <?=$row1['nome']?>
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
