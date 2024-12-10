<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!--Favicons-->
    <link rel="icon" type="image/x-icon" href="./assets/img/logos/logo.png" />
    <link rel="shortcut icon" type="image/x-icon" href="./assets/img/img/LOGO CHEF TABLE-01.png" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <!--Css Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--Css App-->

    <link rel="stylesheet" href="./assets/css2/login.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-6 mx-auto mt-3 p-2 container-form">
                <img src="./assets/img/img/LOGO CHEF TABLE-01.png" alt="logo" width="145px" height="65px" />
                <h4 class="text-center mt-1">LOGIN USER</h4>




                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                
                 <!-- Cambiar la acción del formulario para que apunte al método authenticate -->
                 <form id="formLogin" class="mt-2 p-1 mb-2 " action="<?= base_url('login') ?>" method="post">
                    <div class="form-floating mb-2">                        
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña" required>
                        <button class="btn btn-outline-secondary" type="button" id="btn-password"><img src="./assets/img/icons/eye-slash-fill.svg" alt></button>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">LOGIN</button>
                        <a href="<?= base_url('inicio') ?>" class="btn btn-secondary w-100">Inicio</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Script bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <!--Script app-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const togglePasswordButton = document.getElementById('btn-password');

            togglePasswordButton.addEventListener('click', function() {
                // Mostrar la contraseña temporalmente
                passwordInput.type = 'text'; // Cambia el tipo a 'text' para mostrar la contraseña
                togglePasswordButton.innerHTML = '<img src="./assets/img/icons/eye-fill.svg" alt>'; // Cambia el ícono del botón

                // Establecer un temporizador para volver a ocultar la contraseña después de 2 segundos (ajustable)
                setTimeout(function() {
                    passwordInput.type = 'password'; // Cambia el tipo a 'password' para ocultar la contraseña nuevamente
                    togglePasswordButton.innerHTML = '<img src="./assets/img/icons/eye-slash-fill.svg" alt>'; // Restaura el ícono original del botón
                }, 1000); // 2000 milisegundos = 2 segundos (ajustable según tus necesidades)
            });
        });
    </script>

</body>

</html>