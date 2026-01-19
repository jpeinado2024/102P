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

function generarCodigo() {
    return "PL-" + Math.random().toString(36).substr(2, 4).toUpperCase();
}

document.getElementById('registroForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.getElementById('btnSend');
    btn.innerText = "PROCESANDO..."; btn.disabled = true;
    const miCodigo = generarCodigo();
    try {
        await addDoc(collection(db, "registros"), {
            nombre: document.getElementById('nombre').value,
            cc: document.getElementById('cc').value,
            tel: document.getElementById('tel').value,
            dir: document.getElementById('dir').value,
            codigo_personal: miCodigo,
            invitado_por: refCode,
            fecha: serverTimestamp()
        });
        const urlBase = window.location.href.split('?')[0];
        const msg = encodeURIComponent(`¡Hola! Te invito a registrarte en el sondeo oficial 102 PL: ${urlBase}?ref=${miCodigo}`);
        document.getElementById('user-code-display').innerText = miCodigo;
        document.getElementById('whatsapp-link').href = `https://wa.me/?text=${msg}`;
        document.getElementById('view-registro').classList.remove('active');
        document.getElementById('view-exito').classList.add('active');
    } catch (err) { alert("Error: " + err.message); btn.disabled = false; }
});

window.accederAdmin = () => {
    if (prompt("Clave de Seguridad:") === "102PLadmin") {
        document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
        document.getElementById('view-admin').classList.add('active');
        onSnapshot(query(collection(db, "registros"), orderBy("fecha", "desc")), (snap) => {
            const tbody = document.getElementById('admin-table-body');
            tbody.innerHTML = "";
            snap.forEach(doc => {
                const d = doc.data();
                const f = d.fecha ? d.fecha.toDate().toLocaleDateString() : '---';
                tbody.innerHTML += `<tr><td>${f}</td><td><b>${d.nombre}</b></td><td>${d.cc}</td><td>${d.tel}</td><td>${d.dir}</td><td><span class="code-badge">${d.codigo_personal}</span></td><td><span class="ref-badge">${d.invitado_por}</span></td></tr>`;
            });
        });
    }
};

window.exportarExcel = () => {
    const table = document.getElementById("tabla-datos");
    const wb = XLSX.utils.table_to_book(table, { sheet: "REPORTE_102PL" });
    XLSX.writeFile(wb, "Reporte_Sondeo_102PL.xlsx");
};