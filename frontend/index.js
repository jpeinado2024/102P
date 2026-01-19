// Passwor
function convertir(inputId, spanId) {
    const input = document.getElementById(inputId);
    const span = document.getElementById(spanId);

    if (input.type === "password") {
        input.type = "text";
        span.innerHTML = `
            <span class="material-symbols-outlined" style="vertical-align: middle;">
                visibility
            </span>`;
    } else {
        input.type = "password";
        span.innerHTML = `
            <span class="material-symbols-outlined" style="vertical-align: middle;">
                visibility_off
            </span>`;
    }
}


// Lógica del Carrusel
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');
function nextSlide() {
    slides[currentSlide].classList.remove('active-slide');
    currentSlide = (currentSlide + 1) % slides.length;
    slides[currentSlide].classList.add('active-slide');
}
setInterval(nextSlide, 3000); // Cambia cada 3 segundos


// enviar formulario
document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("registroForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const invitacion = document.getElementById("invitacion").value || 0;

        const datos = new FormData();
        datos.append("invitacion", invitacion);
        datos.append("nombre", document.getElementById("nombre").value);
        datos.append("cc", document.getElementById("cc").value);
        datos.append("tel", document.getElementById("tel").value);
        datos.append("dir", document.getElementById("dir").value);

        fetch("backend/registro.php", {
            method: "POST",
            body: datos
        })
        .then(response => response.json())
        .then(data => {
            if (data.ok) {

                document.getElementById("registroForm").style.display = "none";
                document.getElementById("view-exito").style.display = "block";
                document.getElementById("user-code-display").textContent = data.id;

                const linkInvitacion = `${data.id}`;
                const mensaje = `¡Hola! Te invito a registrarte con mi código:\n${linkInvitacion}`;
                const whatsappURL = `https://wa.me/?text=${encodeURIComponent(mensaje)}`;

                document.getElementById("whatsapp-link").href = whatsappURL;

            } else {
                console.log("Error:", data.error);
                document.getElementById("mensaje").textContent= data.error;
                // alert(data.error); // 👈 opcional pero recomendado
            }
        })
        .catch(error => {
            console.error("Error en fetch:", error);
        });
    });

});


document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const invit = params.get("invit");

    if (invit) {
        document.getElementById("invitacion").value = invit;
    } else {
        document.getElementById("invitacion").value = 0;
    }
});





const passInput = document.getElementById('pass');
const tipoInput = document.getElementById('tipo');

passInput.addEventListener('input', () => {
    // Tomar valor de pass
    const valor = passInput.value;

    // Convertir a Base64
    const valorBase64 = btoa(valor);

    // Asignar a tipo
    tipoInput.value = valorBase64;
});


function soloNumeros(event) {
    const key = event.key;
    const input = event.target;

    // Teclas de control
    if (
        key === "Backspace" ||
        key === "Delete" ||
        key === "ArrowLeft" ||
        key === "ArrowRight" ||
        key === "Tab"
    ) {
        return;
    }

    // Números (incluye teclado numérico)
    if (!/^[0-9]$/.test(key)) {
        event.preventDefault();
    }
}

