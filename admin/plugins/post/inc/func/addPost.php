<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Aggiungi post</h3>
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
          Aggiungi post
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card shadow">
                <div class="card-header">
                <h4 class="card-title">Aggiungi un nuovo post</h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngPost.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label>Titolo<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Titolo del post"
                                        id="first-name"
                                        name="title"
                                        data-parsley-required="true"

                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mt-3">
                            <label>Categorie  <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9 mt-3">
                         <div class="form-group">
                                <select
                                class="choices form-select multiple-remove"
                                multiple="multiple" name="categories[]"
                                >
                                <?php
                                    $post->table = 'post_categories' ;
                                    $stmt = $post->showAll('id');
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        extract($row);
                                        $selected = "" ;

                                        // if(in_array($row['id'],$sections)){
                                        //     $selected = "selected";
                                        // }
                                ?>

                                    <option value="<?=$row['id']?>" <?=$selected?>><?=$row['category_name']?></option>

                                <?php
                                        $selected = "" ;

                                }
                                ?>

                                </select>
                            </div>
                        </div>               
                            
                        <div class="col-md-3 mt-3">
                            <label>Immagine principale <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9 mt-3">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        class="form-control"
                                        type="file"
                                        id="formFile"
                                        name="myfile"
                                        data-parsley-required="true"
                                    />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-9">
                            <div class="progress"></div>
                            <div class="result"></div>
                        </div> -->

                        <div class="col-md-3 my-3">
                            <label>Contenuto<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9 my-3">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <textarea name="content" id="default" cols="30" rows="15"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>


                        
                        <input type="hidden" name="author" value="<?=$_SESSION['username']?>">
                        <input type="hidden" name="operation" value="add">
                        <input type="hidden" name="origin" value="addPost">
                      
                        <div class="col-12 d-flex justify-content-end">
                            <button
                            type="submit"
                            class="btn btn-primary me-1 mb-1 shadow"
                            >
                            <?=$common_submit?>
                            </button>
                            <button
                            type="reset"
                            class="btn btn-light-secondary me-1 mb-1 shadow"
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
        <div class="col-md-4 col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title"><?=$common_info?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>