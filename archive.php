
<!--

                    <div class="col-md-7">
						<a>
							<h3><b><u>Auto Path:</u></b></h3>
						</a>
                        <div>
							<canvas id="myCanvas" width="600" height="460" style="border:1px solid #d3d3d3;"></canvas>
							<script type="text/javascript">
								var canvas = document.getElementById('myCanvas');
								var context = canvas.getContext('2d');
								var drawLine = false;
								var oldCoor = {};
								var i = 1;
								var t;
								var coordinateList = [];
								var lastCoordinate = {};
								var imageObj = new Image();
								var matchToPoints = [];
                                var matchToPoints4 = [];
                                var matchToPoints5 = [];
								var matchToPoints6 = [];
								var matchToPoints7 = [];
                                var matchToPoints8 = [];
								var matchToPoints9 = [];
								<?php
								/*
									for ($i = 0; $i != sizeof($teamData[8]); $i++) {
										echo ("matchToPoints[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][5] . ";");
									}
									for ($i = 0; $i != sizeof($teamData[8]); $i++) {
										echo ("matchToPoints4[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][7] . ";");
									}
									for ($i = 0; $i != sizeof($teamData[8]); $i++) {
										echo ("matchToPoints6[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][9] . ";");
									}
									for ($i = 0; $i != sizeof($teamData[8]); $i++) {
										echo ("matchToPoints5[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][8] . ";");
									}
									for ($i = 0; $i != sizeof($teamData[8]); $i++) {
										echo ("matchToPoints7[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][11] . ";");
									}
									for ($i = 0; $i != sizeof($teamData[8]); $i++) {
										echo ("matchToPoints8[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][12] . ";");
									}
									for ($i = 0; $i != sizeof($teamData[8]); $i++) {
										echo ("matchToPoints9[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][13] . ";");
									}
								*/
								?>
								imageObj.onload = function() {
									makeCanvasReady();
									var ctx = document.getElementById("dataChart").getContext("2d");
									window.myLine = new Chart(ctx).Line(lineChartData, {
										responsive: true
									});
								};
								imageObj.src = 'images/RedField.png';

								function makeCanvasReady() {
									context.clearRect(0, 0, 600, 460);
									context.drawImage(imageObj, 0, 0, 600, 460);
								}

								function adjustCanvas() {
									$("#canvasHolder").css('height', $(window).height() - 25);
									$("#canvasHolder").css('height', $(window).height() - 25);
									$("#main").attr('width', $("#canvasHolder").width());
									$("#main").attr('height', $("#canvasHolder").height());
								}

								function drawPoint(context, x, y) {
									context.fillRect(x, y, 1, 1);
								}

								function drawPointLines() {
									makeCanvasReady();
									var matchNumber = document.getElementById("matchNum").value;
									var a = matchToPoints[matchNumber];
									var color = "#FFFFFF";
									context.beginPath();
									context.strokeStyle = color;

									for (var i = 0; i != a.length; i++) {
										if (i == 0) {
											context.moveTo((a[i][0]), (a[i][1]));
										} else {
											context.lineTo((a[i][0]), (a[i][1]));
										}
									}
									context.stroke();
								}

								function drawPointLines3() {
									makeCanvasReady();
									var k = 0;
									for (var j = 0; j != 200; j++){
										var a = matchToPoints[j];
										
										if (k==1){
											var color = "#512E5F";
										}
										if (k==2){
											var color = "#AF7AC5";
										}
										if (k==3){
											var color = "#154360";
										}
										if (k==4){
											var color = "#3498DB";
										}
										if (k==5){
											var color = "#0E6251";
										}
										if (k==6){
											var color = "#1ABC9C";
										}
										if (k==7){
											var color = "#7D6608";
										}
										if (k==8){
											var color = "#F1C40F";
										}
										if (k==9){
											var color = "#F39C12";
										}
										if (k==10){
											var color = "#D35400";
										}
										if (k==11){
											var color = "#CACFD2";
										}
										if (k==12){
											var color = "#99A3A4";
										}
										if (k == 13){
											var color = "#E74C3C";
										}
										context.beginPath();
										context.strokeStyle = color;
										if (a != null){
											for (var i = 0; i != a.length; i++) {
												if (i == 0) {
													context.moveTo((a[i][0]), (a[i][1]));
												} else {
													context.lineTo((a[i][0]), (a[i][1]));
												}
											}
											context.stroke();
											k++;
										}else{
											console.log("fail");
										}
									}
								}

                                function printAuto() {
                                    var matchNumber = document.getElementById("matchNum").value;
                                    var b = matchToPoints4[matchNumber];
                                    var c = matchToPoints5[matchNumber];
									var d = matchToPoints6[matchNumber];
									if (b != null){
										console.log("Auto Upper Made: " + b + ", Auto Upper Miss: " + c + ", Auto Lower Goal: " + d);
										document.getElementById('auto').innerHTML = "Auto Upper Made: " + b;
										document.getElementById('auto2').innerHTML = "Auto Upper Miss: " + c;
										document.getElementById('auto3').innerHTML = "Auto Lower Made: " + d;
									}
                                }

                                function printAuto1() {
									document.getElementById('auto').innerHTML = "";
									document.getElementById('auto2').innerHTML = "";
									document.getElementById('auto3').innerHTML = "";
                                }

							</script>
							<h4><b>Match Number </b></h4>
							<div class="col-md-7">
								<select onclick="drawPointLines(); printAuto();" id="matchNum" class="form-control">
									<?php 
									/*
										for ($i = 0; $i != sizeof($teamData[8]); $i++) {
											echo ("<option value='" . $teamData[8][$i][2] . "'>" . $teamData[8][$i][2] . "</option>");
										} 
*/
									?>
								</select>
							</div>
							<div class="col-md-5">
								<div>
									<button type="button" onClick="drawPointLines3(); printAuto1()" class=" btn btn-material-orange" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> Show All </button>
								</div>
								<div>
									<span id='auto'></span>
								</div>
								<div>
									<span id='auto2'></span>
								</div>
								<div>
									<span id='auto3'></span>
								</div>
							</div>
						</div>






						<div class="col-md-7">
                        <a>
							<h3><b><u>Teleop Shooting:</u></b></h3>
						</a>
						</div>
						<div>
							<canvas id="myCanvas2" width="600" height="300" style="border:1px solid #d3d3d3;"></canvas>
							<script type="text/javascript">
								var canvas2 = document.getElementById('myCanvas2');
								var context2 = canvas2.getContext('2d');
								var drawLine2 = false;
								var oldCoor2 = {};
								var i = 1;
								var t;
								var coordinateList2 = [];
								var lastCoordinate2 = {};
								var imageObj2 = new Image();
								var matchToPoints2 = [];
								var matchToPoints3 = [];
                                var dataList = [];
								<?php
