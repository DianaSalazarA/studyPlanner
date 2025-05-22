document.addEventListener('DOMContentLoaded', function () {
    // Este código se activa apenas la página está lista así nos aseguramos de que todo el calendario y los botoncitos estén ahí antes de empezar a utilizarlos

    // configuración del FullCalendar

    // buscamos el lugar en nuestro html donde queremos que aparezca el calendario
    let calendarEl = document.getElementById('calendario');

    // aqui creamos nuestro calendario damos las indicaciones de como se vera y que puede hacer.
    let calendar = new FullCalendar.Calendar(calendarEl, {
        // vista de todo el mes en español
        initialView: 'dayGridMonth',
        locale: 'es',

        // esto es para la parte de arriba del calendario donde están los botones
        headerToolbar: {
            // a la izquierda: los botones para ir al mes anterior y volver a hoy
            left: 'prev,next today',
            // en el centro: el nombre del mes en el que estamos.
            center: 'title',
            // a la derecha: los botones para cambiar entre la vista de mes o semana 
            right: 'dayGridMonth,timeGridWeek,timeGridDay' // Agregué 'timeGridDay' ya que estaba en el código original.
        },
        // esto permite que podamos mover las tareas de un dia a otro o cambiarles la duracion.
        editable: true,
        // con esto podemos seleccionar un rango de dias para crear una tarea que dure varios dias.
        selectable: true,

        // decimos de dónde va a sacar el calendario todas nuestras tareas.
        events: {
            // direccion a donde vamos a buscar la informacion de las tareas. (controlador.php queremos leer lo que hay)
            url: '../backend/controlador.php?accion=leer',
            // usamos el metodo GET para pedir la info
            method: 'GET',
            // si algo sale mal mostramos un mensajito de error.
            failure: function() {
                showToast('¡Ups! Hubo un problema al cargar tus tareas. 😟', 'error');
            }
        },
        // hace que los eventos se vean como bloques para personalizarlos.
        eventDisplay: 'block',
        // es como se va a ver la hora en los eventos..
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false
        },

        // --- acciones del calendario ---

        // cuando hacemos clic en un día (no en una tarea)
        dateClick: function (info) {
            resetModal(); // limpiamos el formulario del modal
            $('#crearTareaModal').data('fecha', info.dateStr); // guardamos la fecha en el modal
            $('#crearTareaModal').modal('show'); // mostramos el modal para crear tarea
        },
        // si arrastramos una tarea a otro día
        eventDrop: function (info) {
            updateTask(info.event); // actualizamos la tarea en la base de datos
        },
        // si cambiamos la duración de una tarea (la hacemos más larga o más corta)
        eventResize: function(info) {
            updateTask(info.event); // actualizamos la tarea
        },
        // cuando hacemos clic en una tarea
        eventClick: function (info) {
            info.jsEvent.preventDefault(); // evitamos que el navegador haga algo por defecto (como seleccionar texto)
        },
        // esto se ejecuta después de que el calendario dibuja cada evento
        eventDidMount: function(info) {
            // si el evento tiene un color, se lo ponemos
            if (info.event.extendedProps.color) {
                info.el.style.backgroundColor = info.event.extendedProps.color;
                info.el.style.borderColor = info.event.extendedProps.color;

                // ajustamos el color del texto para que se vea bien con el color de fondo
                const rgb = hexToRgb(info.event.extendedProps.color);
                if (rgb && (rgb.r * 0.299 + rgb.g * 0.587 + rgb.b * 0.114) > 150) {
                    info.el.style.color = '#000000'; // texto negro para colores claros
                } else {
                    info.el.style.color = '#ffffff'; // texto blanco para colores oscuros
                }
            }

            // --- creamos un menú de opciones para cada tarea (editar/eliminar) ---
            // esos tres puntitos discretos que aparecen en cada evento

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

            // agregamos este menú al evento en el calendario
            info.el.querySelector('.fc-event-main').appendChild(optionsContainer);

            const dots = optionsContainer.querySelector('.event-options-dots');
            const menu = optionsContainer.querySelector('.event-options-menu');

            // si haces clic en los tres puntitos, el menú aparece o desaparece
            dots.addEventListener('click', function(e) {
                e.stopPropagation(); // para que no se active el click de FullCalendar al mismo tiempo
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block'; // cambia la visibilidad del menú
            });

            // si haces clic en "Editar" o "Eliminar" en el menú
            menu.querySelectorAll('.event-option').forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation(); // para que no haga cosas raras
                    const action = this.getAttribute('data-action'); // obtenemos la acción (editar o eliminar)
                    const eventId = this.getAttribute('data-event-id'); // el ID de la tarea
                    const event = calendar.getEventById(eventId); // obtenemos la tarea completa

                    if (action === 'delete') {
                        deleteEvent(event); // llamamos a la función para eliminar
                    } else if (action === 'edit') {
                        editEvent(event); // llamamos a la función para editar
                    }

                    menu.style.display = 'none'; // ocultamos el menú después de elegir
                });
            });

            // si haces clic en cualquier otro lado de la página, el menú se esconde
            document.addEventListener('click', function() {
                menu.style.display = 'none';
            });

            // --- pop-up con la descripción (tooltip de Bootstrap) ---
            // si la tarea tiene descripción, al pasar el ratón se ve un pop-up con ella.
            if (info.event.extendedProps.description) {
                new bootstrap.Tooltip(info.el, {
                    title: info.event.extendedProps.description, // el contenido del pop-up es la descripción
                    placement: 'top', // el pop-up aparece arriba de la tarea
                    trigger: 'hover', // se activa al pasar el ratón
                    container: 'body' // para que no haya problemas de que se esconda detrás de otras cosas
                });
            }
        },
        aspectRatio: 1.5 // relación de aspecto del calendario
    });

    // finalmente, dibujamos el calendario en la página
    calendar.render();

    // --- manejo de la selección de colores en el modal ---

    // cuando clickeamos en un colorcito
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', function() {
            // quitamos la selección de todos los otros colores y escondemos su "palomita"
            document.querySelectorAll('.color-option').forEach(el => {
                el.classList.remove('selected');
                if (el.querySelector('i')) {
                    el.querySelector('i').style.display = 'none';
                }
            });
            // marcamos el color que acabamos de clickear como seleccionado
            this.classList.add('selected');
            // y mostramos su "palomita"
            if (this.querySelector('i')) {
                this.querySelector('i').style.display = 'block';
            }
            // guardamos el color elegido en un campo oculto
            document.getElementById('colorTarea').value = this.dataset.color;
        });
    });

    // --- lógica para guardar/actualizar tarea ---

    // cuando hacemos clic en el botón de "guardar" o "añadir" en el modal
    document.getElementById('guardarTarea').addEventListener('click', function() {
        // obtenemos los valores de los campos del formulario, quitando espacios extra
        const titulo = document.getElementById('tituloTarea').value.trim();
        const descripcion = document.getElementById('descripcionTarea').value.trim();
        const color = document.getElementById('colorTarea').value;
        // vemos si estamos editando una tarea existente o creando una nueva
        const eventId = $('#crearTareaModal').data('event-id');

        // validación: el título es obligatorio
        if (!titulo) {
            showToast('¡El título es obligatorio, no te olvides! 😅', 'error');
            return; // no seguimos si no hay título
        }

        // si hay un 'eventId', significa que estamos EDITANDO una tarea
        if (eventId) {
            // --- lógica para actualizar un evento existente ---
            const event = calendar.getEventById(eventId); // obtenemos la tarea original
            const fecha = event.start.toISOString().split('T')[0]; // sacamos solo la fecha

            // hacemos una petición al servidor para que actualice la tarea
            $.ajax({
                url: '../backend/controlador.php', // a dónde enviamos la información
                method: 'POST', // cómo la enviamos
                data: { // los datos que enviamos:
                    accion: 'actualizar', // le decimos que queremos actualizar
                    id: eventId,
                    titulo: titulo,
                    descripcion: descripcion,
                    color: color,
                    inicio: fecha + 'T00:00:00', // ponemos la hora al inicio del día
                    fin: fecha + 'T23:59:59' // y al final del día
                },
                success: function(response) { // si todo salió bien
                    if (response.status === 'ok') {
                        calendar.refetchEvents(); // recargamos el calendario para que se vean los cambios
                        $('#crearTareaModal').modal('hide'); // cerramos la ventanita
                        showToast('¡Tarea actualizada con éxito! 🎉', 'success'); // mensaje de éxito
                    } else {
                        showToast(response.mensaje || '¡Algo salió mal al actualizar! 😩', 'error'); // mensaje de error del servidor
                    }
                },
                error: function() { // si no pudimos ni siquiera hablar con el servidor
                    showToast('¡Problemas de conexión con el servidor! 😱', 'error'); // mensaje de error de conexión
                }
            });
        } else {
            // --- lógica para crear un nuevo evento ---
            const fecha = $('#crearTareaModal').data('fecha'); // la fecha que clickeamos en el calendario

            // hacemos una petición al servidor para que cree la nueva tarea
            $.ajax({
                url: '../backend/controlador.php',
                method: 'POST',
                data: {
                    accion: 'crear', // le decimos que queremos crear
                    titulo: titulo,
                    descripcion: descripcion,
                    color: color,
                    inicio: fecha + 'T00:00:00',
                    fin: fecha + 'T23:59:59'
                },
                success: function(response) {
                    if (response.status === 'ok') {
                        calendar.refetchEvents(); // recargamos para ver la tarea nueva
                        $('#crearTareaModal').modal('hide'); // cerramos la ventanita
                        showToast('¡Nueva tarea creada! ¡Yeii! ✨', 'success');
                    } else {
                        showToast(response.mensaje || '¡No pude crear la tarea! 💔', 'error');
                    }
                },
                error: function() {
                    showToast('¡No hay internet para crear la tarea! 😫', 'error');
                }
            });
        }
    });

    // --- funciones auxiliares ---

    // función para actualizar una tarea existente (cuando la movemos o cambiamos su tamaño)
    function updateTask(event) {
        $.ajax({
            url: '../backend/controlador.php',
            method: 'POST',
            data: {
                accion: 'actualizar',
                id: event.id,
                inicio: event.start.toISOString(), // la fecha y hora de inicio en un formato estándar
                fin: event.end ? event.end.toISOString() : event.start.toISOString() // la fecha y hora de fin
            },
            success: function(response) {
                if (response.status === 'ok') {
                    showToast('¡Tarea actualizada al moverla! 😊', 'success');
                } else {
                    calendar.refetchEvents(); // si hay error, volvemos a cargar para que no se vea el cambio visual
                    showToast(response.mensaje || '¡Error al mover la tarea! 😬', 'error');
                }
            },
            error: function() {
                calendar.refetchEvents(); // si no hay conexión, también recargamos
                showToast('¡Problemas de conexión! 😵', 'error');
            }
        });
    }

    // función para eliminar una tarea (con confirmación)
    function deleteEvent(event) {
        // --- creamos una ventanita de confirmación para eliminar ---
        const modalHtml = `
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">¿Segura que quieres eliminar esto? 🤔</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estás segura de que deseas eliminar la tarea "${event.title}"? ¡No hay vuelta atrás! 😱
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">¡Sí, eliminar! 🗑️</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // agregamos esta ventanita a nuestra página
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        // y la mostramos
        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();

        // cuando hacemos clic en el botón de "Eliminar" en la ventanita de confirmación
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            // hacemos una petición al servidor para que la borre de verdad
            $.ajax({
                url: '../backend/controlador.php',
                method: 'POST',
                data: {
                    accion: 'eliminar',
                    id: event.id
                },
                success: function(response) {
                    if (response.status === 'ok') {
                        event.remove(); // la quitamos visualmente del calendario
                        showToast('¡Tarea eliminada! 👋', 'success');
                    } else {
                        showToast(response.mensaje || '¡No pude eliminarla! 🙁', 'error');
                    }
                },
                error: function() {
                    showToast('¡No puedo conectarme para eliminarla! 😤', 'error');
                },
                complete: function() { // esto pasa siempre, pase lo que pase con la petición
                    modal.hide(); // cerramos la ventanita de confirmación
                    document.getElementById('confirmDeleteModal').remove(); // y la borramos de la página
                }
            });
        });

        // cuando la ventanita se cierra (no importa cómo), también la borramos de la página
        document.getElementById('confirmDeleteModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
        });
    }

    // función para precargar los datos de la tarea en el modal cuando la queremos editar
    function editEvent(event) {
        document.getElementById('tituloTarea').value = event.title; // ponemos el título
        document.getElementById('descripcionTarea').value = event.extendedProps.description || ''; // la descripción (si tiene)

        // seleccionamos el color correcto en el modal
        if (event.extendedProps.color) {
            document.getElementById('colorTarea').value = event.extendedProps.color;
            document.querySelectorAll('.color-option').forEach(el => {
                el.classList.remove('selected'); // quitamos las selecciones viejas
                // escondemos los checks
                if (el.querySelector('i')) {
                    el.querySelector('i').style.display = 'none';
                }
                
                // si el color de la opción es el mismo que el de la tarea, lo seleccionamos
                if (el.dataset.color === event.extendedProps.color) {
                    el.classList.add('selected');
                    if (el.querySelector('i')) {
                        el.querySelector('i').style.display = 'block'; // y mostramos su check
                    }
                }
            });
        }

        $('#crearTareaModal').data('event-id', event.id); // guardamos el ID de la tarea que estamos editando
        document.getElementById('guardarTarea').innerHTML = '<i class="fas fa-save me-2"></i> Guardar'; // cambiamos el texto del botón a "Guardar"
        $('#crearTareaModal').modal('show'); // abrimos la ventanita para editar
    }

    // función para dejar el formulario del modal como nuevo, listo para una tarea nueva
    function resetModal() {
        document.getElementById('tituloTarea').value = ''; // vacío el título
        document.getElementById('descripcionTarea').value = ''; // vacía la descripción
        document.getElementById('colorTarea').value = '#a7f3d0'; // ponemos el color por defecto (ese verdecito bonito)

        // deseleccionamos todos los colores
        document.querySelectorAll('.color-option').forEach(el => {
            el.classList.remove('selected');
            if (el.querySelector('i')) {
                el.querySelector('i').style.display = 'none';
            }
        });
        // y seleccionamos el color por defecto
        document.querySelector('.color-option').classList.add('selected');
        if (document.querySelector('.color-option i')) {
            document.querySelector('.color-option i').style.display = 'block';
        }
        
        $('#crearTareaModal').data('event-id', null); // quitamos el ID de la tarea, ¡ahora estamos creando una nueva!
        document.getElementById('guardarTarea').innerHTML = '<i class="fas fa-plus me-2"></i> Añadir'; // el botón vuelve a decir "Añadir"
    }

    // función para mostrar esos mensajitos que aparecen abajo a la derecha, como notificaciones
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        // le ponemos clases para que se vea bonito (Bootstrap) y se quede fijo en la pantalla
        toast.className = `toast show align-items-center text-white bg-${type}`;
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.zIndex = '9999'; // para que siempre esté encima de todo

        const toastBody = document.createElement('div');
        toastBody.className = 'd-flex';

        const toastContent = document.createElement('div');
        toastContent.className = 'toast-body';
        toastContent.textContent = message; // el mensaje que queremos mostrar

        const closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.className = 'btn-close btn-close-white me-2 m-auto';
        closeBtn.setAttribute('data-bs-dismiss', 'toast'); // para que se pueda cerrar con Bootstrap
        closeBtn.setAttribute('aria-label', 'Close');

        toastBody.appendChild(toastContent);
        toastBody.appendChild(closeBtn);
        toast.appendChild(toastBody);

        document.body.appendChild(toast); // lo agregamos a la página

        // y lo hacemos desaparecer solito después de 3 segundos
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // pequeña función para convertir colores de hexadecimal a RGB (necesaria para lo de cambiar el color del texto)
    function hexToRgb(hex) {
        hex = hex.replace('#', ''); // quitamos el # si lo tiene

        // convertimos las partes del color
        const r = parseInt(hex.substring(0, 2), 16);
        const g = parseInt(hex.substring(2, 4), 16);
        const b = parseInt(hex.substring(4, 6), 16);

        return { r, g, b }; // devolvemos los valores R, G, B
    }

}); 