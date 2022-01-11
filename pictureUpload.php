<html>
<?php include("navBar.php");?>
<?php require("upload.php");?>
<body>
<style>
#overallForm {
		font-size: 15px;
		display: inline-block;
}
</style>
<div class="container row-offcanvas row-offcanvas-left">
	<div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
		<?php
                if($uploadOk == 1){
                    echo "Report submitted. Please do not refresh this page.<br>";
                }
             ?>
			<a><h2>Picture Upload: </h2></a>
            <form action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<b><text class="col-lg-2 control-label" >Team Number: </text></b>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="teamNumber" name="teamNumber" placeholder=" ">
				</div>
			</div>
			<br>
			<div class="col-lg-12 col-sm-12 col-xs-12">
				Select images to upload:
				<input type="file" name="fileToUpload" multiple id="fileToUpload">
				<input id="PitScouting" type="submit" class="btn btn-primary" value="Submit Data" onclick="" >
			</form>
			</div>
	</div>
</div>
<?php include("footer.php"); ?>
