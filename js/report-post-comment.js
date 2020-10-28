var button = document.getElementsByTagName('button');
for(let i = 0;i<button.length;i++){
    if(button[i].className === "post-button"){
        button[i].addEventListener("click", function(){
            redirectToEditPost(button[i].parentElement.id);
        });
    }
    if(button[i].className === "comment-report-button"){
        button[i].addEventListener("click", function(){
            reportComment(button[i].parentElement.parentElement.id);
        });
    }
}

function reportPost(id) {  
    window.location.href = "/lib/posts/edit-post.php?post_id=" + id;
    }

function reportComment(id) {  
    window.location.href = "/lib/comments/comment-report.php?comment_id=" + id;
    }