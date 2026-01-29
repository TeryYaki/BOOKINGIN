<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Saya - Bookingin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Arial', sans-serif; background: #111; color: white; }
        
        /* NAVBAR (SAMA DENGAN MAIN) */
        .navbar { display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.9); padding: 1rem 2rem; position: fixed; width: 100%; top: 0; z-index: 100; box-sizing: border-box; border-bottom: 1px solid #333; }
        .navbar .logo { font-size: 1.5rem; font-weight: bold; letter-spacing: 2px; }
        .navbar a { color: white; text-decoration: none; margin-left: 20px; font-weight: 500; transition: 0.3s; }
        .navbar a:hover { color: #3b82f6; }

        .container { max-width: 1000px; margin: 100px auto 50px; padding: 0 20px; }

        /* PROFILE HEADER */
        .profile-header { display: flex; align-items: center; gap: 20px; background: #1b1b1b; padding: 30px; border-radius: 15px; border: 1px solid #333; margin-bottom: 40px; }
        .avatar-large { width: 80px; height: 80px; border-radius: 50%; border: 3px solid #3b82f6; }
        .profile-info h1 { margin: 0; font-size: 24px; }
        .profile-info p { color: #888; margin: 5px 0 0 0; }
        .badge { background: #3b82f6; color: white; padding: 2px 8px; border-radius: 4px; font-size: 12px; margin-left: 10px; vertical-align: middle; }

        /* SECTION TITLE */
        .section-title { font-size: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        
        /* TICKET LIST */
        .ticket-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        
        .ticket-card { background: #1b1b1b; border-radius: 10px; overflow: hidden; border: 1px solid #333; transition: transform 0.3s; position: relative; }
        .ticket-card:hover { transform: translateY(-5px); border-color: #3b82f6; }
        
        .poster-area { height: 150px; background-size: cover; background-position: center; position: relative; }
        .poster-overlay { position: absolute; bottom: 0; left: 0; width: 100%; background: linear-gradient(to top, #1b1b1b, transparent); height: 50px; }
        
        .ticket-body { padding: 20px; }
        .movie-title { font-size: 18px; font-weight: bold; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .ticket-meta { font-size: 13px; color: #aaa; margin-bottom: 15px; display: flex; gap: 15px; }
        .ticket-meta i { color: #3b82f6; margin-right: 5px; }
        
        .seats-badge { background: #222; padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: bold; color: white; display: inline-block; border: 1px solid #444; }

        .qr-area { text-align: center; margin-top: 15px; padding-top: 15px; border-top: 1px dashed #444; }
        .order-id { font-family: monospace; color: #555; font-size: 12px; display: block; margin-bottom: 10px; }
        
        .btn-logout { background: #ef4444; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; transition: 0.3s; margin-left: auto; }
        .btn-logout:hover { background: #dc2626; }

        .empty-state { text-align: center; padding: 50px; color: #555; }
        .empty-state i { font-size: 50px; margin-bottom: 15px; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">BOOKINGIN</div>
        <div>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('movies.index') }}">Movies</a>
            <a href="{{ route('profile') }}" style="color: #3b82f6;">Profile</a>
        </div>
    </nav>

    <div class="container">
        
        <div class="profile-header">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b82f6&color=fff" class="avatar-large">
            <div class="profile-info">
                <h1>{{ $user->name }} <span class="badge">Member</span></h1>
                <p>{{ $user->email }}</p>
                <p style="font-size: 12px; margin-top: 5px; color: #555;">Joined: {{ $user->created_at->format('d M Y') }}</p>
            </div>

            <form action="{{ route('logout') }}" method="POST" style="margin-left: auto;">
                @csrf
                <button class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Keluar</button>
            </form>
        </div>

        <div class="section-title">
            <span><i class="fa-solid fa-ticket"></i> Riwayat Tiket Saya</span>
            <span style="font-size: 14px; color: #777;">Total: {{ count($tickets) }} Tiket</span>
        </div>

        @if(count($tickets) > 0)
            <div class="ticket-grid">
                @foreach($tickets as $ticket)
                    <div class="ticket-card">
                        <div class="poster-area" style="background-image: url('{{ $ticket['poster'] ?? '' }}');">
                            <div class="poster-overlay"></div>
                        </div>

                        <div class="ticket-body">
                            <div class="movie-title">{{ $ticket['movie_title'] }}</div>
                            
                            <div class="ticket-meta">
                                <span><i class="fa-regular fa-clock"></i> {{ $ticket['time'] }}</span>
                                <span><i class="fa-solid fa-rupiah-sign"></i> {{ number_format($ticket['price'] ?? 0, 0, ',', '.') }}</span>
                            </div>

                            <div class="seats-badge">
                                Kursi: {{ is_array($ticket['seats']) ? implode(', ', $ticket['seats']) : $ticket['seats'] }}
                            </div>

                            <div class="qr-area">
                                <span class="order-id">ID: {{ $ticket['order_id'] }}</span>
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $ticket['order_id'] }}" width="80">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fa-solid fa-ticket-simple"></i>
                <h3>Belum ada riwayat pesanan</h3>
                <p>Ayo pesan tiket nonton film favoritmu sekarang!</p>
                <br>
                <a href="{{ route('home') }}" style="color: #3b82f6; text-decoration: none; border: 1px solid #3b82f6; padding: 10px 20px; border-radius: 5px;">Pesan Sekarang</a>
            </div>
        @endif

    </div>

</body>
</html>