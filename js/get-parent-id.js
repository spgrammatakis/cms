function redirectToEditPost(obj) {  
    window.location.href = "./lib/edit_post.php?post_id=" + obj.parentElement.id;
    }

function redirectToEditComment(obj) {  
    window.location.href = "./lib/edit_comment.php?comment_id=" + obj.parentElement.id;
    }    