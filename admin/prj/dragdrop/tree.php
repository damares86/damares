
<!DOCTYPE html>
<html>
<head>
	<title>progressCanvas</title>
	<meta charset="utf-8" />
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<link rel="stylesheet" href="../../assets/css/dragula.css"  />
	<style>
		.compList{height:360px;border: 1px solid green;}
		.compType{border:1px solid black;margin:10px;list-style: none;}
		.treeView{
			height: 600px;
			width: 500px;
			border:1px solid blue;
		}
		.droppedComp{background: #fff;padding:5px;margin-top:5px;border:1px solid red;}
		.droppedComp .compType{
			border-style: dotted;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		  <div class="row">
		    <div class="col-md-2" >
		    	<div id="compList" class="compList">
		    		<div class="compType" data-type="block">block</div>
		    		<div class="compType" data-type="each">each</div>
		    		<div class="compType" data-type="if">if</div>
		    		<div class="compType" data-type="image">image</div>
		    	</div>
		    </div>
		    <div class="col-md-10" >
		    	<div class="treeView dropCnt" id="treeView">
		    		
		    	</div>
		    </div>
		</div>
	</div>
	<script src="../../script/dragula.js"></script>
	<script src="./index.js"></script>
</body>
</html>