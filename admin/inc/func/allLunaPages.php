<?php

$luna->table = 'luna_parent';
$stmt = $luna->showAll('id');

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Pages Management</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Pages Management
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
    <div class="card-header">Manage pages &nbsp; &nbsp; &nbsp;
      <a href="index.php?p=addLunaPage" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> Add a new parent page</a>
    </div>
    <div class="card-body">

      <div class='wrapper'>

        <div id='parent-block' class='container-pages p-3'>
          Nome prodotto
          <div id="parent_1" class='container-pages parent_item px-5 rounded m-2'> <!-- p_1 deve essere l'id della pagina-->

            pagina parent 1
            <a class="btn icon btn-sm btn-info mx-2" data-bs-toggle="collapse" href="#child_1" role="button" aria-expanded="false" aria-controls="child_1">
              <i class="bi bi-chevron-down"></i>
            </a>
            <div id="child_1" class='collapse container-pages child_block p-2 rounded m-2'> <!-- 1 deve essere l'id della pagina-->
              <div id="p_1_c_1" class="child_item rounded m-2">
                pagina child 1
                <a class="btn icon btn-sm btn-info mx-2" data-bs-toggle="collapse" href="#paragraph_1" role="button" aria-expanded="false" aria-controls="child_1">
                  <i class="bi bi-chevron-down"></i>
                </a>
                <div id="paragraph_1" class='collapse container-pages paragraph_block p-2 rounded m-2'><!-- 1 deve essere l'id della pagina child a cui appartengono i paragrafi-->
                  <div id="c_1_p_1" class="paragraph_item rounded m-2">paragraph 1</div> <!-- 1 deve essere l'id del paragrafo-->
                  <div id="c_1_p_2" class="paragraph_item rounded m-2">paragraph 2</div>
                  <div id="c_1_p_3" class="paragraph_item rounded m-2">paragraph 3</div>
                </div>
              </div>
              <div id="p_1_c_2" class="child_item rounded m-2">pagina child 2</div>
              <div id="p_1_c_3" class="child_item rounded m-2">
                pagina child 3
                <a class="btn icon btn-sm btn-info mx-2" data-bs-toggle="collapse" href="#paragraph_3" role="button" aria-expanded="false" aria-controls="child_1">
                  <i class="bi bi-chevron-down"></i>
                </a>
                <div id="paragraph_3" class='collapse container-pages paragraph_block p-2 rounded m-2'><!-- 1 deve essere l'id della pagina child a cui appartengono i paragrafi-->
                  <div id="c_3_p_1" class="paragraph_item rounded m-2">paragraph 1</div>
                  <div id="c_3_p_2" class="paragraph_item rounded m-2">paragraph 2</div>
                  <div id="c_3_p_3" class="paragraph_item rounded m-2">paragraph 3</div>
                </div>
              </div>
              <div id="p_1_c_4" class="child_item rounded m-2">pagina child 4</div>
            </div>
          </div>
          <div id="parent_2" class='container-pages parent_item rounded px-5 m-2'> <!-- p_1 deve essere l'id della pagina-->
            pagina parent 2
            <a class="btn icon btn-sm btn-info mx-2" data-bs-toggle="collapse" href="#child_2" role="button" aria-expanded="false" aria-controls="child_1">
              <i class="bi bi-chevron-down"></i>
            </a>
            <div id="child_2" class='collapse container-pages child_block p-2 rounded m-2'> <!-- 1 deve essere l'id della pagina-->
              <div id="p_2_c_5" class="child_item rounded m-2">
                pagina child 5
                <a class="btn icon btn-sm btn-info mx-2" data-bs-toggle="collapse" href="#paragraph_5" role="button" aria-expanded="false" aria-controls="child_1">
                  <i class="bi bi-chevron-down"></i>
                </a>
                <div id="paragraph_5" class='collapse container-pages paragraph_block p-2 rounded m-2'><!-- 1 deve essere l'id della pagina child a cui appartengono i paragrafi-->
                  <div id="c_5_p_1" class="paragraph_item rounded m-2">paragraph 1</div> <!-- 1 deve essere l'id del paragrafo-->
                  <div id="c_5_p_2" class="paragraph_item rounded m-2">paragraph 2</div>
                  <div id="c_5_p_3" class="paragraph_item rounded m-2">paragraph 3</div>
                </div>
              </div>
              <div id="p_2_c_7" class="child_item rounded m-2">pagina child 7
                <a class="btn icon btn-sm btn-info mx-2" data-bs-toggle="collapse" href="#paragraph_7" role="button" aria-expanded="false" aria-controls="child_1">
                  <i class="bi bi-chevron-down"></i>
                </a>
                <div id="paragraph_7" class='collapse container-pages paragraph_block p-2 rounded m-2'><!-- 1 deve essere l'id della pagina child a cui appartengono i paragrafi-->
                  <div id="c_7_p_1" class="paragraph_item rounded m-2">paragraph 1</div>
                  <div id="c_7_p_2" class="paragraph_item rounded m-2">paragraph 2</div>
                  <div id="c_7_p_3" class="paragraph_item rounded m-2">paragraph 3</div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>


    <button id="save" class="btn btn-success m-3 w-25">Save</button>

  </div>
  </div>
</section>


<script src='script/dragula.js'></script>
<script>
  var blocks_array = [];

  // ciclo tutti i parent, poi i relativi child e per ogni child i relativi paragraph
  // ogni volta che ho un id devo creare la variabile tipo c_1 e pushare l'id dell'elemento nell'array 'blocks_array'
  // es ho l'id della pagina child 2 quindi
  // var c_2 = 'child_2';
  // blocks_array.push(c_2);

  var p = 'parent-block';
  blocks_array.push(p);
  var c_1 = 'child_1';
  blocks_array.push(c_1);
  var c_2 = 'child_2';
  blocks_array.push(c_2);
  var p_1 = 'paragraph_1';
  blocks_array.push(p_1);
  var p_3 = 'paragraph_3';
  blocks_array.push(p_3);
  var p_5 = 'paragraph_5';
  blocks_array.push(p_5);
  var p_7 = 'paragraph_7';
  blocks_array.push(p_7);
  console.log(blocks_array)
</script>
<script src='script/example.min.js'></script>

<script>
  // da modificare per intercettare tutti i container in ordine
  $("#save").click(function() {
    const data = $('#left-events > div').map(function(index, el) {
      return el.id
    }).get()

    console.log(data)
  })
</script>