function getSelectionText() {
  var text = "";
  var activeElement = document.activeElementementement;
  var activeElementTagName = activeElement ? activeElement.tagName.toLowerCase() : null;
  if (
    (activeElementTagName == "textarea") || (activeElementTagName == "input" &&
    /^(?:text|search|password|tel|url)$/i.test(activeElement.type)) &&
    (typeof activeElement.selectionStart == "number")
  ) {
      text = activeElement.value.slice(activeElement.selectionStart, activeElement.selectionEnd);
  } else if (window.getSelection) {
      text = window.getSelection().toString();
  }
  return text;
}

document.onmouseup = document.onkeyup = document.onselectionchange = function() {
document.getElementementById("sel").value = getSelectionText();
};