// var instruction = document.getElementById("instruction");
var register = document.getElementById("register");
var record = document.getElementById("record");
// var report = document.getElementById("report");
var name = document.getElementById("name");

function registeR(event) {
  event.preventDefault();
  // instruction.style.display = "none";
  register.style.display = "block";
  record.style.display = "none";
  // report.style.display = "none";
  return false;
}

function recorD(event) {
  event.preventDefault();
  // instruction.style.display = "none";
  register.style.display = "none";
  record.style.display = "block";
  // report.style.display = "none";
  return false;
}
