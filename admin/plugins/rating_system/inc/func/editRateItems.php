<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$rate_items_header?></h3>
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
            <?=$rate_items_header?> 
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>


<!-- Basic Tables start -->
<section class="section">
  <div class="card">

    <div class="card-body">
    <h4><?=$rate_items_title?></h4>
      <table class="table" id="tab">
        <thead>
          <tr>
            <th><?=$rate_items_item?></th>
            <th><?=$rate_items_category?></th>
            <th><?=$rate_items_active?></th>
            <th><?=$common_actions?></th>
          </tr>
        </thead>
        <tbody>
      <?php

        $rate->table = "item_rate";
        $stmt = $rate->showAll('id');
        
        $arr_tot=[];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

          extract($row);

          $rate->table="rate_cat";
          $rate->id=$row['rate_cat_id'];
          $stmt1 = $rate->showAllWhere('id',['id']);
          $row1=$stmt1->fetch(PDO::FETCH_ASSOC);
          extract($row1);
          $button_bg = "success";
          $button_icon = "check-circle";
          $line_bg="";
          $activate="yes";
          if($row['rate_active']==1){
            $button_bg = "danger";
            $button_icon = "x-circle";
            $line_bg = "class='bg-success text-white'";
            $activate="no";

          }
          ?>
          <tr <?=$line_bg?>>
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
            <td><?=$row['rate_active']?></td>
            <td>
              <a href="core/mngRate.php?act=<?=$activate?>&idToMod=<?=$row['id']?>" class="btn icon btn-<?=$button_bg?>"
                ><i class="bi bi-<?=$button_icon?>"></i
              ></a>

            </td>
          </tr>

          <?php
            }
            
          ?>
        </tbody>
        <tfoot>
            <th><?=$rate_items_item?></th>
            <th><?=$rate_items_category?></th>
            <th><?=$rate_items_active?></th>
            <th><?=$common_actions?></th>
        </tfoot>
      </table>

    </div>
  </div>
</section>
