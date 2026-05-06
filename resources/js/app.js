import 'flowbite';

document.addEventListener('DOMContentLoaded', () => {
    const selectAll = document.querySelector('[data-select-all]');
    const checkboxes = Array.from(document.querySelectorAll('input[name="link_ids[]"]'));

    if (selectAll && checkboxes.length > 0) {
        selectAll.addEventListener('change', () => {
            const checked = selectAll.checked === true;
            for (const cb of checkboxes) {
                cb.checked = checked;
            }
        });
    }
});
