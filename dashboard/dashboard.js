function redirectToEditUser(username) {  
    window.location.href = "/dashboard/manageusers/all-users.php?user=" + username;
    }

    var button = document.getElementsByTagName('button');
        for(let i = 0;i<button.length;i++){
            if(button[i].className === "user-table-edit-button"){
                button[i].addEventListener("click", function(){
                    let username = document.getElementById(i).getElementsByClassName("username")[0].innerHTML;
                    redirectToEditUser(username);
                });
            }
        }