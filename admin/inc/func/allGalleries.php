<?php
$mc->table = 'mc_galleries';
$gall = $mc->showAll('id');
?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Galleries</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Galleries
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>


<!-- Basic Tables start -->
<section class="section">
  <div class="card shadow">
    <div class="card-header">All Galleries &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      <a href="index.php?p=addGallery" class="btn icon icon-left btn-success shadow">
        <i data-feather="plus-circle"></i> Add a Gallery
      </a>
    </div>
    <div class="card-body">

      <div class="row">
        <?php
        while ($row = $gall->fetch(PDO::FETCH_ASSOC)) {
          $images = glob("../uploads/gallery/g_".$row['id']."/*") ;
          if(count($images)>0){

        ?>
          <div class="col-6 col-lg-4 col-md-6">
            <div class="card border">
              <div class="card-body px-4 py-4-5">

                <div class="row">

                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="font-extrabold mb-2"><?= $row['gallery_name'] ?></h6>
                    <?php

                    ?>
                    <img src="<?=$images[0]?>" class="w-100">
                  </div>
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5">
                    <a href="index.php?p=editGallery&idToMod=<?=$row['id']?>&pagename=allGalleries">
                      <div class="stats-icon bg-warning mb-2">
                        <i class="bi-pencil-square"></i>
                      </div>
                    </a>
                    <div class="stats-icon bg-danger mb-2">
                      <i class="bi-trash"></i>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        <?php
          }else{
            echo "No images in this gallery";
          }

        }


        ?>
      </div>



      </tbody>
      </table>
    </div>
  </div>
</section>