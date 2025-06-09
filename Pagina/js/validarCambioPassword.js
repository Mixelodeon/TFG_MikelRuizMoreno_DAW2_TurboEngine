window.onload = () => {

    let nuevaPassword = document.getElementById("nuevaPassword");
    let errorPassword = document.getElementById("errorPassword");

    let nuevaPasswordConfirm = document.getElementById("nuevaPasswordConfirm");
    let errorComprobacion = document.getElementById("errorComprobacion");

    let botonCambiar = document.getElementById("botonCambiar");
    botonCambiar.disabled = true;
    botonCambiar.style.backgroundColor = "grey";

    let controlErrores = {
        nuevaPassword: true,
        confirmacionPassword: true,
    };
    
    function verificarErrores() {
        const hayErrores = Object.values(controlErrores).some(e => e);
        botonCambiar.disabled = hayErrores;
        botonCambiar.style.backgroundColor = hayErrores ? "grey" : "orange";
    }
    nuevaPassword.addEventListener("blur", () => {
        // Expresión regular para símbolos
        let regexSimbolo = /[-_\/!@#$%^&*()+=.,?{}[\]\\|<>]/; 
        // Expresión regular para letras
        let regexLetra = /[a-zA-Z]/;
        
        if (nuevaPassword.value.length < 8 || !regexSimbolo.test(nuevaPassword.value) || !regexLetra.test(nuevaPassword.value)) {
            // Si la contraseña no cumple con las condiciones, muestra el mensaje de error.
            errorPassword.textContent = "La contraseña debe tener al menos 8 caracteres, un símbolo y una letra.";
            errorPassword.setAttribute("style", "color: orange");
            controlErrores.nuevaPassword = true;
        }
        else {
            // Si es válida, oculta el mensaje de error.
            errorPassword.setAttribute("style", "display: none");
            controlErrores.nuevaPassword = false;
        }
        verificarErrores();
    })

    nuevaPasswordConfirm.addEventListener("blur", () => {
        if (nuevaPasswordConfirm.value != nuevaPassword.value) {
            errorComprobacion.textContent = "Las contraseñas no coinciden.";
            errorComprobacion.setAttribute("style", "color: orange");
            controlErrores.confirmacionPassword = true;
        } else {
            errorComprobacion.setAttribute("style", "display: none");
            controlErrores.confirmacionPassword = false;
        }
        verificarErrores();
    })
}