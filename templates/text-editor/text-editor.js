function copyContent () {
  return;
}

let selection;

document.onmouseup= function() {
    var el = document.getElementById("post-body-editor")
    var range = document.createRange()
    var sel = window.getSelection()
    
    range.setStart(el.childNodes[0], 5)
    range.collapse(true)
    
    sel.removeAllRanges()
    sel.addRange(range)
};

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
  if(event.ctrlKey && event.key === 'b'){
    formatBold();
    return;
  }
  return;
});