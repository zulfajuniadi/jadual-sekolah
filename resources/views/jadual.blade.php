<table>
    <thead>
    <tr>
        <th>Nombor Hari</th>
        <th>Mula Pada</th>
        <th>Akhir Pada</th>
        <th>Nama Kelas</th>
        <th>Link Kelas</th>
    </tr>
    </thead>
    <tbody>
        @if (!empty($schedules))
            @foreach ($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->day  }}</td>
                    <td>{{ $schedule->start_time  }}</td>
                    <td>{{ $schedule->end_time }}</td>
                    <td>{{ $schedule->name  }}</td>
                    <td>{{ $schedule->class_url  }}</td>
                </tr>
            @endforeach
        @else
        <tr>
            <td>1</td>
            <td>08:00</td>
            <td>09:00</td>
            <td>Bestari</td>
            <td>https://jadualku.com</td>
        </tr>
        <tr>
            <td>5</td>
            <td>08:00</td>
            <td>09:00</td>
            <td>Lestari</td>
            <td>https://jadualku.com</td>
        </tr>
        <tr>
            <td>7</td>
            <td>08:00</td>
            <td>09:00</td>
            <td>Melawati</td>
            <td>https://jadualku.com</td>
        </tr>
        @endif
    </tbody>
</table>