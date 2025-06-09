window.onload = () => { 
    console.log("ValidacionesForms se a cargado.");
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

     let controlErrores = {
        nombre: true,
        apellidos: true,
        telefono: true,
        correo: true,
        dni: true,
        nombreUsuario: true,
        password: true
    };


    let botonRegistrar = document.getElementById("botonRegistrar");
    botonRegistrar.disabled = true;
    botonRegistrar.style.backgroundColor = "grey";

    
    let regexTelefono = /^[0-9]{9}$/;
    let regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let regexDNI = /^[0-9]{8}[A-Za-z]$/;

    function verificarErrores() {
        const hayErrores = Object.values(controlErrores).some(e => e);
        botonRegistrar.disabled = hayErrores;
        botonRegistrar.style.backgroundColor = hayErrores ? "grey" : "orange";
    }


    nombre.addEventListener("blur", () => {
            if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+)*$/.test(nombre.value)){
                errorNombre.textContent = "Numeros no permitidos";
                errorNombre.setAttribute("style", "color: orange");
                controlErrores.nombre = true;
            }
            else if(nombre.value.length < 3){
                errorNombre.textContent = "El nombre debe tener al menos 3 letras";
                errorNombre.setAttribute("style", "color: orange");
                controlErrores.nombre = true;
            }
            else {
                // errorNombreUsuario.textContent = "";
                errorNombre.setAttribute("style" , "display: none");
                controlErrores.nombre = false;
            }
            verificarErrores();
    })

    apellidos.addEventListener("blur", () => {
            if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+)?$/.test(apellidos.value)){
                errorApellidos.textContent = "Numeros no permitidos";
                errorApellidos.setAttribute("style", "color: orange");
                controlErrores.apellidos = true;
            }
            else if(apellidos.value.length < 3){
                errorApellidos.textContent = "Porfavor introduzca los dos apellidos separados por un espacio";
                errorApellidos.setAttribute("style", "color: orange");
                controlErrores.apellidos = true;
            }
            else {
                // errorNombreUsuario.textContent = "";
                errorApellidos.setAttribute("style" , "display: none");
                controlErrores.apellidos = false;
            }
            verificarErrores();
    })

    telefono.addEventListener("blur", () => {
        if(!regexTelefono.test(telefono.value)){
            errorTelefono.textContent = "Este número de teléfono no es válido";
            errorTelefono.setAttribute("style", "color: orange");
            controlErrores.telefono = true;
        } 
        else {
            errorTelefono.setAttribute("style", "display: none");
            controlErrores.telefono = false;
        }
        verificarErrores();
    })

    correo.addEventListener("blur", () => {
        if(!regexCorreo.test(correo.value)){
            errorCorreo.textContent = "Este correo no es valido"; 
            errorCorreo.setAttribute("style", "color: orange");
            controlErrores.correo = true;
        }
        else{
            errorCorreo.setAttribute("style", "display: none");
            controlErrores.correo = false;
        }
        verificarErrores();
    })

    dni.addEventListener("blur", () => {
        if(!regexDNI.test(dni.value)){
            errorDni.textContent = "El dni introducido no es valido";
            errorDni.setAttribute("style", "color: orange");
            controlErrores.dni = true;
        }
        else{
            errorDni.setAttribute("style", "display: none");
            controlErrores.dni = false;
        }
        verificarErrores();
    })

    nombreUsuario.addEventListener("blur", () => { 
        if(nombreUsuario.value.length < 3){
            errorNombreUsuario.textContent = "El nombre de usuario debe tener al menos 3 caracteres";
            errorNombreUsuario.setAttribute("style", "color: orange");
            controlErrores.nombreUsuario = true;
        }
        else{
            errorNombreUsuario.setAttribute("style", "display: none");
            controlErrores.nombreUsuario = false;
        }
        // Eliminar espacios en blanco 
        let nombreSinEspacios = nombreUsuario.value.trim();
        // Verificar si el nombre de usuario ya existe en la base de datos
        fetch(`../back/verificar_usuario.php?nombreUsuario=${nombreSinEspacios}`)
            .then(response => response.json())
            .then(data => {
                if (data.existe) {
                    errorNombreUsuario.textContent = "El nombre de usuario ya existe";
                    errorNombreUsuario.setAttribute("style", "color: orange");
                    controlErrores.nombreUsuario = true;
                } else {
                    errorNombreUsuario.textContent = ""; // Usuario disponible
                    controlErrores.nombreUsuario = false;
                }
                verificarErrores();
        })
        .catch(error => {
            console.error("Error al verificar el nombre de usuario:", error);
            errorNombreUsuario.textContent = "Error al verificar usuario";
            errorNombreUsuario.setAttribute("style", "color: red");
            controlErrores.nombreUsuario = true;
            verificarErrores();
        });
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
            controlErrores.password = true;
        }
        else {
            // Si es válida, oculta el mensaje de error.
            errorPassword.setAttribute("style", "display: none");
            console.log(controlErrores);
            controlErrores.password = false;
        }
        verificarErrores();
    })
}