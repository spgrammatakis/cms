function redirectToEditPost(id) {  
    window.location.href = "./lib/edit-post.php?post_id=" + id;
    }

function redirectToEditComment(id) {  
    window.location.href = "./lib/edit-comment.php?comment_id=" + id;
    }

    var button = document.getElementsByTagName('button');
        for(let i = 0;i<button.length;i++){
            if(button[i].className === "post-button"){
                button[i].addEventListener("click", function(){
                    redirectToEditPost(button[i].parentElement.id);
                });
            }
            if(button[i].className === "comment-button"){
                button[i].addEventListener("click", function(){
                    redirectToEditComment(button[i].parentElement.id);
                });
                button[i].addEventListener("click", function(){
                    redirectToEditComment(button[i].parentElement.id);
                });
            }
        }