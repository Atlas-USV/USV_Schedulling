<!DOCTYPE html>
<html>
<head>
    <title>Exams</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ storage_path('fonts/DejaVuSans.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Exams</h1>
    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Date</th>
                <th>Time</th>
                <th>Room</th>
                <th>Type</th>
                <th>Group</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exams as $exam)
                <tr>
                    <td>{{ $exam->subject->name }}</td>
                    <td>{{ $exam->exam_date->format('d M Y') }}</td>
                    <td>{{ $exam->start_time->format('H:i') }} - {{ $exam->end_time->format('H:i') }}</td>
                    <td>{{ $exam->room->name }}</td>
                    <td>{{ ucfirst($exam->type) }}</td>
                    <td>{{ $exam->group->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
