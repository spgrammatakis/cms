function redirectToEditUser(id) {  
    console.log(id);
    }

    var button = document.getElementsByTagName('button');
        for(let i = 0;i<button.length;i++){
            if(button[i].className === "user-table-edit-button"){                
                button[i].addEventListener("click", function(){
                    let  res = button[i].parentElement.childNodes[1].innerText.split("\t");
                    redirectToEditUser(res[1]);
                    var vis = button[i].parentElement.parentElement.childNodes[3];
                    console.log(vis);
                    if (vis.style.visibility === "hidden") {
                        vis.style.visibility = "visible";
                      } else {
                        vis.style.visibility = "hidden";
                      }
                });
            }
        }