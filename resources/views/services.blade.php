<table class="services-table">
    <thead>
        <tr>
            <th>Alkalom sorszáma</th>
            <th>Esemény neve</th>
            <th>Esemény időpontja</th>
            <th>Munkalap azonosító</th>
        </tr>
    </thead>
    <tbody>
        @foreach($services as $service)
        <tr>
            <td>{{ $service['log_number'] }}</td>
            <td>{{ $service['event'] }}</td>
            <td>{{ $service['event_time'] ?? '-' }}</td>
            <td>{{ $service['document_id'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>