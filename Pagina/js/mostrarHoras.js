document.addEventListener("DOMContentLoaded", () => {
    const horaSelect = document.getElementById("hora");
    const idCita = document.querySelector("input[name='id_cita']").value;

    fetch("../back/mostrar_cita_a_cambiar.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id_cita=${idCita}`,
    })
        .then((response) => response.json())
        .then((data) => {
            horaSelect.innerHTML = '<option value="">-- Horas disponibles --</option>';

            data.forEach((hora) => {
                const option = document.createElement("option");
                option.value = hora;
                option.text = hora;
                horaSelect.appendChild(option);
            });
        })
        .catch((error) => {
            console.error("Error cargando las horas:", error);
        });
});
