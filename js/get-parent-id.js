function redirectToEditPost(obj) {  
    window.location.href = "./lib/edit-post.php?post_id=" + obj.parentElement.id;
    }

function redirectToEditComment(obj) {  
    window.location.href = "./lib/edit-comment.php?comment_id=" + obj.parentElement.id;
    }    