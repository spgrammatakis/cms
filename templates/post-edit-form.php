<hr style='border: 5px solid red;'>
<h3>Edit your post</h3>
<form method="post">
<p>
        <label for="post-title">Title:</label>
        <input
            type="text"
            id="post-title"
            name="post-title"
            value="<?php echo $pdo->htmlEscape($row['title'])?>"
        >
    </p>
    <p>
        <label for="post-body">
            Website:
        </label>
        <textarea
            id="post-body"
            name="post-body"
            rows="8"
            cols="70"
        ><?php echo $paraText; ?></textarea>
    </p>
    <input type="submit" value="Finish Edit" />
</form>