var canvas = document.getElementById('myCanvas');
var context = canvas.getContext('2d');
var drawLine = false;
var oldCoor = {};
var i = 1;
var t;
var coordinateList = [];
var lastCoordinate = {};

var imageObj = new Image();
  imageObj.onload = function() {
  context.drawImage(imageObj, 0, 0, 600, 460);
  };
  imageObj.src = 'images/RedField.png';

$(document).ready(function(){
  orangePersist.initializeApp();
  console.log("GETTING USERNAME");
  $("#userName").val(localStorage.getItem("userName"));
});

function saveUserName(){
  console.log("SETTING USERNAME");
  localStorage.setItem("userName", $("#userName").val());
}

function clearPath(){
  context.clearRect(0, 0, 600, 460);
  context.drawImage(imageObj, 0, 0, 600, 460);
  coordinateList = [];
  lastCoordinate = {};
}


function addCoordinate(coor){
  coordinateList.push(coor);
}

function updateRobotHTML(){

}

function randomColor(){
  var choices = "0123456789abcdef";
  var out = "#";
  for(var i = 0; i < 6; i++){
    out += choices[Math.floor(Math.random() * 16)];
  }
  return(out);
}

function adjustCanvas(){
  $("#canvasHolder").css('height' , $(window).height()-25);
  $("#canvasHolder").css('height' , $(window).height()-25);
  $("#main").attr('width' , $("#canvasHolder").width());
  $("#main").attr('height' , $("#canvasHolder").height());
}

function resize(){
  //$("#main").outerHeight($(window).height()-$("#main").offset().top- Math.abs($("#main").outerHeight(true) - $("#main").outerHeight()));
  //$("#main").outerHeight(100*i);
  //$("#main").outerWidth(100*i);
  canvas.width = $(window).width() - 35;
  canvas.height = $(window).height() - 25;
}

//$(document).ready(function(){
  $.material.init()
  //resize();
  adjustCanvas();
  $(window).on("resize", function(){
    //resize();
    adjustCanvas();
  });
  context.stroke();
  //$("#main")[0].webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT); //Chrome
  //$("#main")[0].mozRequestFullScreen(); //Firefox
  canvas.addEventListener('touchmove', movePath, false);
  canvas.addEventListener('touchstart', startPoint, false);
  canvas.addEventListener('touchend', endPoint, false);

  canvas.addEventListener('mousemove', movePath, false);
  canvas.addEventListener('mousedown', startPoint, false);
  canvas.addEventListener('mouseup', endPoint, false);
//});

function getMousePos(canvas, evt) {
  var rect = canvas.getBoundingClientRect();
  var evtType = evt.constructor.name;
  if(evtType == "TouchEvent"){
    return {
      x: evt.touches[0].clientX - rect.left,
      y: evt.touches[0].clientY - rect.top
      };
  }
  else if(evtType = "MouseEvent"){
    return {
      x: evt.clientX - rect.left,
      y: evt.clientY - rect.top
      };
  }
  else{
    alert("Input type not supported!")
  }
}

function drawPoint(context , x , y){
  context.fillRect(x,y);
}

function drawPointLines(context , point){
  var color = "#FFFFFF";
  if(lastCoordinate.length == 0){
    lastCoordinate = point;
  }
  else{
    context.beginPath();
    context.strokeStyle = color;
    context.moveTo(lastCoordinate[0] , lastCoordinate[1]);
    context.lineTo(point[0] , point[1]);
    addCoordinate(point);
    lastCoordinate = point;
    context.stroke();
  }
}

function movePath(evt){
  t = evt;
  if(drawLine){
    var mousePos = getMousePos(canvas, evt);
    var message = mousePos.x + ' , ' + mousePos.y;
    //drawPoint(context , mousePos.x , mousePos.y);
    drawPointLines(context , [mousePos.x , mousePos.y]);
    console.log(message);
  }
    evt.preventDefault();
    return false;
}

function startPoint(evt){
  console.log("A");
  drawLine = true;
  evt.preventDefault();
  return false;
}

function endPoint(evt){
  console.log("B");
  drawLine = false;
  evt.preventDefault();
  return false;
}
