import $ from 'jquery';

$(document).on('click', '.client-name', function() {
    const row = $(this).closest('tr');
    const clientId = row.data('id');
    const existingRow = $(`.cars-row[data-client="${clientId}"]`);

    if (existingRow.length) {
        existingRow.remove();
        return;
    }

    $.get(`/clients/${clientId}/cars`, function(html) {
        row.after(`
            <tr class="cars-row" data-client="${clientId}">
                <td colspan="3">${html}</td>
            </tr>
        `);
    });
});

$(document).on('click', '.car-id', function() {
    const carId = $(this).data('id');
    const row = $(this).closest('tr');
    const existingRow = $(`.services-row[data-car="${carId}"]`);

    if (existingRow.length) {
        existingRow.remove();
        return;
    }

    $.get(`/cars/${carId}/services`, function(html) {
        row.after(`
            <tr class="services-row" data-car="${carId}">
                <td colspan="7">${html}</td>
            </tr>
        `);
    });
});