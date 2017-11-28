<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <!-- This has to be the first thing in the body -->
    <div id="ModalContainer">
        <div id="Modal">
            <div id="containerCloseModal">
                <p id="closeModal">X
                    <p>
            </div>
            <div id="divLogin">
                <form id="frmLogin">
                    <p> Login </p>
                    <p>Username</p>
                    <input type="text" placeholder="User name" name="txtUserLoginName">
                    <p>Password</p>
                    <input type="text" placeholder="Password" name="txtUserLoginPassword">
                    <button id="btnLogin" type="button">Login</button>
                    <div id="divLoginResponse"></div>
                </form>

                <p> Don't have an account?</p>
                <button id="btnSwitchToCreateAccount"> Create an account</button>
            </div>
            <div id="divCreateAccount">
                <form id="frmCreateAccount">
                    <p> Create an account </p>

                    <p>Username</p>
                    <input type="text" placeholder="User name" name="txtSaveUserName">
                    <p>Password</p>
                    <input type="text" placeholder="Password" name="txtSaveUserPassword">
                    <p>Email</p>
                    <input type="text" placeholder="Email" name="txtSaveUserEmail">
                    <p> Phone number (optional) </p>
                    <input type="text" name="txtSaveUserPhone">
                    <p> Upload a profile picture</p>
                    <input type="file" name="fileUserImage">
                    <p> Subscribe to newsletter </p>
                    <input id="checkNotification" value="0" type="checkbox" name="checkNotification">
                    <button id="btnCreateAccount" type="button">Create account</button>
                </form>
                <div id="divCreateAccountResponse"></div>
                <p> Already have an account?</p>
                <button id="btnSwitchToLogin"> Sign in</button>
            </div>
        </div>
    </div>

    <script> 

</script>

<!-- *************** -->

<button id="btnOpenLogin">Login</button>

<script>
    
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
    
    </script>

</body>

</html>