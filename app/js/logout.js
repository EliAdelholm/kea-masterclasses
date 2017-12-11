// If a user is logged in make dropdown menu and login available
// var dropdown = document.getElementById('btnOpenDropdown');
// var isDropdownOpen = false;

// var browserWidth = window.innerWidth;;
//     if (dropdown) {
//         // TOGGLE DROPDOWN MENU
//         btnOpenDropdown.addEventListener('click', function () {
//             // if(browserWidth > 800){
//                 console.log(browserWidth);
//                 if (!isDropdownOpen) {
//                     navDropdown.style.display = "block";
//                 } else {
//                     navDropdown.style.display = "none";
//                 }
//                 isDropdownOpen = !isDropdownOpen;
//             // }
//         })

//     }



// AJAX FOR LOGGING OUT
btnLogout.addEventListener("click", function () {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var sResponse = this.responseText;
            console.log(sResponse);
            if (sResponse == "Logged out") {
                window.location.href="index.php"
            }
        }
    }
    ajax.open("GET", "../api/php/logout.php", true);
    ajax.send();
})