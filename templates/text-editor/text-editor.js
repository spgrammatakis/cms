function copyContent () {
  document.getElementById("post-body").value =  
      document.getElementById("post-body-editor").innerHTML;
      console.log(document.getElementById("post-body").value);
  return true;
}

function formatText(element){
if(element.value == "Bold") formatBold();
if(element.value == "Italic") formatItalic();
if(element.value == "Underline") formatUnderline();
return;
}

function formatBold(){
  console.log("Bold");
  var selection = document.getSelection().toString();
  var originalString = document.getElementById("post-body-editor").innerHTML;
  document.getElementById("post-body-editor").innerHTML = originalString.replace(selection, '<b>'+ selection +'</b>');
  return;
}

function formatItalic(){
  console.log("Italic");
  var selection = document.getSelection().toString();
  var originalString = document.getElementById("post-body-editor").innerHTML;
  document.getElementById("post-body-editor").innerHTML = originalString.replace(selection, "<i>"+ selection +"</i>");
  return;
}

function formatUnderline(){
  console.log("Underline");
  var selection = document.getSelection().toString();
  var originalString = document.getElementById("post-body-editor").innerHTML;
  document.getElementById("post-body-editor").innerHTML = originalString.replace(selection, "<u>"+ selection +"</u>");
  return;
}
var state;
document.addEventListener('keydown', function(event) {
  if (event.ctrlKey && event.key === 'i') { 
    console.log(state);   
    if(!Boolean(state)){
    console.log("axne");
    var selection = document.getSelection().toString();
    var originalString = document.getElementById("post-body-editor").innerHTML;
    document.getElementById("post-body-editor").innerHTML = originalString.replace(selection, "<i>"+ selection +"</i>");
    state = 1;
    }else{
    
    state = 0;
    }

  }
  return;
});