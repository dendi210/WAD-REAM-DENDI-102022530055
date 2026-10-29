<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penghuni Kos</title>
</head>
<body>
    <h2>Form Tambah Penghuni Kos</h2>

    <a href="{{ route('penghuni.index') }}" style="text-decoration: none; padding: 6px 12px; background-color: #6c757d; color: white; border-radius: 4px; display: inline-block; margin-bottom: 15px;">&larr; Kembali</a>

    <form action="{{ route('penghuni.store') }}" method="POST">
        <div style="margin-bottom: 10px;">
            <label><b>Nama Lengkap</b></label><br>
            <input type="text" name="nama_lengkap" style="width: 100%; padding: 5px;" required>
        </div>

        <!-- Bagian No KTP yang sudah ditambah validasi angka -->
        <div style="margin-bottom: 10px;">
            <label><b>No KTP</b> <span style="color: red; font-size: 12px;">*Hanya angka</span></label><br>
            <input type="text" name="no_ktp" style="width: 100%; padding: 5px;" required 
                   pattern="[0-9]+" title="Hanya boleh diisi dengan angka" 
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>

        <div style="margin-bottom: 10px;">
            <label><b>Pekerjaan</b></label><br>
            <input type="text" name="pekerjaan" style="width: 100%; padding: 5px;" required>
        </div>

        <!-- Bagian No HP yang sudah ditambah validasi angka -->
        <div style="margin-bottom: 10px;">
            <label><b>No HP</b> <span style="color: red; font-size: 12px;">*Hanya angka</span></label><br>
            <input type="text" name="no_hp" style="width: 100%; padding: 5px;" required 
                   pattern="[0-9]+" title="Hanya boleh diisi dengan angka" 
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>

        <!-- Bagian Kontak Darurat yang sudah ditambah validasi angka -->
        <div style="margin-bottom: 10px;">
            <label><b>Kontak Darurat (No HP)</b> <span style="color: red; font-size: 12px;">*Hanya angka</span></label><br>
            <input type="text" name="kontak_darurat" style="width: 100%; padding: 5px;" required 
                   pattern="[0-9]+" title="Hanya boleh diisi dengan angka" 
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>

        <div style="margin-bottom: 15px;">
            <label><b>Hubungan Kontak Darurat</b></label><br>
            <select name="hubungan_kontak_darurat" style="width: 100%; padding: 6px;" required>
                <option value="" disabled selected>-- Pilih Hubungan --</option>
                <option value="Orang Tua">Orang Tua</option>
                <option value="Saudara Kandung">Saudara Kandung</option>
                <option value="Suami / Istri">Suami / Istri</option>
                <option value="Kerabat">Kerabat</option>
                <option value="Teman">Teman</option>
            </select>
        </div>

        <button type="submit" style="padding: 8px 16px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">Simpan Data</button>
    </form>
</body>
</html>