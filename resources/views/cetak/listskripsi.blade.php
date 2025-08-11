<!DOCTYPE html>
<html>
<head>
    <title>Rekap Skripsi</title>
</head>
<body>
    <h2>Rekap Skripsi</h2>

    @if($listStatus == 'sudah')
        <table border="1">
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Angkatan</th>
                <th>Semester Skripsi</th> 
                <th>Nilai</th>
                <th>Status Skripsi</th>
            </tr>
            @foreach ($rekapSkripsi[$angkatan]['sudah'] as $mahasiswa)
                <tr>
                    <td>{{ $mahasiswa['nim'] }}</td>
                    <td>{{ $mahasiswa['nama'] }}</td>
                    <td>{{ $mahasiswa['angkatan'] }}</td>
                    <td>{{ $mahasiswa['semester'] ?: '-' }}</td>
                    <td>{{ $mahasiswa['nilai'] ?: '-' }}</td>
                    <td>{{ $mahasiswa['status_skripsi'] ?: 'belum' }}</td>
                </tr>
            @endforeach
        </table>
    @elseif($listStatus == 'belum')
        <table border="1">
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Angkatan</th>
                <th>Status Skripsi</th>
            </tr>
            @foreach ($rekapSkripsi[$angkatan]['belum'] as $mahasiswa)
                <tr>
                    <td>{{ $mahasiswa['nim'] }}</td>
                    <td>{{ $mahasiswa['nama'] }}</td>
                    <td>{{ $mahasiswa['angkatan'] }}</td>
                    <td>{{ $mahasiswa['status_skripsi'] ?: 'belum' }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    
</body>
</html>
