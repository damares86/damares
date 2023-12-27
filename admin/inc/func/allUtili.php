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
      <div class="row">
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
      </div>
      
      <!-- Basic Tables start -->
      <table class="table" id="table1">
        <thead>
          <tr>
            <th>Ragione sociale</th>
            <th>Sede legale</th>
            <th>Provvigioni</th>
            <th><?=$common_actions?></th>
          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $company->fetch(PDO::FETCH_ASSOC))
        {
          extract($row);
        ?>
          <tr>
            <td><?=$row['nome']?></td>
            <td><?=$row['sede_legale']?></td>
            <td><?=$row['provv']?></td>
            <td>
              <a href="index.php?p=editCompagnia&idToMod=<?=$row['id']?>" class="btn icon btn-warning"
                ><i class="bi bi-pencil-square"></i
              ></a>
              &nbsp; &nbsp;
              <a href="#" class="btn icon btn-danger"
                data-bs-toggle="modal"
                data-bs-target="#danger<?=$row['id']?>"><i class="bi bi-trash"></i>
              </a>
                  <!--Danger theme Modal -->
                  <div
                              class="modal fade text-left"
                              id="danger<?=$row['id']?>"
                              tabindex="-1"
                              role="dialog"
                              aria-labelledby="myModalLabel120"
                              aria-hidden="true"
                            >
                              <div
                                class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                role="document"
                              >
                                <div class="modal-content">
                                  <div class="modal-header bg-danger">
                                    <h5
                                      class="modal-title white"
                                      id="myModalLabel120"
                                    >
                                      <?=$common_modal_title_sure?>
                                    </h5>
                                    <button
                                      type="button"
                                      class="close"
                                      data-bs-dismiss="modal"
                                      aria-label="Close"
                                    >
                                      <i data-feather="x"></i>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <?=$account_all_modal_body?>
                                  </div>
                                  <div class="modal-footer">
                                    <button
                                      type="button"
                                      class="btn btn-light-secondary"
                                      data-bs-dismiss="modal"
                                    >
                                      <i class="bx bx-x d-block d-sm-none"></i>
                                      <span class="d-none d-sm-block"
                                        ><?=$common_modal_cancel?></span
                                      >
                                    </button>
                                      <span class="d-none d-sm-block"
                                        ><a href="core/mngCompagnie.php?idToDel=<?=$row['id']?>" class="btn btn-danger ml-1">
                                          <?=$common_modal_confirm?>
                                        </a></span
                                      >
                                  </div>
                                </div>
                              </div>
                            </div>
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
