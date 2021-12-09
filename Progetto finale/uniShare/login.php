<?php
include "header.html";
include "navbar.php";

?>

<div  id="LoginForm">
    <h4>Accesso utente registrato</h4>
    <span class="px-4 py-3">
        <div class="mb-3">
            <label for="exampleDropdownFormEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleDropdownFormPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="dropdownCheck">
                <label class="form-check-label" for="dropdownCheck">
                    Remember me
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Accedi</button>
    </span>
</div>
<?php
include "footer.html";
?>
