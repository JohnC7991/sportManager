<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #010d4d92 20%, #457ef0b5 30%, #0721e6b5 50%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: #4041431e, #b5b3b38a ;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(6, 10, 56, 0.12);
            width: 100%;
            max-width: 500px;
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #e2dcdc;
            font-weight: bold;
            font-size: 14px;

        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="tel"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        
        .form-row-full {
            grid-column: 1 / -1;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1468f9 0%, #0800f5 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
            margin-top: 10px;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #e9edfc;
        }
        
        .login-link a {
            color: #0800f7;
            text-decoration: none;
            font-weight: bold;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #c62828;
        }
        
        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #2e7d32;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Crear Escuela</h1>
        
        <?php if (isset($mensaje) && !empty($mensaje)): ?>
            <div class="<?php echo ($tipo_mensaje === 'success') ? 'success-message' : 'error-message'; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>
        
        <form action="index.php" method="POST">
            <!-- Tipo de Documento y Documento -->
            <!-- <div class="form-group form-row">
                <div>
                    <label for="tipo_documento">Tipo Documento*</label>
                    <select id="tipo_documento" name="tipo_documento" required>
                        <option value="">Seleccionar...</option>
                        <option value="CC">Cédula de Ciudadanía</option>
                        <option value="TI">Tarjeta de Identidad</option>
                        <option value="CE">Cédula de Extranjería</option>
                        <option value="PP">Pasaporte</option>
                    </select>
                </div>
                <div>
                    <label for="id">Número Documento*</label>
                    <input type="text" id="id" name="id" placeholder="Ej: 1111111111" required>
                </div>
            </div> -->
            
            <!-- Nombres y Apellidos -->
            <div class="form-group">
                <div>
                    <label for="nombreEscuela">Nombre de la Escuela*</label>
                    <input type="text" id="nombreEscuela" name="nombreEscuela" placeholder="Nombre Escuela" required>
                </div>
            </div>
            <div class="form-group">
                <div>
                    <label for="Disciplina">Disciplina*</label>
                    <input type="text" id="Disciplina" name="Disciplina" placeholder="Disciplina" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Correo Electrónico*</label>
                <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono*</label>
                <input type="tel" id="telefono" name="telefono" pattern="[0-9]{10}" placeholder="3111111111" required>
            </div>
            
            <!-- Escuela -->
            <div class="form-group">
                <label for="id_escuela">Escuela/Institución*</label>
                <select id="id_escuela" name="id_escuela" required>
                    <option value="">Seleccionar...</option>
                    <option value="1">Atletico Tapitas</option>
                </select>
            </div>
            
            <!-- Rol -->
            <div class="form-group">
                <label for="id_rol">Rol de Usuario*</label>
                <select id="id_rol" name="id_rol" required>
                    <option value="">Seleccionar...</option>
                    <option value="2">Usuario</option>
                    <option value="1" disabled>Administrador</option>
                </select>
            </div>
            
            <!-- Contraseña -->
            <div class="form-group">
                <label for="contrasena">Contraseña*</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Mínimo 8 caracteres" required>
            </div>
            
            <!-- Confirmar Contraseña -->
            <div class="form-group">
                <label for="confirmar_contrasena">Confirmar Contraseña*</label>
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirme su contraseña" required>
            </div>
            
            <!-- Botón Submit -->
            <button type="submit" name="action" value="registro">Registrarse</button>
            
            <!-- Link a Login -->
            <div class="login-link">
                ¿Ya tienes cuenta? <a href="./login.php">Inicia sesión aquí</a>
            </div>
        </form>
    </div>
</body>
</html>