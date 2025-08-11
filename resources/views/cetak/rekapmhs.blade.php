<!DOCTYPE html>
<html>
<head>
    <title>Rekap Mahasiswa</title>
    <style>
        table {
            font-size: 9px;
        }

        th, td {
            padding: 5px;
        }
    </style>
</head>
<body>

    <h2>Rekap Mahasiswa</h2>

    <table border="1">
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Kabupaten/Kota</th>
            <th>Provinsi</th>
            <th>No Telp</th>
            <th>Angkatan</th>
            <th>Status</th>
            <th>Dosen Wali</th>
            <th>Jalur Masuk</th>
        </tr>
        @foreach ($mahasiswa as $mhs)
            @if (($angkatan == 'semua' && $status == 'semua') ||
                ($angkatan == 'semua' && $mhs['status'] == $status) ||
                ($status == 'semua' && $mhs['angkatan'] == $angkatan) ||
                ($mhs['angkatan'] == $angkatan && $mhs['status'] == $status))
                <tr>
                    <td>{{ $mhs['nim'] }}</td>
                    <td>{{ $mhs['nama'] }}</td>
                    <td>{{ $mhs['email'] }}</td>
                    <td>{{ $mhs['alamat'] }}</td>
                    <td>{{ $mhs['kabkota'] }}</td>
                    <td>{{ $mhs['provinsi'] }}</td>
                    <td>{{ $mhs['notelp'] }}</td>
                    <td>{{ $mhs['angkatan'] }}</td>
                    <td>{{ $mhs['status'] }}</td>
                    <td>{{ $mhs['dosenwali'] }}</td>
                    <td>{{ $mhs['jalurmasuk'] }}</td>
                </tr>
            @endif
        @endforeach
    </table>
</body>
</html>
