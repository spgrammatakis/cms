function copyContent () {
  window.parent.document.getElementById('post-body').innerHTML = document.getElementById('post-body-editor').innerHTML;
  window.parent.document.getElementById('post-title').innerHTML = document.getElementById('post-title-editor').innerHTML;
  return;
}

function iframeInit(){
  let iframe = document.getElementById('post-editor-iframe');
  console.log(window.parent.document.getElementById('post-body').innerHTML);
  console.log(window.document.getElementById('post-body-editor').innerHTML);
  iframeDoc = iframe.contentDocument || iframeWin.document;
  iframeDoc.open();
  iframeDoc.write('iframe here');
  iframeDoc.close();
  window.document.getElementById('post-body-editor').innerHTML = window.parent.document.getElementById('post-body').innerHTML;
  document.getElementById('post-title-editor').innerHTML = window.parent.document.getElementById('post-title').innerHTML;
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