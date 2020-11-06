<hr>
<h3>Edit user <?php echo $_GET['user'] ?></h3>
<form method="post" id="user-edit-form">
<section class="username">
        <label for="new-username">New Name:</label>
        <input
            id="new-username"
            name="new-username"
        >
</section>
<section class= "new-password">
        <label for="new-user-password">New Password:</label>
        <input
            type="password"
            id="new-user-password"
            name="new-password"
        />
</section>
<section class= "current-user-password">
        <label for="current-user-password">Current Password:</label>
        <input
            type="password"
            id="current-user-password"
            name="current-password"
        />
</section>
<section class= "new-email">
        <label for="new-emal">Email:</label>
        <input
            id="new-email"
            name="new-email"
        >
</section>
<section class= "submit">
    <input type="submit" value="Finish Edit" />
</section>
</form>