<!DOCTYPE html>
<html>
<head><title>Atur Jadwal</title></head>
<body style="background:#111; color:white; font-family:sans-serif; padding:50px;">
    <h2>Atur Jadwal Tayang</h2>
    <form action="{{ route('showtime.store') }}" method="POST">
        @csrf
        <div style="margin-bottom:15px">
            <label>Pilih Film</label><br>
            <select name="movie_id" required style="padding:10px; width:300px;">
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                @endforeach
            </select>
        </div>
        
        <div style="margin-bottom:15px">
            <label>Pilih Studio</label><br>
            <select name="studio_id" required style="padding:10px; width:300px;">
                @foreach($studios as $studio)
                    <option value="{{ $studio->id }}">{{ $studio->name }} - {{ $studio->city }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:15px">
            <label>Tanggal</label><br>
            <input type="date" name="date" required style="padding:10px;">
        </div>

        <div style="margin-bottom:15px">
            <label>Jam Mulai</label><br>
            <input type="time" name="start_time" required style="padding:10px;">
        </div>

        <div style="margin-bottom:15px">
            <label>Harga Tiket (Khusus Jam Ini)</label><br>
            <input type="number" name="price" value="45000" required style="padding:10px;">
        </div>

        <button type="submit" style="padding:10px 20px; background:green; color:white; border:none;">Simpan Jadwal</button>
    </form>
</body>
</html>