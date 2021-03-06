<hr>
<h3>Edit user <?php echo $_GET['user'] ?></h3>
<form method="post" id="user-edit-form">
<section class="username">
        <label for="new-username">New Name:</label>
        <input id="new-username" name="new-username">
        <span class="help-block"><?php echo $userNameError; ?></span>
</section>
<section class= "new-password">
        <label for="new-user-password">New Password:</label>
        <input type="password" id="new-user-password" name="new-password"/>
        <span class="help-block"><?php echo $newPasswordError; ?></span>
</section>
<section class= "current-user-password">
        <label for="current-user-password">Current Password:</label>
        <input type="password" id="current-user-password" name="current-password"/>
        <span class="help-block"><?php echo $currentPasswordError; ?></span>
</section>
<section class= "new-email">
        <label for="new-emal">Email:</label>
        <input id="new-email" name="new-email">
        <span class="help-block"><?php echo $emailError; ?></span>
</section>
<section class= "submit">
    <input type="submit" value="Finish Edit" />
</section>
<section>
    <input type='hidden' name='xsrf' value="<?php echo hash_hmac('sha256', 'edit-user.php', $userHandler->getUserIDFromName($username));?>"/>
</section>
<span class="help-block"><?php echo $xsrfError; ?></span>
</form>