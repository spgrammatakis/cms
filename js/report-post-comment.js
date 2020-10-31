var button = document.getElementsByTagName('button');
const reponseDiv = document.createElement("span");
for(let i = 0;i<button.length;i++){
    if(button[i].className === "comment-report-button"){
        button[i].addEventListener("click", function(){
        var id = button[i].closest('section').id;
        theUrl = "/lib/comments/report-comment.php?comment_id=" + id;
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", theUrl, true);
        xhttp.send();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
         console.log(this.response);
          }
        };
        });
    }
    if(button[i].className === "post-report-button"){
      button[i].addEventListener("click", function(){
      var id =button[i].closest('section').id;
      theUrl = "/lib/posts/report-post.php?post_id=" + id;
      var xhttp = new XMLHttpRequest();
      xhttp.open("GET", theUrl, true);
      xhttp.send();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
       console.log(this.response);
        }
      };
      });
  }
  if(button[i].id === "user-report-button"){
    button[i].addEventListener("click", function(){
    const id =button[i].closest('section').id;
    var theUrl = "/lib/users/report-user.php?user_id=" + id;
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", theUrl, true);
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) { 
        var responseText = "User Reported";
        var childToAppend = document.createTextNode(responseText); 
        reponseDiv.appendChild(childToAppend);
        var currentDiv = document.getElementById('user-report-button').closest('p');
        document.getElementById('user-report-footer').insertBefore(reponseDiv, currentDiv);

      }
      if(this.readyState < 4 && this.status == 404){
        var responseText = "User Not Found";
        var childToAppend = document.createTextNode(responseText); 
        reponseDiv.appendChild(childToAppend);
        var currentDiv = document.getElementById('user-report-button').closest('p');
        document.getElementById('user-report-footer').insertBefore(reponseDiv, currentDiv);
      }
    };
    xhttp.send();
    });
}  
}