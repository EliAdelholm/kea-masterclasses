


// If a user is logged in make dropdown menu and login available
var dropdown = document.getElementById('btnOpenDropdown');
var isDropdownOpen = false;

if (dropdown) {

    // TOGGLE DROPDOWN MENU
    btnOpenDropdown.addEventListener('click', function () {
        if (!isDropdownOpen) {
            navDropdown.style.display = "block";
        } else {
            navDropdown.style.display = "none";
        }

        isDropdownOpen = !isDropdownOpen;
    })

    // AJAX FOR LOGGING OUT
    btnLogout.addEventListener('click', function () {
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var sResponse = this.responseText;
                console.log(sResponse);
                if (sResponse == "Logged out") {
                    location.reload();
                }
            }
        }
        ajax.open("GET", "../api/php/logout.php", true);
        ajax.send();
    })
}

// If a user is not logged in make the functions available
var login = document.getElementById('btnOpenLogin');
var view = 'login';

if (login) {

    // Open login
    btnOpenLogin.addEventListener('click', function () {
        ModalContainer.style.display = "flex";
    })

    // Close login
    document.addEventListener("click", function (e) {
        if (e.target.id == "ModalContainer") {
            ModalContainer.style.display = "none";
            view = 'login';
        }
    });

    if (view == 'login') {

        // Switch to signup form
        btnSwitchToCreateAccount.addEventListener('click', function () {
            divLogin.style.display = "none";
            divCreateAccount.style.display = "flex";
            view = 'signup';
        })

        // Login
        btnLogin.addEventListener('click', function () {
            doLogin();
        })
    }

    if (view == 'signup') {

        // Switch to login page
        btnSwitchToLogin.addEventListener('click', function () {
            divCreateAccount.style.display = "none";
            divLogin.style.display = "flex";
            view = 'login';
        })

        // Create Account
        btnCreateAccount.addEventListener('click', function () {
            doSignup();
        })

        // Check notifications
        checkNotification.addEventListener('click', function () {
            doNotificationStuff();
        })
    }




}

// AJAX FOR INTERACTING WITH LOGIN
function doLogin() {
    divCreateAccountResponse.innerHTML = "Logging you in..."
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Response will either be 'Logging in' or 'Account does not exist'
            var sResponse = this.responseText;
            console.log(sResponse);
            divLoginResponse.innerHTML = sResponse;
            if (sResponse == "Logging in") {
                location.reload();
            }
        }
    }
    ajax.open("POST", "../api/php/login.php", true);
    // What am I posting ?????
    var jFrmLogin = new FormData(frmLogin);
    ajax.send(jFrmLogin);
}


// AJAX FOR INTERACTING WITH SAVE USER
function doSignup() {
    divCreateAccountResponse.innerHTML = "Creating Account..."
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var sResponse = this.responseText;
            console.log(sResponse);
            divCreateAccountResponse.innerHTML = "Account created successfully"
        }
    }
    ajax.open("POST", "../api/php/save-user.php", true);
    // What am I posting ?????
    var jFrmCreateAccount = new FormData(frmCreateAccount);
    ajax.send(jFrmCreateAccount);
}



// Setting the notification value for true and false
function doNotificationStuff() {
    if (this.checked) {
        this.value = 1;
        console.log(this.value);
    }
    else {
        this.value = 0;
        console.log(this.value);
    }
};