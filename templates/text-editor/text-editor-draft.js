editor.document.designMode = "On";

function transform(option, argument) {
  editor.document.execCommand(option, false, argument);
}