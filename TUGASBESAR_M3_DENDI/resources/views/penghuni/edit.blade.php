<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Penghuni Kos</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .form-group { margin-bottom: 12px; }
        label { display: block; margin-bottom: 4px; font-weight: bold; }
        input { width: 100%; padding: 7px; box-sizing: border-box; }
        button { padding: 9px 14px; background-color: #ffc107; font-weight: bold; border: none; cursor: pointer; border-radius: 4px;}
    </style>
</head>
<body>
    <h2>Form Edit Penghuni Kos</h2>
    <a href="{{ route('penghuni.index') }}">Kembali</a>
    <form action="{{ route('penghuni.update', $penghuni->id) }}" method="POST" style="margin-top: 15px;">
        @csrf
        @method('PUT')
        <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" value="{{ $penghuni->nama_lengkap }}" required></div>
        <div class="form-group"><label>No KTP</label><input type="text" name="no_ktp" value="{{ $penghuni->no_ktp }}" required></div>
        <div class="form-group"><label>Pekerjaan</label><input type="text" name="pekerjaan" value="{{ $penghuni->pekerjaan }}" required></div>
        <div class="form-group"><label>No HP</label><input type="text" name="no_hp" value="{{ $penghuni->no_hp }}" required></div>
        <div class="form-group"><label>Kontak Darurat</label><input type="text" name="kontak_darurat" value="{{ $penghuni->kontak_darurat }}" required></div>
        <div class="form-group"><label>Hubungan Kontak Darurat</label><input type="text" name="hubungan_kontak_darurat" value="{{ $penghuni->hubungan_kontak_darurat }}" required></div>
        <button type="submit">Update Data</button>
    </form>
</body>
</html>