<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }
        .registro-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            margin: 20px;
        }
        .registro-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .registro-body {
            padding: 40px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-registro {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: transform 0.2s;
            color: white;
        }
        .btn-registro:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .password-strength {
            height: 5px;
            border-radius: 3px;
            margin-top: 5px;
            transition: all 0.3s;
        }
        .strength-weak { background: #dc3545; width: 33%; }
        .strength-medium { background: #ffc107; width: 66%; }
        .strength-strong { background: #28a745; width: 100%; }
        .form-label {
            font-weight: 500;
            color: #495057;
        }
        .input-group-text {
            background: white;
            border-right: none;
        }
        .form-control.with-icon {
            border-left: none;
        }
    </style>
</head>
<body>
    <div class="registro-container">
        <div class="registro-header">
            <i class="bi bi-person-plus-fill" style="font-size: 3rem;"></i>
            <h2 class="mt-3 mb-0">Crear Cuenta</h2>
            <p class="mb-0 mt-2">Completa el formulario para registrarte</p>
        </div>
        <div class="registro-body">
            <form id="registroForm" action="./acciones/insertarUsuario.php" method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">
                        <i class="bi bi-person-badge me-1"></i>Nombre de Usuario
                    </label>
                    <input type="text" class="form-control" id="usuario" name="usnombre" 
                           placeholder="Elige un nombre de usuario" required>
                    <small class="form-text text-muted">Mínimo 4 caracteres</small>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope-fill me-1"></i>Correo Electrónico
                    </label>
                    <input type="email" class="form-control" id="email" name="usmail" 
                           placeholder="correo@ejemplo.com" required>
                </div>            
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock-fill me-1"></i>Contraseña
                    </label>
                    <input type="password" class="form-control" id="password" name="uspass" 
                           placeholder="Crea una contraseña segura" required>
                    <div id="passwordStrength" class="password-strength"></div>
                    <small class="form-text text-muted">Mínimo 8 caracteres</small>
                </div>
                <button type="submit" class="btn btn-registro w-100">
                    <i class="bi bi-check-circle me-2"></i>Registrarse
                </button>
            </form>
            <hr class="my-4">
            <div class="text-center">
                <p class="text-muted mb-0">¿Ya tienes cuenta?</p>
                <a href="../index.php" class="text-decoration-none fw-bold">Inicia sesión aquí</a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>