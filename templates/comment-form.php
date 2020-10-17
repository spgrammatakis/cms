<hr>
<h3>Add your comment</h3>
<form method="post">
<p>
        <label for="comment-name">Name:</label>
        <input
            type="text"
            id="comment-name"
            name="comment-name"
            value="<?php echo lib\Utilities::htmlEscape($commentData['user_name']);?>"
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
            value="<?php echo lib\Utilities::htmlEscape($commentData['website']) ?>"
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
        ><?php echo lib\Utilities::htmlEscape($commentData['content']) ?></textarea>
    </p>
    <input type="submit" value="Submit comment" />
</form>