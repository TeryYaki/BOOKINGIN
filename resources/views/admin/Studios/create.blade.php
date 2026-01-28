<!DOCTYPE html>
<html>
<head><title>Tambah Studio</title></head>
<body style="background:#111; color:white; font-family:sans-serif; padding:50px;">
    <h2>Tambah Studio Baru</h2>
    <form action="{{ route('studio.store') }}" method="POST">
        @csrf
        <div style="margin-bottom:15px">
            <label>Nama Studio</label><br>
            <input type="text" name="name" placeholder="Contoh: Studio 1" required style="padding:10px; width:300px;">
        </div>
        <div style="margin-bottom:15px">
            <label>Kota / Lokasi</label><br>
            <input type="text" name="city" placeholder="Contoh: Jakarta" required style="padding:10px; width:300px;">
        </div>
        <div style="margin-bottom:15px">
            <label>Jumlah Baris Kursi</label><br>
            <input type="number" name="total_rows" placeholder="Contoh: 8" required style="padding:10px;">
        </div>
        <div style="margin-bottom:15px">
            <label>Jumlah Kolom Kursi</label><br>
            <input type="number" name="total_cols" placeholder="Contoh: 10" required style="padding:10px;">
        </div>
        <button type="submit" style="padding:10px 20px; background:blue; color:white; border:none;">Simpan Studio</button>
    </form>
</body>
</html>