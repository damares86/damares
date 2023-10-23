<?php

$rate->table = "rate_cat";
$stmt = $rate->showAll('id');

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$all_rate_header?></h3>
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
          <?=$all_rate_header?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>


<!-- Basic Tables start -->
<section class="section">


                   <div class="row">
                     <?php
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          ?>
          <div class="card col-lg-6 p-3"> 

        <?php
          extract($row);
          
          $rate->table = "rate_cat";
          $rate->id = $row['id'];
          $stmt3 = $rate->showAllWhere('id',['id']);
          $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
          extract($row3);
          $rate_item_table = $row3['cat_name'];      

          $rate->table = "item_rate";
          $rate->rate_cat_id = $row['id'] ;
          $rate->rate_active = 1 ;

          $stmt1 = $rate->showAllWhere('id',['rate_cat_id','rate_active']);
          $item_active = [] ;

          $i = 0 ;

          foreach($stmt1 as $row1){
            if($i<5){
              $rate->table = "rate" ;
              $rate->item_rate_id = $row1['id'];
              $stmt2 = $rate->showAllWhere('id',['item_rate_id']);
              $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
              extract($row2);

              $rate_id = $row2['item_rate_id'];
              $rate_percent = $row2['percent'];

              $rate->table = $rate_item_table ;
              $rate->id = $row1['item_id'];
              $stmt4 = $rate->showAllWhere('id',['id']);
              $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
              extract($row4);

              $item_active[]=array( 
                "id" => $row2['item_rate_id'],
                "name" => $row4[$rate_item_table."_name"],
                "percent" => $row2['percent'] 
              );
              $i++;
            }

          }

          RowsSortHelperTool::sort($item_active,['percent'=>'desc']);

          $label = "rate_$rate_item_table";
          $label_cat_name = $$label ;
          ?>
          <h3><?=$label_cat_name?></h3>
          <div class="row">
            
          <?php
          foreach($item_active as $item){

                   ?>
            <div class="col-4">
              <p><?=$item['name']?></p>
            </div>
            <div class="col-8">
              <div class="card-body p-2">
                <div class="progress progress-primary progress-sm mb-4">
                    <div class="progress-bar progress-label" role="progressbar" style="width: <?=$item['percent']?>%" aria-valuenow="<?=$item['percent']?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
            <?php
          }
        ?>
          </div>
          </div>
        <?php
        }
        ?>
        </div>
  <div class="card">

        <div class="card-body">

        <table class="table" id="tab">
        <thead>
          <tr>
            <th><?=$all_rate_item?></th>
            <th><?=$all_rate_category?></th>
            <th><?=$all_rate_star?></th>
            <th><?=$all_rate_percent?></th>
          </tr>
        </thead>
        <tbody>
      <?php

        $rate->table = "item_rate";
        $rate->rate_active=1;
        $stmt = $rate->showAllWhere('id',['rate_active']);

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

          extract($row);
          $item_id = $row['id'];

          $rate->table="rate_cat";
          $rate->id=$row['rate_cat_id'];
          $stmt1 = $rate->showAllWhere('id',['id']);
          $row1=$stmt1->fetch(PDO::FETCH_ASSOC);
          extract($row1);

          ?>
          <tr>
            <td>
              <?php

                $rate->id = $row['item_id'];
                $stmt2 = $rate->showAllWhereTable('id',''.$row1['cat_name'].'',['id']);
                $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
                extract($row2);
                echo $row2[$row1['cat_name'].'_name'];
              ?>  
            </td>
            <td>
              <?php
                  $cat_name = $row1['cat_name'];
                  $label = "rate_$cat_name";
                  $label_cat_name = $$label ;
                  echo $label_cat_name;
              ?>
            </td>
            <?php
              $rate->table="rate";
              $rate->item_rate_id = $item_id;

              $stmt3 = $rate->showAllWhere('id',['item_rate_id']);
              $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
              extract($row3);
            ?>
            <td><?=$row3['star_vote']?>/5</td>
            <td><?=$row3['percent']?>%</td>
          </tr>

          <?php
            }
            
          ?>
        </tbody>
        <tfoot>
            <th><?=$all_rate_item?></th>
            <th><?=$all_rate_category?></th>
            <th><?=$all_rate_star?></th>
            <th><?=$all_rate_percent?></th>
        </tfoot>
      </table>

    </div>
  </div>
  </div>
</section>
