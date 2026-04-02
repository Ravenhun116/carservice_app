<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Autószervíz napló</title>
</head>
<body>

    <div class="container">
        <h1>Autószervíz napló</h1>

        <form id="search-form" class="search-form" method="POST" action="/client/search">
            @csrf
            <div class="form-group">
                <label>Ügyfél neve</label>
                <input type="text" name="name">
            </div>
            <div class="form-group">
                <label>Ügyfél okmányazonosítója</label>
                <input type="text" name="card_number">
            </div>
            <button type="submit">Keres</button>
        </form>

        <div id="search-error" class="search-error" style="display:none;"></div>

        <div id="search-result" class="search-result" style="display:none;">
            <p><strong>Azonosító:</strong> <span id="result-id"></span></p>
            <p><strong>Név:</strong> <span id="result-name"></span></p>
            <p><strong>Okmányazonosító:</strong> <span id="result-card"></span></p>
            <p><strong>Autók száma:</strong> <span id="result-cars"></span></p>
            <p><strong>Szerviznapló bejegyzések száma:</strong> <span id="result-services"></span></p>
        </div>

        <hr>

        <h2>Ügyfelek</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Név</th>
                    <th>Okmány azonosító</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr class="client-row" data-id="{{ $client->id }}">
                    <td>{{ $client->id }}</td>
                    <td class="client-name">{{ $client->name }}</td>
                    <td>{{ $client->card_number }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $clients->links() }}
        </div>
    </div>

@vite(['resources/css/mainpage.css', 'resources/js/app.js'])
</body>
</html>