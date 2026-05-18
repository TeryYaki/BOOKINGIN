<header class="bg-[#0a0a0a]/90 backdrop-blur-md border-b border-gray-800 fixed top-0 w-full z-50 px-6 py-4 flex justify-between items-center" style="font-family: 'Roboto', sans-serif;">
    <div class="text-2xl font-extrabold tracking-wider bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-blue-700" style="font-family: 'Montserrat', sans-serif;">
        BOOKINGIN
    </div>
    <nav class="hidden md:flex gap-6 items-center">
        <a href="{{ route('home') }}" class="text-gray-400 hover:text-white font-medium relative transition-all duration-300 after:content-[''] after:absolute after:w-0 after:h-0.5 after:-bottom-1.5 after:left-0 after:bg-blue-500 hover:after:w-full" style="text-decoration: none;">Beranda</a>
        <a href="{{ route('movies.index') }}" class="text-gray-400 hover:text-white font-medium relative transition-all duration-300 after:content-[''] after:absolute after:w-0 after:h-0.5 after:-bottom-1.5 after:left-0 after:bg-blue-500 hover:after:w-full" style="text-decoration: none;">Movies</a>
        
        @guest
            <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-full font-semibold transition" style="text-decoration: none;">Daftar</a>
            <a href="{{ route('login') }}" class="border border-gray-700 hover:bg-white hover:text-black text-white px-5 py-2 rounded-full font-semibold transition" style="text-decoration: none;">Login</a>
        @endguest

        @auth
            <div class="flex items-center gap-3 border-l border-gray-700 pl-5">
                <a href="{{ route('profile') }}" class="flex items-center gap-2 hover:opacity-80 transition" style="text-decoration: none;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff" class="w-8 h-8 rounded-full border border-blue-500">
                    <span class="font-semibold text-sm text-white">{{ Auth::user()->name }}</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;"> 
                    @csrf 
                    <button type="submit" class="bg-transparent border-none text-gray-400 hover:text-white cursor-pointer text-base" title="Logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button> 
                </form>
            </div>
        @endauth
    </nav>
</header>

<style>
/* Navbar Style */
        .navbar-glass {
            background: rgba(10, 10, 10, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .nav-link {
            position: relative;
            transition: all 0.3s;
        }
        .nav-link::after {
            content: '';
            position: absolute; width: 0; height: 2px;
            bottom: -5px; left: 0;
            background: #3b82f6; transition: all 0.3s;
        }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }

        /* Custom Form Elements */
        .dark-input {
            background-color: #0a0a0a;
            border: 1px solid #333;
            color: white;
            transition: all 0.3s;
        }
        .dark-input:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }
</style>