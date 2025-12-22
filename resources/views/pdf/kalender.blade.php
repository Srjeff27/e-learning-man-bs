<!DOCTYPE html>
<html>

<head>
    <title>Kalender Akademik {{ $currentYear }}</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            color: #1e293b;
        }

        .header p {
            margin: 5px 0 0;
            color: #64748b;
        }

        .semester-block {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .semester-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
            color: #0f172a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
        }

        th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
        }

        td {
            font-size: 14px;
            color: #334155;
        }

        .date {
            width: 170px;
            font-weight: bold;
            color: #0ea5e9;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            margin-top: 50px;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 10px;
            border-radius: 4px;
            background: #e2e8f0;
            color: #475569;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Kalender Akademik</h1>
        <p>Tahun Ajaran {{ $currentYear }}</p>
        <p>SMAN 2 KAUR</p>
    </div>

    <div class="semester-block">
        <div class="semester-title">Semester Ganjil (Juli - Desember)</div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kegiatan</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                @forelse($semesterGanjil as $event)
                    <tr>
                        <td class="date">
                            @if($event->is_all_day)
                                {{ $event->event_date->format('d M Y') }}
                            @elseif($event->end_date && $event->end_date->format('Y-m-d') != $event->event_date->format('Y-m-d'))
                                {{ $event->event_date->format('d M') }} - {{ $event->end_date->format('d M Y') }}
                            @else
                                {{ $event->event_date->format('d M Y') }}
                            @endif
                        </td>
                        <td>
                            {{ $event->title }}
                            @if($event->description)
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">{{ $event->description }}</div>
                            @endif
                        </td>
                        <td>
                            @if($event->category)
                                <span class="badge">{{ $event->category }}</span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #94a3b8;">Belum ada agenda semester ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="semester-block">
        <div class="semester-title">Semester Genap (Januari - Juni)</div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kegiatan</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                @forelse($semesterGenap as $event)
                    <tr>
                        <td class="date">
                            @if($event->is_all_day)
                                {{ $event->event_date->format('d M Y') }}
                            @elseif($event->end_date && $event->end_date->format('Y-m-d') != $event->event_date->format('Y-m-d'))
                                {{ $event->event_date->format('d M') }} - {{ $event->end_date->format('d M Y') }}
                            @else
                                {{ $event->event_date->format('d M Y') }}
                            @endif
                        </td>
                        <td>
                            {{ $event->title }}
                            @if($event->description)
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">{{ $event->description }}</div>
                            @endif
                        </td>
                        <td>
                            @if($event->category)
                                <span class="badge">{{ $event->category }}</span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #94a3b8;">Belum ada agenda semester ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dicetak pada {{ now()->format('d F Y H:i') }} | Sistem Informasi SMAN 2 KAUR
    </div>
</body>

</html>