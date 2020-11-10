<h3>Edit Post</h3>
<form method="post" id="post-edit">
<section class="post-title">
        <label for="post-title">Title:</label>
        <input
            type="text"
            id="post-title"
            name="post-title"
            value="<?php echo lib\Utilities::htmlEscape($row['title']);?>"
        >
</section>
<section class="post-body">
        <label for="post-body">
            Body:
        </label>
        <textarea
            type="text"
            id="post-body"
            name="post-body-textarea"
            rows="8"
            cols="70"
        ><?php echo lib\Utilities::htmlEscape($row['body']); ?></textarea>
</section>
<section class="submit">
    <input type="submit" value="Finish Edit" />
</section>
<section>
    <input type='hidden' name='xsrf' value="<?php echo hash_hmac('sha256', __FILE__, $session->getUserID($username));?>"/>
</section>
</form>