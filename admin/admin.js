function redirectToEditUser(id) {  
    console.log(id);
    }

    var button = document.getElementsByTagName('button');
        for(let i = 0;i<button.length;i++){
            if(button[i].className === "user-table-edit-button"){
                console.log(button[i].parentElement);
                button[i].parentElement.parentElement.childNodes[3].style.visibility = "hidden"; 
                button[i].addEventListener("click", function(){
                    let  res = button[i].parentElement.childNodes[1].innerText.split("\t");
                    redirectToEditUser(res[1]);           
                    if (button[i].parentElement.parentElement.childNodes[3].style.visibility === "hidden") {
                        button[i].parentElement.parentElement.childNodes[3].style.visibility = "visible";
                      } else {
                        button[i].parentElement.parentElement.childNodes[3].style.visibility = "hidden";
                      }
                });
            }
        }