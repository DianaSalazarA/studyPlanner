// Script básico para la funcionalidad de selección de color (opcional)
document.querySelectorAll('.color-swatch').forEach(swatch => {
    swatch.addEventListener('click', function() {
        document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('selected'));
        this.classList.add('selected');
    });
});

// Script básico para la funcionalidad de selección de día del calendario (opcional)
document.querySelectorAll('.calendar-day').forEach(day => {
    day.addEventListener('click', function() {
        document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('active'));
        if (!this.classList.contains("")) { // Evitar seleccionar los días vacíos
            this.classList.add('active');
        }
    });
});