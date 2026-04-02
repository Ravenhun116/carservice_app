import $ from 'jquery';

$('#search-form').on('submit', function(e) {
    e.preventDefault();

    $('#search-error').hide().text('');
    $('#search-result').hide();

    const name = $('input[name="name"]').val().trim();
    const cardNumber = $('input[name="card_number"]').val().trim();

    // Kliens oldali validáció
    if (!name && !cardNumber) {
        $('#search-error').text('Legalább az egyik mezőt töltse ki!').show();
        return;
    }

    if (name && cardNumber) {
        $('#search-error').text('Csak az egyik mezőt töltse ki!').show();
        return;
    }

    if (cardNumber && !/^[a-zA-Z0-9]+$/.test(cardNumber)) {
        $('#search-error').text('Az okmányazonosító csak betűket és számokat tartalmazhat!').show();
        return;
    }

    $.ajax({
        url: '/client/search',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            $('#result-id').text(response.id);
            $('#result-name').text(response.name);
            $('#result-card').text(response.card_number);
            $('#result-cars').text(response.car_count);
            $('#result-services').text(response.service_count);
            $('#search-result').show();
        },
        error: function(xhr) {
            const message = xhr.responseJSON?.error ?? 'Ismeretlen hiba történt!';
            $('#search-error').text(message).show();
        }
    });
});