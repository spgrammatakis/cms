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
            echo "<div id=user-table>";
        foreach($row as $row):
            echo "<div class='user-table-block'>";
            echo "<div class='user-table-block-left'>";
            echo "<div class='username  user-table-row'>";
            echo "<div class='user-table-cell'>Username</div>";
            echo "<div class='user-table-cell'>".Utilities::htmlEscape($row['username'])."</div>";
            echo "</div>";
            echo "<div class='email user-table-row'>";
            echo "<div class='user-table-cell'>Email</div>";
            echo "<div class='user-table-cell'>".Utilities::htmlEscape($row['email'])."</div>";
            echo "</div>";
            echo "<div class='created-at user-table-row'>";
            echo "<div class='user-table-cell'>Created at</div>";
            echo "<div class='user-table-cell'>".Utilities::htmlEscape($row['created_at'])."</div>";
            echo "</div>";
            echo "<div class='modification-time user-table-row'>";
            echo "<div class='user-table-cell'>Modification Time</div>";
            echo "<div class='user-table-cell'>".Utilities::htmlEscape($row['modification_time'])."</div>";
            echo "</div>";
            echo "<div class='tr is-enabled user-table-row'>";
            echo "<div class='user-table-cell'>Is Enabled</div>";
            echo "<div class='user-table-cell'>".Utilities::htmlEscape($row['is_enabled'])."</div>";
            echo "</div>";
            echo "</div>";
            echo "<div class=user-table-block-right>AXNE</div>";
            echo "<div class='user-table-block-button'>";
            echo "<button class='user-edit-button'>Edit User</button>";
            echo "</div>";
            echo "</div>";
        endforeach;
            echo "</div>";
        return;
    }
}
?>