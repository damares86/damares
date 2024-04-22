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
      <div class='examples'>

        <div class='parent'>
          <label for='hy'>There are plenty of events along the lifetime of a drag event. Check out <a href='https://github.com/bevacqua/dragula#drakeon-events'>all of them</a> in the docs!</label>
          <div class='wrapper'>

            <div id='parent-block' class='container-pages'>
              <div id="parent_1" class='container-pages'> <!-- p_1 deve essere l'id della pagina-->
                
                pagina parent 1
                <div id="child_1" class='container-pages'> <!-- 1 deve essere l'id della pagina-->
                  <div id="p_1_c_1">
                    pagina child 1
                    <div id="paragraph_1" class='container-pages'><!-- 1 deve essere l'id della pagina child a cui appartengono i paragrafi-->
                      <div id="c_1_p_1">paragraph 1</div> <!-- 1 deve essere l'id del paragrafo-->
                      <div id="c_1_p_2">paragraph 2</div>
                      <div id="c_1_p_3">paragraph 3</div>
                    </div>
                  </div>
                  <div id="p_1_c_2">pagina child 2</div>
                  <div id="p_1_c_3">
                    pagina child 3
                    <div id="paragraph_3" class='container-pages'><!-- 1 deve essere l'id della pagina child a cui appartengono i paragrafi-->
                      <div id="c_3_p_1">paragraph 1</div>
                      <div id="c_3_p_2">paragraph 2</div>
                      <div id="c_3_p_3">paragraph 3</div>
                    </div>
                  </div>
                  <div id="p_1_c_4">pagina child 4</div>
                </div>
              </div>
              <div id="parent_2" class='container-pages'> <!-- p_1 deve essere l'id della pagina-->
                pagina parent 2
                <div id="child_2" class='container-pages'> <!-- 1 deve essere l'id della pagina-->
                  <div id="p_2_c_5">
                    pagina child 5
                    <div id="paragraph_5" class='container-pages'><!-- 1 deve essere l'id della pagina child a cui appartengono i paragrafi-->
                      <div id="c_5_p_1">paragraph 1</div> <!-- 1 deve essere l'id del paragrafo-->
                      <div id="c_5_p_2">paragraph 2</div>
                      <div id="c_5_p_3">paragraph 3</div>
                    </div>
                  </div>
                  <div id="p_2_c_7">pagina child 7
                    <div id="paragraph_7" class='container-pages'><!-- 1 deve essere l'id della pagina child a cui appartengono i paragrafi-->
                      <div id="c_7_p_1">paragraph 1</div>
                      <div id="c_7_p_2">paragraph 2</div>
                      <div id="c_7_p_3">paragraph 3</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- </div> -->

          </div>
          <!-- <div id='left-events' class='container-pages'>
              <div id="1">
                As soon as you start dragging an element, a <code>drag</code> event is fired
                <div id='center-events' class='container-pages'>
                  <div>
                    <div id='right-events' class='container-pages'>
                      <div>If the element gets removed from the DOM as a result of dropping outside of any containers, a <code>remove</code> event gets fired</div>
                      <div>A <code>cancel</code> event is fired when an element would be dropped onto an invalid target, but retains its original placement instead</div>
                      <div>The <code>over</code> event fires when you drag something over a container, and <code>out</code> fires when you drag it away from the container</div>
                      <div>Lastly, a <code>dragend</code> event is fired whenever a drag operation ends, regardless of whether it ends in a cancellation, removal, or drop</div>
                    </div>
                  </div>
                  <div>A <code>cancel</code> event is fired when an element would be dropped onto an invalid target, but retains its original placement instead</div>
                  <div>The <code>over</code> event fires when you drag something over a container, and <code>out</code> fires when you drag it away from the container</div>
                  <div>Lastly, a <code>dragend</code> event is fired whenever a drag operation ends, regardless of whether it ends in a cancellation, removal, or drop</div>
                </div>
              </div>
              <div id="2">Whenever an element is cloned because <code>copy: true</code>, a <code>cloned</code> event fires</div>
              <div id="3">The <code>shadow</code> event fires whenever the placeholder showing where an element would be dropped is moved to a different container or position</div>
              <div id="4">A <code>drop</code> event is fired whenever an element is dropped anywhere other than its origin <em>(where it was initially dragged from)</em></div>

            </div> -->

        </div>

      </div>
    </div>


    <button id="save">Save</button>

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