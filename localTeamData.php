<html>
<?php
include("header.php");
include("navBar.php");?>
<body>

<script src="js/jquery.js"></script>
<script src="Orange-Rind/js/orangePersist.js"></script>

<div id="content">
<div class="container row-offcanvas row-offcanvas-left">
<div class="well column  col-lg-112  col-sm-12 col-xs-12" id="content">


<h1>Match Scout Raw Data</h1>

	<div style="border:1px solid black;overflow-y:hidden;overflow-x:scroll;">
		<table  class="sortable table table-hover" id="RawData" border="1">
			
		</table>
	</div>
	
<script>
	$(function(){
		orangePersist.initializeApp();
		var collection = "o";
		var regional = orangePersist.collection(collection);
		var first = true;
		var labels = []
		for(var id in regional.getDocumentKeys()){
			var match = regional.doc(id).get();
			console.log(match);
			if(first){
				var out = "<tr>";
				for(var label in match){
					out += "<th>" + label + "</th>";
					labels.push(label);
				}
				out += "</tr>";
				$("#RawData").append(out);
			}
			var out = "<tr>";
			for(var label in labels){
				out += "<td>" + match[label] + "</td>";
			}
			out += "</tr>";
			$("#RawData").append(out);
		}
		
	});
</script>


</div>
</div>
</div>

</body>
</html>
<?php include("footer.php"); ?>