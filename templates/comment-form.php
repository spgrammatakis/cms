<form method="post" id="comment-form">
    <section>
        <label for="comment-text">
            Comment:
        </label>
        <textarea
            id="comment-text"
            name="comment-text"
            rows="8"
            cols="70"
        ></textarea>
    </section>
    <input type="submit" value="Submit comment" />
    <section>
        <input type='hidden' name='xsrf' value="<?php echo hash_hmac('sha256', __FILE__, $session->getUserID($username));?>"/>
    </section>
</form>