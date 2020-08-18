function getSelectionText() {
  var text = "";
  var activeEl = document.activeElement;
  var activeElTagName = activeEl ? activeEl.tagName.toLowerCase() : null;
  if (
    (activeElTagName == "textarea") || (activeElTagName == "input" &&
    /^(?:text|search|password|tel|url)$/i.test(activeEl.type)) &&
    (typeof activeEl.selectionStart == "number")
  ) {
      text = activeEl.value.slice(activeEl.selectionStart, activeEl.selectionEnd);
  } else if (window.getSelection) {
      text = window.getSelection().toString();
  }
  return text;
}

document.onmouseup = document.onselectionchange = function() {
document.getElementById("sel").value = getSelectionText();
};

function copyContent () {
  document.getElementById("hiddenTextarea").value =  
      document.getElementById("myContentEditable").innerHTML;
  return true;
}

function formatText(element){
console.log(element.value);
}