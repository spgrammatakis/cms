var button = document.getElementsByTagName('button');
for(let i = 0;i<button.length;i++){
    if(button[i].className === "comment-report-button"){
        button[i].addEventListener("click", function(){
        var id =button[i].closest('section').id;
        theUrl = "/lib/comments/report-comment.php?comment_id=" + id;
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
    if(button[i].className === "post-report-button"){
      button[i].addEventListener("click", function(){
      var id =button[i].closest('section').id;
      theUrl = "/lib/posts/report-post.php?post_id=" + id;
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
  if(button[i].className === "user-report-button"){
    button[i].addEventListener("click", function(){
    var id =button[i].closest('section').id;
    theUrl = "/lib/users/report-user.php?user_id=" + id;
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