/*
								
									for ($i = 0; $i != sizeof($teamData[8]); $i++) {
										echo ("matchToPoints2[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][25] . ";");
									}
									for ($i = 0; $i != sizeof($teamData[8]); $i++) {
										echo ("matchToPoints3[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][24] . ";");
									}

								*/
								?>
								<?php
								/*
								
									for ($i = 0; $i != sizeof($teamData[8]); $i++) {
										$a += ('' . $teamData[8][$i][2] . ',');
									}
									$a = substr($a, 0, -2);
									*/
								?>
								imageObj2.onload = function() {
									makeCanvasReady2();
									var ctx2 = document.getElementById("dataChart").getContext("2d");
									window.myLine = new Chart(ctx2).Line(lineChartData, {
										responsive: true
									});
								};
								imageObj2.src = 'images/field.png';

								function makeCanvasReady2() {
									context2.clearRect(0, 0, 600, 300);
									context2.drawImage(imageObj2, 0, 0, 600, 300);
									console.log("hi");
								}

								function adjustCanvas() {
									$("#canvasHolder").css('height', $(window).height() - 25);
									$("#canvasHolder").css('height', $(window).height() - 25);
									$("#main").attr('width', $("#canvasHolder").width());
									$("#main").attr('height', $("#canvasHolder").height());
								}

								function drawPoint2() {
                                    makeCanvasReady2();
									var matchNumber2 = document.getElementById("matchNum2").value;
									var a = matchToPoints2[matchNumber2];
									var b = matchToPoints3[matchNumber2];
									for (var i = 0; i != a.length; i++) {
										if (((b[i][1]/(b[i][2]+b[i][1])) == 1)){
											context2.fillStyle = "#059400";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
											console.log(b[i][1]);
										}else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.7)){
											context2.fillStyle = "#d0ff00";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
										} else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.5)){
											context2.fillStyle = "#ffd900";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
										} else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.3)){
											context2.fillStyle = "#ff8c00";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
										} else if ((b[i][2]) == 0){
											context2.fillStyle = "#000000";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
										}else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.1)){
											context2.fillStyle = "#ff0088";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
                                        }else{
											context2.fillStyle = "#940000";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
										}
									}
								}

								function drawPoint3() {
                                    makeCanvasReady2();
									for (var j = 0; j != 200; j++){
										var a = matchToPoints2[j];
										var b = matchToPoints3[j];
										if (a != null){
											for (var i = 0; i != a.length; i++) {
												if (((b[i][1]/(b[i][2]+b[i][1])) == 1)){
													context2.fillStyle = "#059400";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												} else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.7)){
													context2.fillStyle = "#d0ff00";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												} else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.5)){
													context2.fillStyle = "#ffd900";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												} else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.3)){
													context2.fillStyle = "#ff8c00";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												} else if ((b[i][2]) == 0){
													context2.fillStyle = "#000000";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												}else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.1)){
													context2.fillStyle = "#ff0088";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												}else{
													context2.fillStyle = "#940000";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												}
											}
										} else {
											continue;
											console.log("fail");
										}
									}
								}

								function printTeleop() {
                                    var matchNumber = document.getElementById("matchNum").value;
                                    var b = matchToPoints7[matchNumber];
                                    var c = matchToPoints8[matchNumber];
									var d = matchToPoints9[matchNumber];
									if (b != null){
										console.log("Teleop Upper Made: " + b + ", Teleop Upper Miss: " + c + ", Teleop Lower Goal: " + d);
										document.getElementById('teleop').innerHTML = "Teleop Upper Made: " + b;
										document.getElementById('teleop2').innerHTML = "Teleop Upper Miss: " + c;
										document.getElementById('teleop3').innerHTML = "Teleop Lower Made: " + d;
									}
                                }

                                function printTeleop1() {
									document.getElementById('teleop').innerHTML = "";
									document.getElementById('teleop2').innerHTML = "";
									document.getElementById('teleop3').innerHTML = "";
                                }

							</script>
                            
							<h4><b>Match Number -</b></h4>
							</div>
								<div class="col-md-7">
									<select onclick="drawPoint2(); printTeleop();" id="matchNum2" class="form-control">
										<?php 
										/*
										for ($i = 0; $i != sizeof($teamData[8]); $i++) {
											echo ("<option value='" . $teamData[8][$i][2] . "'>" . $teamData[8][$i][2] . "</option>");

										} 
										*/
										?>
									</select>
								</div>
								<div class="col-md-5">
									<div>
										<button type="button" onClick="drawPoint3(); printTeleop1();" class=" btn btn-material-orange" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> Show All </button>
									</div>
									<div>
										<span id='teleop'></span>
									</div>
									<div>
										<span id='teleop2'></span>
									</div>
									<div>
										<span id='teleop3'></span>
									</div>
								</div>
							</div>
									

							<div>

								<button type="button" onClick="" class="enlargedtext stylishLower8" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 100 Percent </button>
								<button type="button" onClick="" class="enlargedtext stylishLower2" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 70 Percent </button>
								<button type="button" onClick="" class="enlargedtext stylishLower3" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 50 Percent </button>
								<button type="button" onClick="" class="enlargedtext stylishLower4" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 30 Percent </button>
								<button type="button" onClick="" class="enlargedtext stylishLower5" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 10 Percent </button>
								<button type="button" onClick="" class="enlargedtext stylishLower6" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 0 Percent </button>
								<button type="button" onClick="" class="enlargedtext stylishLower7" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> Lower Only </button>
							</div>
						</div>
-->