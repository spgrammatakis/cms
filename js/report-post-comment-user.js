var button = document.getElementsByTagName('button');
for(let i = 0;i<button.length;i++){
    if(button[i].className === "comment-report-button"){
        button[i].addEventListener("click", function(){
        let id = button[i].closest('section').id;
        let xsrfToken = button[i].closest('section').dataset.xsrf;
        let theUrl = "/lib/comments/report-comment.php?comment_id=" + id +"&xsrf=" + xsrfToken;
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", theUrl, true);
        xhttp.send();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            let reponseDiv = document.createElement("span");
            let responseText = "Comment Reported";
            let childToAppend = document.createTextNode(responseText); 
            reponseDiv.appendChild(childToAppend);
            for(let i = 0;i<document.getElementsByClassName('comment-report-button').length;i++){
              let currentDiv = document.getElementsByClassName('comment-report-button')[i].closest('p');
              currentDiv.parentElement.insertBefore(reponseDiv, currentDiv);
            }
  
          }
          if(this.readyState < 4 && this.status == 404){
            let reponseDiv = document.createElement("span");
            let responseText = "Post Not Found";
            let childToAppend = document.createTextNode(responseText); 
            reponseDiv.appendChild(childToAppend);
            for(let i = 0;i<document.getElementsByClassName('comment-report-button').length;i++){
              let currentDiv = document.getElementsByClassName('comment-report-button')[i].closest('p');
              currentDiv.parentElement.insertBefore(reponseDiv, currentDiv);
            }
          }
        };
        });
    }

    if(button[i].className === "post-report-button"){
      button[i].addEventListener("click", function(){
      let id = button[i].closest('section').id;
      let xsrfToken = button[i].closest('section').dataset.xsrf;
      let theUrl = "/lib/posts/report-post.php?post_id=" + id +"&xsrf=" + xsrfToken;
      let xhttp = new XMLHttpRequest();
      xhttp.open("GET", theUrl, true);
      xhttp.send();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          let reponseDiv = document.createElement("span");
          let responseText = "Post Reported";
          let childToAppend = document.createTextNode(responseText); 
          reponseDiv.appendChild(childToAppend);
          for(let i = 0;i<document.getElementsByClassName('post-report-button').length;i++){
            let currentDiv = document.getElementsByClassName('post-report-button')[i].closest('p');
            currentDiv.parentElement.insertBefore(reponseDiv, currentDiv);
          }

        }
        if(this.readyState < 4 && this.status == 404){
          let reponseDiv = document.createElement("span");
          let responseText = "Post Not Found";
          let childToAppend = document.createTextNode(responseText); 
          reponseDiv.appendChild(childToAppend);
          for(let i = 0;i<document.getElementsByClassName('post-report-button').length;i++){
            let currentDiv = document.getElementsByClassName('post-report-button')[i].closest('p');
            currentDiv.parentElement.insertBefore(reponseDiv, currentDiv);
          }
        }
      };
      });
  }

  if(button[i].className === "user-report-button"){
    button[i].addEventListener("click", function(){
    let id =button[i].closest('footer').id;
    let xsrfToken = button[i].closest('footer').dataset.xsrf;
    let theUrl = "/lib/users/report-user.php?user_id=" + id +"&xsrf=" + xsrfToken;
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", theUrl, true);
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        let reponseDiv = document.createElement("span");
        let responseText = "User Reported";
        let childToAppend = document.createTextNode(responseText); 
        reponseDiv.appendChild(childToAppend);
        for(let i = 0;i<document.getElementsByClassName('user-report-button').length;i++){
          let currentDiv = document.getElementsByClassName('user-report-button')[i].closest('p');
          currentDiv.parentElement.insertBefore(reponseDiv, currentDiv);
        }

      }
      if(this.readyState < 4 && this.status == 404){
        let reponseDiv = document.createElement("span");
        let responseText = "User Not Found";
        let childToAppend = document.createTextNode(responseText); 
        reponseDiv.appendChild(childToAppend);
        for(let i = 0;i<document.getElementsByClassName('user-report-button').length;i++){
          let currentDiv = document.getElementsByClassName('user-report-button')[i].closest('p');
          currentDiv.parentElement.insertBefore(reponseDiv, currentDiv);
        }
      }
    };
    xhttp.send();
    });
}  
}