document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.contact-form');
    const nombreInput = document.getElementById('nombre');
    const correoInput = document.getElementById('correo');
    const consultaInput = document.getElementById('consulta');
    const submitBtn = document.querySelector('.submit-btn');

    // Función para crear mensaje de error
    function createErrorMessage(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        return errorDiv;
    }

    // Función para mostrar error
    function showError(input, message) {
        const formGroup = input.parentElement;

        // Remover error anterior si existe
        const existingError = formGroup.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }

        // Agregar clase de error al input
        input.classList.add('error');

        // Crear y agregar mensaje de error
        const errorMessage = createErrorMessage(message);
        formGroup.appendChild(errorMessage);
    }

    // Función para limpiar error
    function clearError(input) {
        const formGroup = input.parentElement;
        const errorMessage = formGroup.querySelector('.error-message');

        if (errorMessage) {
            errorMessage.remove();
        }

        input.classList.remove('error');
        input.classList.add('success');
    }

    // Validación de nombre
    function validateNombre() {
        const nombre = nombreInput.value.trim();

        if (nombre === '') {
            showError(nombreInput, 'El nombre es requerido');
            return false;
        }

        if (nombre.length < 2) {
            showError(nombreInput, 'El nombre debe tener al menos 2 caracteres');
            return false;
        }

        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(nombre)) {
            showError(nombreInput, 'El nombre solo puede contener letras');
            return false;
        }

        clearError(nombreInput);
        return true;
    }

    // Validación de correo
    function validateCorreo() {
        const correo = correoInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (correo === '') {
            showError(correoInput, 'El correo electrónico es requerido');
            return false;
        }

        if (!emailRegex.test(correo)) {
            showError(correoInput, 'Ingresa un correo electrónico válido');
            return false;
        }

        clearError(correoInput);
        return true;
    }

    // Validación de consulta
    function validateConsulta() {
        const consulta = consultaInput.value.trim();

        if (consulta === '') {
            showError(consultaInput, 'La consulta es requerida');
            return false;
        }

        if (consulta.length < 10) {
            showError(consultaInput, 'La consulta debe tener al menos 10 caracteres');
            return false;
        }

        if (consulta.length > 500) {
            showError(consultaInput, 'La consulta no puede exceder 500 caracteres');
            return false;
        }

        clearError(consultaInput);
        return true;
    }

    // Validación completa del formulario
    function validateForm() {
        const isNombreValid = validateNombre();
        const isCorreoValid = validateCorreo();
        const isConsultaValid = validateConsulta();

        return isNombreValid && isCorreoValid && isConsultaValid;
    }

    // Event listeners para validación en tiempo real
    nombreInput.addEventListener('blur', validateNombre);
    nombreInput.addEventListener('input', function() {
        if (this.classList.contains('error')) {
            validateNombre();
        }
    });

    correoInput.addEventListener('blur', validateCorreo);
    correoInput.addEventListener('input', function() {
        if (this.classList.contains('error')) {
            validateCorreo();
        }
    });

    consultaInput.addEventListener('blur', validateConsulta);
    consultaInput.addEventListener('input', function() {
        if (this.classList.contains('error')) {
            validateConsulta();
        }
    });

    // Validación al enviar el formulario
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (validateForm()) {
            // Cambiar texto del botón para indicar envío
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Enviando...';
            submitBtn.disabled = true;

            // Simular envío (aquí puedes agregar la lógica real de envío)
            setTimeout(() => {
                alert('¡Consulta enviada exitosamente! Te contactaremos pronto.');
                form.reset();

                // Limpiar clases de éxito
                document.querySelectorAll('.success').forEach(input => {
                    input.classList.remove('success');
                });

                // Restaurar botón
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 2000);
        } else {
            // Scroll al primer error
            const firstError = document.querySelector('.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });

    // Contador de caracteres para textarea
    const charCounter = document.createElement('div');
    charCounter.className = 'char-counter';
    charCounter.textContent = '0/500';
    consultaInput.parentElement.appendChild(charCounter);

    consultaInput.addEventListener('input', function() {
        const length = this.value.length;
        charCounter.textContent = `${length}/500`;

        if (length > 450) {
            charCounter.classList.add('warning');
        } else {
            charCounter.classList.remove('warning');
        }
    });
});
