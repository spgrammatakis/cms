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
if(element.value == "Insert Link") formatInsertLink();
return;
}

function formatBold(){
  console.log("Bold");
  var selection = document.getSelection().toString();
  var originalString = document.getElementById("post-body-editor").innerHTML;
  document.getElementById("post-body-editor").focus();
  document.getElementById("post-body-editor").innerHTML = originalString.replace(selection, '<b>'+ selection +'</b>');
  return;
}

function formatItalic(){
  console.log("Italic");
  var selection = document.getSelection().toString();
  var originalString = document.getElementById("post-body-editor").innerHTML;
  document.getElementById("post-body-editor").innerHTML = originalString.replace(selection, "<i>"+ selection +"</i>");
  document.getElementById("post-body-editor").focus();
  return;
}

function formatUnderline(){
  console.log("Underline");
  var selection = document.getSelection().toString();
  var originalString = document.getElementById("post-body-editor").innerHTML;
  document.getElementById("post-body-editor").innerHTML = originalString.replace(selection, "<u>"+ selection +"</u>");
  return;
}
function formatInsertLink(){
  console.log("Insert Link");
  var selection = document.getSelection().toString();
  var originalString = document.getElementById("post-body-editor").innerHTML;
  document.getElementById("post-body-editor").innerHTML = originalString.replace(selection, '<a href="'+ link + '">'+ selection +'</a>');
  return;
}
document.addEventListener('keydown', function(event) {
  if (event.ctrlKey && event.key === 'k') { 
    formatInsertLink();
    return;
  }
  return;
});

function appendnode(){
  let parent = document.getElementById("post-body-editor");
  let b = document.createElement("p");
  parent.append("Some Text", p);
  console.log(parent.textContent);
}