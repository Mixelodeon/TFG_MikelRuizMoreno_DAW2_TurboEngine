document.addEventListener("DOMContentLoaded", function () {
    // Swal.fire({
    //     title: "Bienvenido"
    //     , text: "Esta es una alerta de bienvenida",
    //     timer: 3000,
    //     timerProgressBar: true,
    //     allowOutsideClick: true,
    //     allowEscapeKey: true,
    //     allowEnterKey: true,

    // });
      // Mostrar SweetAlert si hay un error en la URL
    const params = new URLSearchParams(window.location.search);
    if (params.has("error")) {
        // obtiene el valor del parámetro
        const errorCode = params.get("error"); 
        // Error en login
        if (errorCode === "Usuario o contraseña incorrectos") {
            Swal.fire({
            icon: "error",
            title: "Error de inicio de sesión",
            text: "Nombre de usuario o contraseña incorrectos",
            confirmButtonColor: "#3085d6",
            timer: 3000,
            timerProgressBar: true,
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            }).then(() => {
                // Limpiar la URL
                history.replaceState(null, "", window.location.pathname);
            });
        }
        // Error en reserva de cita
        if (errorCode === "ErrorReservarCita") {
            Swal.fire({
            icon: "error",
            title: "Error al reservar cita",
            text: "Algo salio mal al reservar la cita, por favor intente de nuevo",
            confirmButtonColor: "#3085d6",
            timer: 3000,
            timerProgressBar: true,
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            }).then(() => {
                // Limpiar la URL
                history.replaceState(null, "", window.location.pathname);
            });
        }
        // Error al cancerlar cita
        if (errorCode === "ErrorCita") {
            Swal.fire({
            icon: "error",
            title: "Error al cancelar cita",
            text: "Algo salio mal al cancelar la cita, por favor intente de nuevo",
            confirmButtonColor: "#3085d6",
            timer: 3000,
            timerProgressBar: true,
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            }).then(() => {
                // Limpiar la URL
                history.replaceState(null, "", window.location.pathname);
            });
        }
        if (errorCode === "DatosIncompletos") {
            Swal.fire({
            icon: "error",
            title: "Error al solicitar cita",
            text: "Se han detectado campos incompletos al reservar la cita, por favor rellene los campos requeridos",
            confirmButtonColor: "#3085d6",
            timer: 6000,
            timerProgressBar: true,
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            }).then(() => {
                // Limpiar la URL
                history.replaceState(null, "", window.location.pathname);
            });
        }
        if (errorCode === "ErrorUsuarioEliminar") {
            Swal.fire({
            icon: "error",
            title: "Error al eliminar usuario",
            text: "Algo salio mal al eliminar el usuario, por favor intente de nuevo",
            confirmButtonColor: "#3085d6",
            timer: 3000,
            timerProgressBar: true,
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            }).then(() => {
                // Limpiar la URL
                history.replaceState(null, "", window.location.pathname);
            });
        if (errorCode === "errorEliminarPresupuesto") {
            Swal.fire({
            icon: "error",
            title: "Error al eliminar el presupuesto",
            text: "Algo salio mal al eliminar el presupuesto, por favor intente de nuevo",
            confirmButtonColor: "#3085d6",
            timer: 3000,
            timerProgressBar: true,
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            }).then(() => {
                // Limpiar la URL
                history.replaceState(null, "", window.location.pathname);
            });
    }
    if (params.has("success")) {
        const successCode = params.get("success");
        // Éxito en reserva de cita
        if(successCode === "citaReservadaCorrectamente"){
            Swal.fire({
            icon: "success",
            title: "¡Éxito al reservar la cita!",
            text: "Cita reservada correctamente, puede consultar su cita en su perfil",
            confirmButtonColor: "#3085d6",
            timer: 4000,
            timerProgressBar: true,
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true
        }).then(() => {
                // Limpiar la URL
                history.replaceState(null, "", window.location.pathname);
            });
        }
        // Éxito al solicitar presupuesto
        if(successCode === "Presupuesto solicitado correctamente"){
            Swal.fire({
            icon: "success",
            title: "¡Éxito al solicitar el presupuesto!",
            text: "Presupuesto solicitado correctamente, puede consultar su presupuesto en su perfil",
            confirmButtonColor: "#3085d6",
            timer: 4000,
            timerProgressBar: true,
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true
        }).then(() => {
                // Limpiar la URL
                history.replaceState(null, "", window.location.pathname);
            });
        }
        // Éxito al cancelar cita
        if(successCode === "ExitoCita"){
            Swal.fire({
            icon: "success",
            title: "¡Éxito al cancelar la cita!",
            text: "La cita ha sido cancelada correctamente",
            confirmButtonColor: "#3085d6",
            timer: 4000,
            timerProgressBar: true,
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true
        }).then(() => {
                // Limpiar la URL
                history.replaceState(null, "", window.location.pathname);
            });
        }
        if(successCode === "UsuarioEliminado"){
            Swal.fire({
            icon: "success",
            title: "¡Éxito al eliminar el usuario!",
            text: "El usuario ha sido eliminado correctamente",
            confirmButtonColor: "#3085d6",
            timer: 4000,
            timerProgressBar: true,
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true
        }).then(() => {
                // Limpiar la URL
                history.replaceState(null, "", window.location.pathname);
            });
        }
        if(successCode === "presupuestoEliminado"){
            Swal.fire({
            icon: "success",
            title: "¡Éxito al eliminar el presupuesto!",
            text: "El presupuesto ha sido eliminado correctamente",
            confirmButtonColor: "#3085d6",
            timer: 4000,
            timerProgressBar: true,
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true
            }).then(() => {
                // Limpiar la URL
                history.replaceState(null, "", window.location.pathname);
            });
        }
        if(successCode === "presupuestoRespondido"){
            Swal.fire({
                icon: "success",
                title: "¡Éxito al responder el presupuesto!",
                text: "El presupuesto ha sido respondido",
                confirmButtonColor: "#3085d6",
                timer: 4000,
                timerProgressBar: true,
                allowOutsideClick: true,
                allowEscapeKey: true,
                allowEnterKey: true
            }).then(() => {
                // Limpiar la URL
                history.replaceState(null, "", window.location.pathname);
            });
        }
    }
    }
}
})