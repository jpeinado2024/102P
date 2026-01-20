let datat = null;
let inicio = false;

const dataopciones = {
    order: [],
    lengthMenu: [50, 100, 150, 200, 250],
    pageLength: 50,
    destroy: true,
    searching: true,
    language: {
        lengthMenu: "Mostrar _MENU_ registros por página",
        zeroRecords: "Ningún registro encontrado",
        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
        infoEmpty: "Sin registros",
        infoFiltered: "(filtrado de _MAX_ registros)",
        search: "Buscar:",
        loadingRecords: "Cargando...",
        paginate: {
            next: "Siguiente",
            previous: "Anterior"
        }
    }
};

const iniciodatatable = async () => {
    if (inicio) {
        datat.destroy();
    }

    await cargarUsuarios();

    datat = $("#Tabla_usarios").DataTable(dataopciones);
    inicio = true;
};

const cargarUsuarios = async () => {
    const tbody = document.getElementById("admin-table-body");
    tbody.innerHTML = "";

    try {
        const response = await fetch("backend/json.php?action=listar_registros");
        const json = await response.json();
        console.log(json);
        if (!json.ok || !Array.isArray(json.data)) {
            throw new Error("Respuesta inválida");
        }

        json.data.forEach(item => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${item.fecha ?? "-"}</td>
                <td>${item.nombre ?? "-"}</td>
                <td>${item.documento ?? "-"}</td>
                <td>${item.telefono ?? "-"}</td>
                <td>${item.direccion ?? "-"}</td>
                <td>
                    <button class="btn-primary"
                        onclick="cargarModal('${btoa(item.id)}')"
                        data-toggle="modal"
                        data-target="#exampleModal">
                        ${btoa(item.id)}
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

    } catch (error) {
        console.error(error);
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-danger">
                    Error al cargar datos
                </td>
            </tr>
        `;
    }
};

window.addEventListener("load", iniciodatatable);
