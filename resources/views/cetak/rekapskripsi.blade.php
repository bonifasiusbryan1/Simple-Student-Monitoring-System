<!DOCTYPE html>
<html>
<head>
    <title>Rekap Skripsi</title>
</head>
<body>
    <h2>Rekap Skripsi</h2>

    <table border="1">
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Angkatan</th>
            <th>Semester Skripsi</th>
            <th>Nilai</th>
            <th>Status Skripsi</th>
        </tr>
        
        @foreach ($angkatanAktif as $angkatan)
            @if (isset($rekapSkripsi[$angkatan]) && count($rekapSkripsi[$angkatan]) > 0)
                @foreach ($rekapSkripsi[$angkatan] as $statusSkripsi => $mahasiswaList)
                    @foreach ($mahasiswaList as $mahasiswa)
                        <tr>
                            <td>{{ $mahasiswa['nim'] }}</td>
                            <td>{{ $mahasiswa['nama'] }}</td>
                            <td>{{ $mahasiswa['angkatan'] }}</td>
                            <td>{{ $mahasiswa['semester'] ?: '-' }}</td>
                            <td>{{ $mahasiswa['nilai'] ?: '-' }}</td>
                            <td>{{ $mahasiswa['status_skripsi'] ?: 'belum' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endif
        @endforeach
    </table>
    
</body>
</html>
