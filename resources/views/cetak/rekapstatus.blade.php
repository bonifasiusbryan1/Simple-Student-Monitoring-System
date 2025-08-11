<!DOCTYPE html>
<html>
<head>
    <title>Rekap Status</title>
    <style>
        div{
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        h3, div, table {
            text-align: center;
        }
    </style>
</head>
<body>
    <h3>Rekap Status</h3>

    <div>
        <table border="1">
            <tr>
                <th rowspan="8">Status</th>
                <th colspan="{{ count($angkatanAktif)+1 }}">Angkatan</th>
            </tr>
            <tr>
                <td></td>
                @foreach($angkatanAktif as $angkatan)
                    <td>{{ $angkatan }}</td>
                @endforeach
            </tr>
            @foreach(['aktif', 'cuti', 'mangkir', 'undur diri', 'lulus', 'meninggal dunia'] as $status)
                <tr>
                    <td>{{ ucwords($status) }}</td>
                    @foreach($angkatanAktif as $angkatan)
                        <td>
                            @php
                                $dataStatus = $rekapStatus[$angkatan][$status] ?? [];
                                $countData = count($dataStatus);
                            @endphp
                            {{ $countData }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>