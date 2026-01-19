window.exportarExcel = () => {
    const table = document.getElementById("tabla-datos");
    const wb = XLSX.utils.table_to_book(table, { sheet: "REPORTE_102PL" });
    XLSX.writeFile(wb, "Reporte_Sondeo_102PL.xlsx");
};