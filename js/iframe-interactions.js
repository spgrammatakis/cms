function iframeInit(){
    let iframe = document.getElementById('post-editor-iframe');
    iframe.contentDocument.getElementById('post-body-editor').innerHTML = parent.document.getElementById('post-body').innerHTML; 
    iframe.contentDocument.getElementById('post-title-editor').innerHTML = parent.document.getElementById('post-title').innerHTML; 
    return; 
  }

function copyToHidden () {
    document.getElementById('post-body-textarea').innerHTML = document.getElementById('post-editor-iframe').contentDocument.getElementById("post-body-editor").innerHTML;
    document.getElementById('post-title-textarea').innerHTML = document.getElementById('post-editor-iframe').contentDocument.getElementById("post-title-editor").innerHTML;
    return;
  }