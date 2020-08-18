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
  var activeEl = document.activeElement;
  console.log("Active Element is :" + activeEl);
  console.log("Selection start is :" + activeEl.selectionStart);
  console.log("Selection End is :" + activeEl.selectionEnd);
  var text = activeEl.value.slice(activeEl.selectionStart, activeEl.selectionEnd);
  var activeElTagName = activeEl ? activeEl.tagName.toLowerCase() : null;
  console.log("Text is :" + text);
  return text;
}

document.onmouseup = function() {
  document.getElementById("hiddenTextArea").value = formatBold();
  console.log(document.getElementById("hiddenTextArea").value);
  };

document.onmouseup = function(){
  var sel = document.getSelection().toString();
  var str = document.activeElement.innerHTML; 
  var res = str.replace(sel, "<b>"+sel+"</b>");
  console.log(res);
}
  
function formatItalic(){
  console.log("Italic");
}

function formatUnderline(){
  console.log("Underline");
}