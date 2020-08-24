function copyContent () {
  window.parent.document.getElementById('post-body').innerHTML = document.getElementById('post-body-editor').innerHTML;
  window.parent.document.getElementById('post-title').innerHTML = document.getElementById('post-title-editor').innerHTML;
  return;
}

function copyToHidden () {
  window.parent.document.getElementById('post-body-textarea').innerHTML = document.getElementById('post-body-editor').innerHTML;
  window.parent.document.getElementById('post-title-textarea').innerHTML = document.getElementById('post-title-editor').innerHTML;
  return;
}

function iframeInit(){
  //document.getElementById('targetFrame').contentWindow.targetFunction();
  //document.getElementById('post-editor-iframe').contentWindow.targetfunction();
  let iframe = document.getElementById('post-editor-iframe');
  iframe.contentDocument.getElementById('post-body-editor').innerHTML = parent.document.getElementById('post-body').innerHTML; 
  iframe.contentDocument.getElementById('post-title-editor').innerHTML = parent.document.getElementById('post-title').innerHTML; 
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
  if(event.ctrlKey && event.key === 'b'){
    formatBold();
    return;
  }
  return;
});