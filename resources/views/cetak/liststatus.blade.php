<!DOCTYPE html>
<html>
<head>
    <title>List Mahasiswa Berdasarkan Status</title>
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

    <h2>List Mahasiswa Berdasarkan Status</h2>

    <table border="1">
        <tr>
            <th>No</th>
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
        @foreach ($rekapStatus as $angkatan => $statusList)
            @foreach ($statusList[$listStatus] as $mahasiswa)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mahasiswa['nim'] }}</td>
                    <td>{{ $mahasiswa['nama'] }}</td>
                    <td>{{ $mahasiswa['email'] }}</td>
                    <td>{{ $mahasiswa['alamat'] }}</td>
                    <td>{{ $mahasiswa['kabkota'] }}</td>
                    <td>{{ $mahasiswa['provinsi'] }}</td>
                    <td>{{ $mahasiswa['notelp'] }}</td>
                    <td>{{ $mahasiswa['angkatan'] }}</td>
                    <td>{{ $listStatus }}</td>
                    <td>{{ $mahasiswa['dosenwali'] }}</td>
                    <td>{{ $mahasiswa['jalurmasuk'] }}</td>
                </tr>
            @endforeach
        @endforeach
    </table>
</body>
</html>
