const mexicoCityTimeZone = 'America/Mexico_City';
const fecha_actual = new Date().toLocaleString('es-MX', { timeZone: mexicoCityTimeZone });

var user = document.getElementById('usuario').innerHTML;
document.getElementById('pdf_turno').addEventListener('click', function() {
    const doc = new window.jspdf.jsPDF(); // Accede a jsPDF a través del objeto window
    const table = document.getElementById('datos_reporte');
    doc.autoTable({ html: table });
    doc.save(user+" "+fecha_actual);
});