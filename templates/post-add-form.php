<form method="post" id="post-edit">
<section class= "post-title">
        <label for="post-title">Title:</label>
        <input
            type="text"
            id="post-title"
            name="post-title"
        >
</section>
<section class= "post-body">
        <label for="post-body">
            Body:
        </label>
        <textarea
            type="text"
            id="post-body"
            name="post-body-textarea"
            rows="8"
            cols="70"
        ></textarea>
</section>
<section class= "submite">
    <input type="submit" value="Finish Edit" />
</section>
<section>
    <input type='hidden' name='xsrf' value="<?php echo hash_hmac('sha256', __FILE__, $session->getUserID($username));?>"/>
</section>
</form>