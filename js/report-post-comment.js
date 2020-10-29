var button = document.getElementsByTagName('button');
for(let i = 0;i<button.length;i++){
    if(button[i].className === "comment-report-button"){
        button[i].addEventListener("click", function(){
        var id =button[i].parentElement.parentElement.id;
        theUrl = "/lib/comments/comment-report.php?comment_id=" + id;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
         console.log(this.responseText);
          }
        };
        xhttp.open("GET", theUrl, true);
        xhttp.send();
        });
    }
}