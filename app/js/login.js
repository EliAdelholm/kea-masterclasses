
// Opening and closing the modal
    
btnOpenLogin.addEventListener("click", function () {
    ModalContainer.style.display = "flex";
});

closeModal.addEventListener("click", function () {
    ModalContainer.style.display = "none";
});

document.addEventListener("click", function (e) {
    if (e.target.id == "ModalContainer") {
        ModalContainer.style.display = "none";
    }
});

// Switching between login and create account

btnSwitchToCreateAccount.addEventListener("click", function () {
    divLogin.style.display = "none";
    divCreateAccount.style.display = "flex";
});

btnSwitchToLogin.addEventListener("click", function () {
    divCreateAccount.style.display = "none";
    divLogin.style.display = "flex";
});

// AJAX FOR INTERACTING WITH LOGIN
btnLogin.addEventListener("click", function () {
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
})


// AJAX FOR INTERACTING WITH SAVE USER
btnCreateAccount.addEventListener("click", function () {
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
})

// AJAX FOR LOGGING OUT
btnLogout.addEventListener("click", function () {
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

// Setting the notification value for true and false

        checkNotification.addEventListener("click", function () {
            if (this.checked) {
                this.value = 1;
                console.log(this.value);
            }
            else {
                this.value = 0;
                console.log(this.value);                
            }
        });
