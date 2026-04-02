<table class="cars-table">
    <thead>
        <tr>
            <th>Autó sorszáma</th>
            <th>Típus</th>
            <th>Regisztrálás</th>
            <th>Saját márkás</th>
            <th>Balesetek</th>
            <th>Utolsó esemény</th>
            <th>Utolsó esemény időpontja</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cars as $car)
        <tr>
            <td class="car-id" data-id="{{ $car->id }}">{{ $car->id }}</td>
            <td>{{ $car->type }}</td>
            <td>{{ $car->registered ?? '-' }}</td>
            <td>{{ $car->ownbrand ? 'Igen' : 'Nem' }}</td>
            <td>{{ $car->accident }}</td>
            <td>{{ $car->last_event ?? '-' }}</td>
            <td>{{ $car->last_event_time ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>