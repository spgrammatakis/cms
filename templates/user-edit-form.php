<hr>
<h3>Edit user <?php echo $_GET['user'] ?></h3>
<form method="post" id="user-edit-form">
<p>
        <label for="username">New Name:</label>
        <input
            id="username"
            name="username"
        >
    </p>
    <p>
        <label for="new-user-password">New Password:</label>
        <input
            id="new-user-password"
            name="new-password"
        />
    </p>
    <p>
        <label for="current-user-password">Current Password:</label>
        <input
            id="current-user-password"
            name="current-password"
        />
    </p>
    <p>
        <label for="user-emal">Email:</label>
        <input
            id="user-email"
            name="email"
        ><?php echo lib\Utilities::htmlEscape($row['email']) ?>
    </p>
    <input type="submit" value="Finish Edit" />
</form>