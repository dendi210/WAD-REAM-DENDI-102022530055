<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Penghuni Kos</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 14px; }
        th { background-color: #f4f4f4; }
        .btn { padding: 6px 10px; text-decoration: none; border-radius: 4px; color: white; font-size: 13px; }
        .btn-tambah { background-color: #28a745; display: inline-block; margin-bottom: 10px; }
        .btn-edit { background-color: #ffc107; color: black; }
        .btn-hapus { background-color: #dc3545; border: none; cursor: pointer; padding: 6px 10px; color: white; border-radius: 4px;}
    </style>
</head>
<body>
    <h2>Manajemen Data Penghuni Kos</h2>
    <a href="{{ route('penghuni.create') }}" class="btn btn-tambah">+ Tambah Penghuni Baru</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>No KTP</th>
                <th>Pekerjaan</th>
                <th>No HP</th>
                <th>Kontak Darurat</th>
                <th>Hubungan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penghunis as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->nama_lengkap }}</td>
                <td>{{ $p->no_ktp }}</td>
                <td>{{ $p->pekerjaan }}</td>
                <td>{{ $p->no_hp }}</td>
                <td>{{ $p->kontak_darurat }}</td>
                <td>{{ $p->hubungan_kontak_darurat }}</td>
                <td>
                    <a href="{{ route('penghuni.edit', $p->id) }}" class="btn btn-edit">Edit</a>
                    <form action="{{ route('penghuni.destroy', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>