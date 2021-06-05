<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title> inicio de sesion</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    <body>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="container">
            <form method="POST" action="<?php echo "index.php?controller=User_login&action=login"; ?>">
            <div class="col-xs-12 col-md-4 col-md-offset-4 well form-group" id="principal">
                <div class="row">
                    
                    
                </div>
                <div class="row well">
                    <div class="col-xs-12">
                        <label>Nombre de usuario:</label>
                        <input class="form-control" name="cli_email">
                    </div>
                </div>
                <br>
                <div class="row well">
                    <div class="col-xs-12">
                        <label>Contraseña:</label>
                        <input  type="password" class="form-control" name="cli_password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button class="btn btn-primary btn-block" id="btn-Login" type="submit">Ingresar <i class="glyphicon glyphicon-user" ></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <a class="btn btn-link btn-block">Olvidé mi contraseña
                            <i class="glyphicon glyphicon-question-sign"></i></a>
                    </div>
                </div>
                
                
            </div>
                </form>
            
 
        </div>
    </body>
</html>

