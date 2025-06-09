document.addEventListener("DOMContentLoaded", function () {
    fetch("../back/mostrar_citas.php")
        .then(response => response.json())
        .then(data => {
            const fechaSelect = document.getElementById("fecha")
            const horaSelect = document.getElementById("hora")

            // Guardamos las citas en memoria para consultar horas luego
            const citas = data;

            // Rellenar fechas disponibles
            for (const fecha in citas) {
                const option = document.createElement("option")
                option.value = fecha;
                option.textContent = fecha;
                fechaSelect.appendChild(option)
            }

            // Escuchar cuando cambie la fecha para actualizar las horas
            fechaSelect.addEventListener("change", function () {
                const selectedFecha = this.value;
                horaSelect.innerHTML = '<option value="">-- Horas Disponibles... --</option>';

                if (selectedFecha && citas[selectedFecha]) {
                    citas[selectedFecha].forEach(hora => {
                        const option = document.createElement("option");
                        option.value = hora;
                        option.textContent = hora;
                        horaSelect.appendChild(option);
                    })
                }
            })
        })
        .catch(error => {
            console.error("Error cargando citas:", error);
        });
})