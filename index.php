<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./VISTA/ACCION/ESTRUCTURA/styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
            <h2 class="mt-3 mb-0">Iniciar Sesión</h2>
        </div>
        <div class="login-body">            
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="usuario" class="form-label">
                        <i class="bi bi-person-fill me-1"></i>Usuario
                    </label>
                    <input type="text" class="form-control" id="usuario" name="usuario" 
                           placeholder="Ingresa tu usuario" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock-fill me-1"></i>Contraseña
                    </label>
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="Ingresa tu contraseña" required>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="recordar" name="recordar">
                    <label class="form-check-label" for="recordar">
                        Recordarme
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary btn-login w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                </button>
            </form>
            
            <div class="text-center mt-3">
                <a href="#" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
            </div>
            
            <hr class="my-4">
            
            <div class="text-center">
                <p class="text-muted mb-0">¿No tienes cuenta?</p>
                <a href="./VISTA/registrarUsuario.php" class="text-decoration-none fw-bold">Regístrate aquí</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>