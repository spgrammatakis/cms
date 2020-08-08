<hr style='border: 5px solid red;'>
<h3>Edit your post</h3>
<form method="post">
<p>
        <label for="post-title">Title:</label>
        <input
            type="text"
            id="post-title"
            name="post-title"
            value="<?php echo $pdo->htmlEscape($commentData['user_name']);?>"
        >
    </p>
    <p>
        <label for="comment-website">
            Website:
        </label>
        <input
            type="text"
            id="comment-website"
            name="comment-website"
            value="<?php echo $pdo->htmlEscape($commentData['website']) ?>"
        />
    </p>
    <p>
        <label for="comment-text">
            Comment:
        </label>
        <textarea
            id="comment-text"
            name="comment-text"
            rows="8"
            cols="70"
        ><?php echo $pdo->htmlEscape($commentData['content']) ?></textarea>
    </p>
    <input type="submit" value="Submit comment" />
</form>