<?php
include "header.html";
include "navbar.php";
?>
<div class="carousel slide" data-ride="carousel">
    <div class="carousel-inner bg-dark" role="listbox">
        <div class="carousel-item active">
            <div class="d-flex align-items-center justify-content-center min-vh-100" id="HomePageCarousel">
                <form action="search.php" class="input-group input-group-lg " id="HomePageSearchFormCarousel">
                    <input type="text" class="form-control" placeholder="Cerca per nome, scuola, autore ecc..." aria-describedby="basic-addon2" name = q>
                    <button type="submit" class="btn btn-success" id="basic-addon2"><i class="fas fa-search"></i> Cerca</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container py-4 text-center PageContent" id="homePageWho">
    <h1>Chi siamo</h1>
    <p>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In interdum sodales enim id molestie. Fusce molestie lectus vel metus tincidunt, quis semper ante efficitur. In dignissim magna nec lacus pretium, placerat facilisis felis dictum. Suspendisse potenti. Nulla vel nulla mauris. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Maecenas viverra tempor justo, vitae vulputate metus efficitur in.
    </p><p>
    Fusce vehicula dictum dui, nec fermentum nibh efficitur ac. Donec vehicula velit at dui tincidunt, at accumsan urna tempor. Sed eget arcu erat. Integer a ligula mollis, aliquet metus elementum, efficitur libero. Nam egestas, dui id viverra mollis, nulla purus semper orci, quis faucibus mi massa vel nisi. Donec ut ante placerat sapien gravida tincidunt. Aenean et posuere nibh. In hac habitasse platea dictumst. Ut vitae finibus quam. Sed eros lacus, sagittis id magna ut, tincidunt varius mi. Quisque eget est ullamcorper, cursus diam sit amet, consectetur libero. Curabitur rutrum euismod sollicitudin. Pellentesque ultricies auctor turpis ac pharetra. Vivamus sagittis sodales eros, id malesuada neque imperdiet vel. Sed vulputate tincidunt ligula id euismod. Sed sagittis elementum nulla.
    </p><p>
    Phasellus vel ligula elementum, convallis sapien eget, tempus dui. Donec a fringilla neque. Vestibulum interdum, mauris non luctus posuere, urna tortor accumsan risus, et efficitur magna nisl vel justo. Nunc ex leo, lacinia et consequat et, ullamcorper non odio. Donec in purus ac justo hendrerit fermentum id id mauris. Nam consequat at eros vitae dignissim. Praesent rhoncus lacinia purus. Sed et interdum ante, id accumsan libero. Sed nulla justo, sodales id odio vel, interdum venenatis metus. Curabitur eget scelerisque nunc. Aliquam purus tellus, tincidunt at massa eget, sagittis malesuada dolor.
    </p><p>
    Nulla sapien nibh, varius in purus vel, tristique blandit mi. Donec molestie lobortis quam, a posuere nulla tincidunt nec. Proin facilisis purus leo, eget convallis elit pretium eu. Aenean ex lectus, bibendum ac pulvinar quis, rutrum sed orci. Aenean in nunc viverra, vestibulum leo eget, venenatis leo. Aenean interdum tellus sed odio consequat, facilisis fringilla justo semper. Donec nec sodales enim, ut aliquet enim. Phasellus eu felis ullamcorper elit ultricies suscipit vel nec risus. Sed efficitur augue at arcu efficitur, id dictum est laoreet. Sed est arcu, scelerisque sit amet molestie vitae, eleifend sed nisl. Morbi eu leo ac justo fermentum pretium. Duis eget posuere erat. Aliquam interdum massa sit amet laoreet facilisis. Donec eget mauris eu lacus rutrum sollicitudin. Cras pulvinar sapien eros, et placerat neque aliquet a. Proin vitae condimentum nibh.
    </p><p>
    Aliquam rutrum tellus eu mauris imperdiet lacinia. Ut maximus, nunc sagittis posuere vulputate, justo lacus pretium enim, at bibendum lectus ex vel elit. Fusce placerat risus et nunc vehicula lacinia. Maecenas eget mattis purus. Nunc dignissim dolor viverra finibus viverra. Nunc viverra, neque eu ultricies suscipit, eros urna volutpat purus, in maximus libero risus quis sem. Nulla dolor arcu, mollis at mollis non, consectetur condimentum tortor. Donec sed tincidunt diam. Sed rhoncus ultrices rutrum. Aenean volutpat mollis fringilla. Phasellus vulputate efficitur sapien sagittis vulputate.
    </p>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<?php include "footer.html" ?>
