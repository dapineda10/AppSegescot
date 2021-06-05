<div class="limiter">
    <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
        <div class="wrap-login100 p-t-30 p-b-50">
            <form method="POST" class="login100-form validate-form p-b-33 p-t-5" action="<?php echo "index.php?controller=Login&action=login"; ?>">
                <div class="wrap-input100 validate-input" data-validate = "Enter username">
                    <input class="input100" type="text" name="usu_email" placeholder="Cédula o email">
                    <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Contraseña">
                    <input class="input100" type="password" name="usu_password" placeholder="Contraseña">
                    <input class="usu_bienvenida" type="hidden" name="usu_bienvenida" value="1">
                    <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                    </div>
                <div class="wrap-input100 checkbox-inline col-lg-offset-4 col-xs-offset-4">
                    <input name="check" id="checkPrivacidad" type="checkbox"><a href="index.php?controller=Login&action=index2">Aceptar terminos y condiciones</a>
                </div>
                <div class="container-login100-form-btn m-t-32">
                    <button class="login100-form-btn" id="btnContinuarPrivacidad">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>