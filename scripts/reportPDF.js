const mexicoCityTimeZone = 'America/Mexico_City';
const fecha_actual = new Date().toLocaleString('es-MX', { timeZone: mexicoCityTimeZone });

var user = document.getElementById('usuario').innerHTML;
var corte = document.getElementById('p_corte').value;
var regist = document.getElementById('p_regis').value;
document.getElementById('formturno').addEventListener('submit', function() {
    if(corte>0){
        const doc = new window.jspdf.jsPDF(); // Accede a jsPDF a través del objeto window
    const table = document.getElementById('datos_reporte');

    // Obtén el contenido de la tabla
    const tableData = [];
    const tableHeader = [];
    const tableBody = [];

    // Itera sobre las filas de la tabla y llena 'tableData'
    for (let i = 0; i < table.rows.length; i++) {
        const rowData = [];
        const row = table.rows[i];

        // Itera sobre las celdas de la fila y llena 'rowData'
        for (let j = 0; j < row.cells.length; j++) {
            if (i === 0) {
                // Si es la primera fila, llena 'tableHeader'
                tableHeader.push(row.cells[j].innerText);
            } else {
                // Si no es la primera fila, llena 'rowData'
                rowData.push(row.cells[j].innerText);
            }
        }

        // Si no es la primera fila, agrega 'rowData' a 'tableBody'
        if (i !== 0) {
            tableBody.push(rowData);
        }
    }

    // Utiliza 'tableHeader' y 'tableBody' en la llamada a 'autoTable'
    doc.autoTable({
        headStyles: { fontStyle: 'bold', fontSize: 12, textColor: [0, 0, 0] },
        head: [tableHeader],
        body: tableBody,
        theme: 'grid',
        didDrawPage: function(data) {
            doc.text(user, 14, 10);
        },
        
    });
    doc.text("Corte: $"+corte+"\n"+"Registros: "+regist+"\n", 14, doc.autoTable.previous.finalY + 10);

    doc.save(user + " " + fecha_actual+".pdf");

    }
});