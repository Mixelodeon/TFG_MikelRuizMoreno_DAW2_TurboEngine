window.onload = () => { 
    console.log("Script de registro cargado correctamente.");
    let nombre = document.getElementById("nombre");
    let apellidos = document.getElementById("apellidos"); 
    let telefono = document.getElementById("telefono");
    let correo = document.getElementById("correo");
    let dni = document.getElementById("dni");
    let nombreUsuario = document.getElementById("nombreUsuario");
    let password = document.getElementById("password");

    let errorNombre = document.getElementById("errorNombre");
    let errorApellidos = document.getElementById("errorApellidos");
    let errorTelefono = document.getElementById("errorTelefono");
    let errorCorreo = document.getElementById("errorCorreo");
    let errorDni = document.getElementById("errorDni");
    let errorNombreUsuario = document.getElementById("errorNombreUsuario");
    let errorPassword = document.getElementById("errorPassword");

    
    let regexTelefono = /^[0-9]{9}$/;
    let regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let regexDNI = /^[0-9]{8}[A-Za-z]$/;

//     console.log("Expresiones regulares definidas correctamente.");
//         if (!nombreUsuario || !errorNombreUsuario) {
//     console.error("Error: Elementos no encontrados en el DOM.");
//     return;
// }else { console.log("Elementos encontrados correctamente."); }

    nombre.addEventListener("blur", () => {
            if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+)*$/.test(nombre.value)){
                errorNombre.textContent = "Numeros no permitidos";
                errorNombre.setAttribute("style", "color: orange");
            }
            else if(nombre.value.length < 3){
                errorNombre.textContent = "El nombre debe tener al menos 3 letras";
                errorNombre.setAttribute("style", "color: orange");
            }
            else {
                // errorNombreUsuario.textContent = "";
                errorNombre.setAttribute("style" , "display: none");
            }
    })

    apellidos.addEventListener("blur", () => {
            if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+)?$/.test(apellidos.value)){
                errorApellidos.textContent = "Numeros no permitidos";
                errorApellidos.setAttribute("style", "color: orange");
            }
            else if(apellidos.value.length < 3){
                errorApellidos.textContent = "Porfavor introduzca los dos apellidos separados por un espacio";
                errorApellidos.setAttribute("style", "color: orange");
            }
            else {
                // errorNombreUsuario.textContent = "";
                errorApellidos.setAttribute("style" , "display: none");
            }
    })

    telefono.addEventListener("blur", () => {
        if(!regexTelefono.test(telefono.value)){
            errorTelefono.textContent = "Este número de teléfono no es válido";
            errorTelefono.setAttribute("style", "color: orange");
        } 
        else {
            errorTelefono.setAttribute("style", "display: none")
        }
    })

    correo.addEventListener("blur", () => {
        if(!regexCorreo.test(correo.value)){
            errorCorreo.textContent = "Este correo no es valido"; 
            errorCorreo.setAttribute("style", "color: orange");
        }
        else{
            errorCorreo.setAttribute("style", "display: none");
        }
    })

    dni.addEventListener("blur", () => {
        if(!regexDNI.test(dni.value)){
            errorDni.textContent = "El dni introducido no es valido";
            errorDni.setAttribute("style", "color: orange");
        }
        else{
            errorDni.setAttribute("style", "display: none");
        }
    })

    nombreUsuario.addEventListener("blur", () => { 
        if(nombreUsuario.value.length < 3){
            errorNombreUsuario.textContent = "El nombre de usuario debe tener al menos 3 caracteres";
            errorNombreUsuario.setAttribute("style", "color: orange");
        }
        else{
            errorNombreUsuario.setAttribute("style", "display: none");
        }
        // Eliminar espacios en blanco 
        let nombreSinEspacios = nombreUsuario.value.trim();
        // Verificar si el nombre de usuario ya existe en la base de datos
        fetch(`../php/verificar_usuario.php?nombreUsuario=${nombreSinEspacios}`)
            .then(response => response.json())
            .then(data => {
                if (data.existe) {
                    errorNombreUsuario.textContent = "El nombre de usuario ya existe";
                    errorNombreUsuario.setAttribute("style", "color: orange");
                } else {
                    errorNombreUsuario.textContent = ""; // Usuario disponible
                }
        })
    })

    password.addEventListener("blur", () => {
        // Expresión regular para símbolos
        let regexSimbolo = /[-_\/!@#$%^&*()+=.,?{}[\]\\|<>]/; 
        // Expresión regular para letras
        let regexLetra = /[a-zA-Z]/;
        
        if (password.value.length < 8 || !regexSimbolo.test(password.value) || !regexLetra.test(password.value)) {
            // Si la contraseña no cumple con las condiciones, muestra el mensaje de error.
            errorPassword.textContent = "La contraseña debe tener al menos 8 caracteres, un símbolo y una letra.";
            errorPassword.setAttribute("style", "color: orange");
        }
        else {
            // Si es válida, oculta el mensaje de error.
            errorPassword.setAttribute("style", "display: none");
        }
    })
}