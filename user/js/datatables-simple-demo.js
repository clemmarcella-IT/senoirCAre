window.addEventListener('DOMContentLoaded', event => {
    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple, {
            searchable: true,
            sortable: true,
            paging: true,
            perPage: 10,
            perPageSelect:[5, 10, 15, 25, 50]
        });
    }
});