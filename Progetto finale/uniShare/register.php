<?php
include "header.html";
include "navbar.php";

?>
<script src="src/js/register.js"></script>

<div  id="RegisterForm">
    <h4>Creazione nuovo utente</h4>
    <div class="alert alert-danger ErrorLoginRegisterDiv" role="alert" id="ErrorRegisterDiv" >
        <strong>Errore: </strong>
        <div id="ErrorRegisterDivContent">
        </div>
    </div>
    <div class="px-4 py-3">
        <div class="mb-3">
            <label for="InputNome" class="form-label">Nome</label>
            <input type="email" class="form-control" id="InputNome" placeholder="Nome">
        </div>
        <div class="mb-3">
            <label for="InputCognome" class="form-label">Cognome</label>
            <input type="email" class="form-control" id="InputCognome" placeholder="Cognome">
        </div>
        <div class="mb-3">
            <label for="InputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="InputEmail" placeholder="email@example.com">
        </div>
        <div class="mb-3">
            <label for="InputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="InputPassword1" placeholder="Password">
        </div>
        <div class="mb-3">
            <label for="InputPassword2" class="form-label">Ripeti password</label>
            <input type="password" class="form-control" id="InputPassword2" placeholder="Password">
        </div>

        <div id="RegisterFormSubmit" class="btn btn-primary">Registrati</div>
    </div>
</div>


<?php
include "footer.html";
?>
