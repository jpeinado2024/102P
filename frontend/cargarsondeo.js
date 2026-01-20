// const Personal = async () => {

//     const tbody = document.getElementById("admin-table-body");

//     try {
//         const response = await fetch("backend/json.php?action=listar_registros");

//         // Leemos como texto para detectar HTML
//         const text = await response.text();

//         console.log("RESPUESTA CRUDA DEL SERVIDOR:", text);

//         if (text.startsWith("<")) {
//             throw new Error("El servidor devolvió HTML en lugar de JSON");
//         }

//         const json = JSON.parse(text);

//         // Validación básica
//         if (!json.ok || !Array.isArray(json.data)) {
//             throw new Error("Formato de respuesta inválido");
//         }

//         const datos = json.data;
//         console.log("Datos recibidos:", datos);
//         // Limpiar tabla
//         tbody.innerHTML = "";

//         if (datos.length === 0) {
//             tbody.innerHTML = `
//                 <tr>
//                     <td colspan="7" style="text-align:center;">
//                         No hay registros disponibles
//                     </td>
//                 </tr>
//             `;
//             return;
//         }

//         datos.forEach(item => {

//             const fila = document.createElement("tr");

//             fila.innerHTML = `
//                 <td>${item.fecha ?? "-"}</td>
//                 <td>${item.nombre ?? "-"}</td>
//                 <td>${item.documento ?? "-"}</td>
//                 <td>${item.telefono ?? "-"}</td>
//                 <td>${item.direccion ?? "-"}</td>
//                 <td>
//     <button 
//         type="button"
//         class="ingresar2"
//         onclick="cargarModal('${btoa(item.id)}')"
//         data-toggle="modal"
//         data-target="#exampleModal">
//         ${btoa(item.id)}
//     </button>
// </td>

//             `;

//             tbody.appendChild(fila);
//         });

//     } catch (error) {
//         console.error("Error al cargar la tabla:", error);
//         tbody.innerHTML = `
//             <tr>
//                 <td colspan="7" style="text-align:center;color:red;">
//                     Error al cargar los datos
//                 </td>
//             </tr>
//         `;
//     }
// };


async function cargarModal(idBase64) {

    // 1️⃣ Decodificar el ID
    const id = atob(idBase64);

    try {
        // 2️⃣ Llamar al backend
        const response = await fetch("backend/arbol.php?id=" + id);

        const text = await response.text();

        // 3️⃣ Validar que NO venga HTML
        if (text.startsWith("<")) {
            console.error("HTML recibido:", text);
            throw new Error("El servidor no devolvió JSON");
        }

        // 4️⃣ Convertir a JSON
        const json = JSON.parse(text);

        // 5️⃣ Validar respuesta
        if (!json.ok) {
            alert(json.error || "Error al obtener la información");
            return;
        }

        // =========================
        // 6️⃣ LLENAR EL MODAL
        // =========================

        // Título del modal
        document.getElementById("exampleModalLabel").innerText =
            "Ingreso del administrador - " + json.usuario.nombre;

        // Datos del usuario
        document.getElementById("modal-nombre").textContent = json.usuario.nombre;
        document.getElementById("modal-documento").textContent = json.usuario.documento;

        // =========================
        // 7️⃣ INVITADOS
        // =========================
        const tbody = document.getElementById("modal-invitados");
        tbody.innerHTML = "";

        if (!json.invitados || json.invitados.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center">
                        No tiene invitados
                    </td>
                </tr>
            `;
        } else {
            let id = 1;
            json.invitados.forEach(inv => {
                tbody.innerHTML += `
        <tr>
            <td>${id++}</td>
            <td>${inv.nombre}</td>
            <td>${inv.documento}</td>
        </tr>
    `;
            });

        }

    } catch (error) {
        console.error("Error en cargarModal:", error);
        alert("No se pudieron cargar los datos del registro");
    }
}

async function exportarExcel() {
    try {
        const response = await fetch("backend/excel.php?action=excel_registros");
        const text = await response.text();

        if (text.startsWith("<")) {
            console.error("HTML recibido:", text);
            alert("Error al generar el Excel");
            return;
        }

        const json = JSON.parse(text);

        if (!json.ok || !json.data || json.data.length === 0) {
            alert("No hay datos para exportar");
            return;
        }

        const data = json.data;

        // 1️⃣ Crear hoja
        const worksheet = XLSX.utils.json_to_sheet(data);

        // 2️⃣ Activar AUTOFILTRO (🔥 aquí está la magia)
        const rango = XLSX.utils.decode_range(worksheet["!ref"]);
        worksheet["!autofilter"] = {
            ref: XLSX.utils.encode_range(rango)
        };

        // 3️⃣ Crear libro
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Registros");

        // 4️⃣ Descargar
        XLSX.writeFile(workbook, "registros_sondeo.xlsx");

    } catch (error) {
        console.error("Error exportando Excel:", error);
        alert("Error al exportar Excel");
    }
}
// function filtrarPorCedula() {
//     const input = document.getElementById("buscarCedula");
//     const filtro = input.value.toLowerCase();

//     const filas = document.querySelectorAll("#admin-table-body tr");

//     filas.forEach(fila => {
//         const celdaCedula = fila.children[2]; // columna Cédula

//         if (!celdaCedula) return;

//         const texto = celdaCedula.textContent.toLowerCase();

//         // Mostrar u ocultar fila
//         fila.style.display = texto.includes(filtro) ? "" : "none";
//     });
// }
