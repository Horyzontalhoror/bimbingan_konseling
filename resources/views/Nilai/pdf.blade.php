<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
            margin-bottom: 0;
        }
        p {
            text-align: center;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <h2>Data Lengkap Nilai Siswa</h2>
    <p>Bimbingan Konseling SMP</p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kelas</th>
                <th>NISN</th>
                <th>B. Indo</th>
                <th>B. Inggris</th>
                <th>Mat</th>
                <th>IPA</th>
                <th>IPS</th>
                <th>Agama</th>
                <th>PPKn</th>
                <th>Sosbud</th>
                <th>TIK</th>
                <th>Penjas</th>
                <th>Jumlah</th>
                <th>Rata-rata</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $row)
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->class }}</td>
                    <td>{{ $row->nisn }}</td>
                    <td>{{ $row->bindo }}</td>
                    <td>{{ $row->bing }}</td>
                    <td>{{ $row->mat }}</td>
                    <td>{{ $row->ipa }}</td>
                    <td>{{ $row->ips }}</td>
                    <td>{{ $row->agama }}</td>
                    <td>{{ $row->ppkn }}</td>
                    <td>{{ $row->sosbud }}</td>
                    <td>{{ $row->tik }}</td>
                    <td>{{ $row->penjas }}</td>
                    <td>{{ $row->jumlah_nilai }}</td>
                    <td>{{ $row->rata_rata }}</td>
                    <td>{{ $row->kategori }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
