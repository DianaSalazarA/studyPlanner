document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendario');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        editable: true,
        selectable: true,
        events: {
            url: 'backend/controlador.php?accion=leer',
            method: 'GET',
            failure: function() {
                showToast('Error al cargar las tareas', 'error');
            }
        },
        eventDisplay: 'block',
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false
        },
        dateClick: function (info) {
            resetModal();
            $('#crearTareaModal').data('fecha', info.dateStr);
            $('#crearTareaModal').modal('show');
        },
        eventDrop: function (info) {
            updateTask(info.event);
        },
        eventResize: function(info) {
            updateTask(info.event);
        },
        eventClick: function (info) {
            info.jsEvent.preventDefault();
        },
        eventDidMount: function(info) {
            // Aplicar el color del evento
            if (info.event.extendedProps.color) {
                info.el.style.backgroundColor = info.event.extendedProps.color;
                info.el.style.borderColor = info.event.extendedProps.color;
                
                // Ajustar el color del texto según el fondo
                const rgb = hexToRgb(info.event.extendedProps.color);
                if (rgb && (rgb.r * 0.299 + rgb.g * 0.587 + rgb.b * 0.114) > 150) {
                    info.el.style.color = '#000000';
                } else {
                    info.el.style.color = '#ffffff';
                }
            }
            
            // Crear contenedor de opciones
            const optionsContainer = document.createElement('div');
            optionsContainer.className = 'event-options';
            optionsContainer.innerHTML = `
                <div class="event-options-dots">⋯</div>
                <div class="event-options-menu">
                    <div class="event-option" data-action="edit" data-event-id="${info.event.id}">
                        <i class="fas fa-edit"></i> Editar
                    </div>
                    <div class="event-option" data-action="delete" data-event-id="${info.event.id}">
                        <i class="fas fa-trash"></i> Eliminar
                    </div>
                </div>
            `;
            
            info.el.querySelector('.fc-event-main').appendChild(optionsContainer);
            
            // Manejar clic en los tres puntos
            const dots = optionsContainer.querySelector('.event-options-dots');
            const menu = optionsContainer.querySelector('.event-options-menu');
            
            dots.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            });
            
            // Manejar clic en las opciones
            menu.querySelectorAll('.event-option').forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const action = this.getAttribute('data-action');
                    const eventId = this.getAttribute('data-event-id');
                    const event = calendar.getEventById(eventId);
                    
                    if (action === 'delete') {
                        deleteEvent(event);
                    } else if (action === 'edit') {
                        editEvent(event);
                    }
                    
                    menu.style.display = 'none';
                });
            });
            
            // Cerrar menú al hacer clic fuera
            document.addEventListener('click', function() {
                menu.style.display = 'none';
            });
            
            // Mostrar tooltip con la descripción
            if (info.event.extendedProps.description) {
                new bootstrap.Tooltip(info.el, {
                    title: info.event.extendedProps.description,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
            }
        },
        aspectRatio: 1.5
    });
    calendar.render();

    // Manejar selección de colores
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.color-option').forEach(el => {
                el.classList.remove('selected');
                el.querySelector('i').style.display = 'none';
            });
            this.classList.add('selected');
            this.querySelector('i').style.display = 'block';
            document.getElementById('colorTarea').value = this.dataset.color;
        });
    });

    // Guardar tarea
    document.getElementById('guardarTarea').addEventListener('click', function() {
        const titulo = document.getElementById('tituloTarea').value.trim();
        const descripcion = document.getElementById('descripcionTarea').value.trim();
        const color = document.getElementById('colorTarea').value;
        const eventId = $('#crearTareaModal').data('event-id');
        
        if (!titulo) {
            showToast('El título es obligatorio', 'error');
            return;
        }

        if (eventId) {
            // Actualizar evento existente
            const event = calendar.getEventById(eventId);
            const fecha = event.start.toISOString().split('T')[0];
            
            $.ajax({
                url: 'backend/controlador.php',
                method: 'POST',
                data: {
                    accion: 'actualizar',
                    id: eventId,
                    titulo: titulo,
                    descripcion: descripcion,
                    color: color,
                    inicio: fecha + 'T00:00:00',
                    fin: fecha + 'T23:59:59'
                },
                success: function(response) {
                    if (response.status === 'ok') {
                        calendar.refetchEvents();
                        $('#crearTareaModal').modal('hide');
                        showToast('Tarea actualizada', 'success');
                    } else {
                        showToast(response.mensaje || 'Error al actualizar', 'error');
                    }
                },
                error: function() {
                    showToast('Error de conexión', 'error');
                }
            });
        } else {
            // Crear nuevo evento
            const fecha = $('#crearTareaModal').data('fecha');
            
            $.ajax({
                url: 'backend/controlador.php',
                method: 'POST',
                data: {
                    accion: 'crear',
                    titulo: titulo,
                    descripcion: descripcion,
                    color: color,
                    inicio: fecha + 'T00:00:00',
                    fin: fecha + 'T23:59:59'
                },
                success: function(response) {
                    if (response.status === 'ok') {
                        calendar.refetchEvents();
                        $('#crearTareaModal').modal('hide');
                        showToast('Tarea creada', 'success');
                    } else {
                        showToast(response.mensaje || 'Error al crear', 'error');
                    }
                },
                error: function() {
                    showToast('Error de conexión', 'error');
                }
            });
        }
    });

    function updateTask(event) {
        $.ajax({
            url: 'backend/controlador.php',
            method: 'POST',
            data: {
                accion: 'actualizar',
                id: event.id,
                inicio: event.start.toISOString(),
                fin: event.end ? event.end.toISOString() : event.start.toISOString()
            },
            success: function(response) {
                if (response.status === 'ok') {
                    showToast('Tarea actualizada', 'success');
                } else {
                    calendar.refetchEvents();
                    showToast(response.mensaje || 'Error al actualizar', 'error');
                }
            },
            error: function() {
                calendar.refetchEvents();
                showToast('Error de conexión', 'error');
            }
        });
    }

    function deleteEvent(event) {
        // Crear modal de confirmación
        const modalHtml = `
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">Confirmar eliminación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que deseas eliminar la tarea "${event.title}"?
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Agregar el modal al DOM
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
        
        // Manejar confirmación
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            $.ajax({
                url: 'backend/controlador.php',
                method: 'POST',
                data: {
                    accion: 'eliminar',
                    id: event.id
                },
                success: function(response) {
                    if (response.status === 'ok') {
                        event.remove();
                        showToast('Tarea eliminada', 'success');
                    } else {
                        showToast(response.mensaje || 'Error al eliminar', 'error');
                    }
                },
                error: function() {
                    showToast('Error de conexión', 'error');
                },
                complete: function() {
                    modal.hide();
                    document.getElementById('confirmDeleteModal').remove();
                }
            });
        });
        
        // Eliminar el modal cuando se cierre
        document.getElementById('confirmDeleteModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
        });
    }

    function editEvent(event) {
        document.getElementById('tituloTarea').value = event.title;
        document.getElementById('descripcionTarea').value = event.extendedProps.description || '';
        
        if (event.extendedProps.color) {
            document.getElementById('colorTarea').value = event.extendedProps.color;
            document.querySelectorAll('.color-option').forEach(el => {
                el.classList.remove('selected');
                el.querySelector('i').style.display = 'none';
                if (el.dataset.color === event.extendedProps.color) {
                    el.classList.add('selected');
                    el.querySelector('i').style.display = 'block';
                }
            });
        }
        
        $('#crearTareaModal').data('event-id', event.id);
        document.getElementById('guardarTarea').innerHTML = '<i class="fas fa-save me-2"></i> Guardar';
        $('#crearTareaModal').modal('show');
    }

    function resetModal() {
        document.getElementById('tituloTarea').value = '';
        document.getElementById('descripcionTarea').value = '';
        document.getElementById('colorTarea').value = '#a7f3d0';
        document.querySelectorAll('.color-option').forEach(el => {
            el.classList.remove('selected');
            el.querySelector('i').style.display = 'none';
        });
        document.querySelector('.color-option').classList.add('selected');
        document.querySelector('.color-option i').style.display = 'block';
        $('#crearTareaModal').data('event-id', null);
        document.getElementById('guardarTarea').innerHTML = '<i class="fas fa-plus me-2"></i> Añadir';
    }

    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast show align-items-center text-white bg-${type}`;
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.zIndex = '9999';
        
        const toastBody = document.createElement('div');
        toastBody.className = 'd-flex';
        
        const toastContent = document.createElement('div');
        toastContent.className = 'toast-body';
        toastContent.textContent = message;
        
        const closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.className = 'btn-close btn-close-white me-2 m-auto';
        closeBtn.setAttribute('data-bs-dismiss', 'toast');
        closeBtn.setAttribute('aria-label', 'Close');
        
        toastBody.appendChild(toastContent);
        toastBody.appendChild(closeBtn);
        toast.appendChild(toastBody);
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    function hexToRgb(hex) {
        hex = hex.replace('#', '');
        
        const r = parseInt(hex.substring(0, 2), 16);
        const g = parseInt(hex.substring(2, 4), 16);
        const b = parseInt(hex.substring(4, 6), 16);
        
        return { r, g, b };
    }
});

