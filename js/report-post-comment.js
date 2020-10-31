var button = document.getElementsByTagName('button');
for(let i = 0;i<button.length;i++){
    if(button[i].className === "comment-report-button"){
        button[i].addEventListener("click", function(){
        var id =button[i].closest('section').id;
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
      console.log(this.response);
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
        var newDiv = document.createElement("span"); 
        var responseText = "User Reported";
        const newContent = document.createTextNode(responseText); 
        newDiv.appendChild(newContent);
        const currentDiv = document.getElementById('user-report-button').closest('p');
        document.getElementById('user-report-footer').insertBefore(newDiv, currentDiv); 
      }
      if(this.readyState < 4 && this.status == 404){
        var newDiv = document.createElement("span"); 
        var responseText = "User Not Found";
        const newContent = document.createTextNode(responseText); 
        newDiv.appendChild(newContent);
        const currentDiv = document.getElementById('user-report-button').closest('p');
        document.getElementById('user-report-footer').insertBefore(newDiv, currentDiv); 
      }

    };
    xhttp.send();
    });
}  
}