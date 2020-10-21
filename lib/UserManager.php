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
            echo "<div class='tr username  user-table-row'>";
            echo "<div class='td user-table-cell'>Username</div>";
            echo "<div class='td'>".Utilities::htmlEscape($row[0]['username'])."</div>";
            echo "</div>";
            echo "<div class='tr email user-table-row'>";
            echo "<div class='td user-table-cell'>Email</div>";
            echo "<div class='td'>".Utilities::htmlEscape($row[0]['email'])."</div>";
            echo "</div>";
            echo "<div class='tr created-at user-table-row'>";
            echo "<div class='td user-table-cell'>Created at</div>";
            echo "<div class='td'>".Utilities::htmlEscape($row[0]['created_at'])."</div>";
            echo "</div>";
            echo "<div class='tr modification-time user-table-row'>";
            echo "<div class='td user-table-cell'>Modification Time</div>";
            echo "<div class='td'>".Utilities::htmlEscape($row[0]['modification_time'])."</div>";
            echo "</div>";
            echo "<div class='tr is-enabled user-table-row'>";
            echo "<div class='td user-table-cell'>Is Enabled</div>";
            echo "<div class='td'>".Utilities::htmlEscape($row[0]['is_enabled'])."</div>";
            echo "</div>";
        echo "</div>";
        return;
    }
}
?>