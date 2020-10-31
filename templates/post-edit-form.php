<h1>Edit Post</h1>
<form method="post" id="post-edit">
<p>
        <label for="post-title">Name:</label>
        <input
            type="text"
            id="post-title"
            name="post-title"
            value="<?php echo lib\Utilities::htmlEscape($row[0]['title']);?>"
        >
    </p>
    <p>
        <label for="post-body">
            Body:
        </label>
        <textarea
            type="text"
            id="post-body"
            name="post-body-textarea"
            rows="8"
            cols="70"
            value="<?php echo lib\Utilities::htmlEscape($row[0]['body']); ?>"
        >
        </textarea>
    </p>
    <input type="submit" value="Finish Edit" />
</form>