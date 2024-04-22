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
            <div id='left-events' class='container-pages'>
              <div id="1">As soon as you start dragging an element, a <code>drag</code> event is fired</div>
              <div id="2">Whenever an element is cloned because <code>copy: true</code>, a <code>cloned</code> event fires</div>
              <div id="3">The <code>shadow</code> event fires whenever the placeholder showing where an element would be dropped is moved to a different container or position</div>
              <div id="4">A <code>drop</code> event is fired whenever an element is dropped anywhere other than its origin <em>(where it was initially dragged from)</em></div>
            </div>
            <div id='right-events' class='container-pages'>
              <div>If the element gets removed from the DOM as a result of dropping outside of any containers, a <code>remove</code> event gets fired</div>
              <div>A <code>cancel</code> event is fired when an element would be dropped onto an invalid target, but retains its original placement instead</div>
              <div>The <code>over</code> event fires when you drag something over a container, and <code>out</code> fires when you drag it away from the container</div>
              <div>Lastly, a <code>dragend</code> event is fired whenever a drag operation ends, regardless of whether it ends in a cancellation, removal, or drop</div>
            </div>
          </div>

        </div>
      </div>


      <button id="save">Save</button>

    </div>
  </div>
</section>


<script src='script/dragula.js'></script>
<script src='script/example.min.js'></script>

<script>
        $("#save").click(function() {
            const data = $('#left-events > div').map(function(index,el) {
                return el.id
            }).get()

            console.log(data)
            })
    </script>