<?php
namespace lib;
class UserManager extends DbConnection{

    public function __construct(){
        parent::__construct();
    }
    public function getAllUsers()
    {
        $this->prepareStmt("SELECT username, email, created_at, modification_time, is_enabled FROM users");
        $row  = $this->All();
        foreach($row as $row):
            echo "<div class=username>";
            echo "Username: " .Utilities::htmlEscape($row['username']);
            echo "</div>";
            echo "<div class=email>";
            echo "Email: " .Utilities::htmlEscape($row['email']);
            echo "</div>";
            echo "<div class=created-at>";
            echo "Created at: " . Utilities::htmlEscape($row['created_at']);
            echo "</div>";
            echo "<div class=modification-time>";
            echo "Modification Time: " . Utilities::htmlEscape($row['modification_time']);
            echo "</div>";
            echo "<div class=is-enabled>";
            echo "Is Enabled: " .Utilities::htmlEscape($row['is_enabled']);
            echo "</div>";
        endforeach;
        return;
    }
}
?>