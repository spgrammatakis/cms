function copyContent () {
  document.getElementById("hiddenTextArea").value =  
      document.getElementById("myContentEditable").innerHTML;
  return true;
}

function formatText(element){
if(element.value == "Bold") formatBold();
if(element.value == "Italic") formatItalic();
if(element.value == "Underline") formatUnderline();
}

function formatBold(){
  console.log("Bold");
  var selection = document.getSelection().toString();
  var originalString = document.getElementById("post-body-editor").innerHTML;
  document.getElementById("post-body-editor").innerHTML = originalString.replace(selection, "<b>"+ selection +"</b>");
}

function formatItalic(){
  console.log("Italic");
  var selection = document.getSelection().toString();
  var originalString = document.getElementById("post-body-editor").innerHTML;
  document.getElementById("post-body-editor").innerHTML = originalString.replace(selection, "<i>"+ selection +"</i>");
}

function formatUnderline(){
  console.log("Underline");
  var selection = document.getSelection().toString();
  var originalString = document.getElementById("post-body-editor").innerHTML;
  document.getElementById("post-body-editor").innerHTML = originalString.replace(selection, "<u>"+ selection +"</u>");
}