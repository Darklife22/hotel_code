document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', (event) => {
            const inputs = form.querySelectorAll('input, textarea');
            let valid = true;

            inputs.forEach(input => {
                if (input.value.trim() === '') {
                    valid = false;
                    input.style.borderColor = 'red';
                } else {
                    input.style.borderColor = '#ccc';
                }
            });

            if (!valid) {
                event.preventDefault();
                alert('Por favor complete todos los campos.');
            }
        });
    });
});