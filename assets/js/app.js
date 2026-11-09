document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!confirm(form.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });

    document.querySelectorAll('input[maxlength]').forEach((input) => {
        input.addEventListener('input', () => {
            input.setCustomValidity(
                input.value.length > Number(input.maxLength) ? 'Terlalu panjang.' : ''
            );
        });
    });
});
