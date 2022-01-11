var canvas2 = document.getElementById('myCanvas2');
var context2 = canvas2.getContext('2d');
var drawLine2 = false;
var oldCoor2 = {};
var i2 = 1;
var t2;
var coordinateList2 = [];
var tempCoordinateList2 = [];
var lastCoordinate2 = {};

var imageObj2 = new Image();
  imageObj2.onload = function() {
  context2.drawImage(imageObj2, 0, 0, 600, 300);
  };
  imageObj2.src = 'images/field.png';

$(document).ready(function(){
  orangePersist.initializeApp();
  console.log("GETTING USERNAME");
  $("#userName").val(localStorage.getItem("userName"));
});

function saveUserName2(){
  console.log("SETTING USERNAME");
  localStorage.setItem("userName", $("#userName").val());
}

function clearPath2(){
  context2.clearRect(0, 0, 600, 300);
  context2.drawImage(imageObj2, 0, 0, 600, 300);
  coordinateList2.splice(-1,1);
}

function clearPath3(){
  context2.clearRect(0, 0, 600, 300);
  context2.drawImage(imageObj2, 0, 0, 600, 300);
  tempCoordinateList2 = [];
}


function addCoordinate2(){
  coordinateList2.push(tempCoordinateList2[0]);
  tempCoordinateList2 = [];
}


function addTempCoordinate2(coor2){
  tempCoordinateList2.push(coor2);
}

function updateRobotHTML(){

}

function randomColor2(){
  var choices = "0123456789abcdef";
  var out = "#";
  for(var i = 0; i < 6; i++){
    out += choices[Math.floor(Math.random() * 16)];
  }
  return(out);
}

function adjustCanvas2(){
  $("#canvasHolder").css('height' , $(window).height()-25);
  $("#canvasHolder").css('height' , $(window).height()-25);
  $("#main").attr('width' , $("#canvasHolder").width());
  $("#main").attr('height' , $("#canvasHolder").height());
}

function resize2(){
  //$("#main").outerHeight($(window).height()-$("#main").offset().top- Math.abs($("#main").outerHeight(true) - $("#main").outerHeight()));
  //$("#main").outerHeight(100*i);
  //$("#main").outerWidth(100*i);
  canvas2.width = $(window).width() - 35;
  canvas2.height = $(window).height() - 25;
}

//$(document).ready(function(){
  $.material.init()
  //resize();
  adjustCanvas2();
  $(window).on("resize", function(){
    //resize();
    adjustCanvas2();
  });
  context2.stroke();
  //$("#main")[0].webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT); //Chrome
  //$("#main")[0].mozRequestFullScreen(); //Firefox
  //canvas2.addEventListener('touchmove', movePath2, false);
  //canvas2.addEventListener('touchstart', startPoint2, false);
  //canvas2.addEventListener('touchend', endPoint2, false);

  //canvas2.addEventListener('mousemove', movePath2, false);
  canvas2.addEventListener('mousedown', startPoint2, false);
  canvas2.addEventListener('mouseup', endPoint2, false);
//});

function getMousePos2(canvas2, evt2) {
  var rect = canvas2.getBoundingClientRect();
  var evtType = evt2.constructor.name;
  if(evtType == "TouchEvent"){
    return {
      x: evt2.touches[0].clientX - rect.left,
      y: evt2.touches[0].clientY - rect.top
      };
  }
  else if(evtType = "MouseEvent"){
    return {
      x: evt2.clientX - rect.left,
      y: evt2.clientY - rect.top
      };
  }
  else{
    alert("Input type not supported!")
  }
}

function drawPoint2(context2 , x, y){
  clearPath3();
  context2.fillRect(x,y,5,5);
  context2.fillStyle = "#FFFFFF";
  context2.fill();
  addTempCoordinate2([x,y]);
}

function drawPointLines2(context2 , point2){
  var color = "#FFFFFF";
  if(lastCoordinate2.length == 0){
    lastCoordinate2 = point2;
  }
  else{
    context2.beginPath();
    context2.strokeStyle = color;
    context2.moveTo(lastCoordinate2[0] , lastCoordinate2[1]);
    context2.lineTo(point2[0] , point2[1]);
    addCoordinate2(point2);
    lastCoordinate2 = point2;
    context2.stroke();
  }
}


function movePath2(evt2){
  t2 = evt2;
  if(drawLine2){
    var mousePos2 = getMousePos2(canvas2, evt2);
    var message = mousePos2.x + ' , ' + mousePos2.y;
  //drawPoint(context , mousePos.x , mousePos.y);
    drawPoint2(context2 , mousePos2.x , mousePos2.y);
    console.log(message);
  }
    evt2.preventDefault();
    return false;
}

function startPoint2(evt2){
  var mousePos2 = getMousePos2(canvas2, evt2);
    var message = mousePos2.x + ' , ' + mousePos2.y;
  //drawPoint(context , mousePos.x , mousePos.y);
    drawPoint2(context2 , mousePos2.x , mousePos2.y);
    console.log(message);
  console.log("A");
  drawLine2 = true;
  evt2.preventDefault();
  return false;
}

function endPoint2(evt2){
  console.log("B");
  drawLine2 = false;
  evt2.preventDefault();
  return false;
}
