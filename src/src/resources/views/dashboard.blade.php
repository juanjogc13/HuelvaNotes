<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HuelvaNotes | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 0.4; }
            100% { transform: scale(1.5); opacity: 0; }
        }
        .pulse-ring::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            background: rgb(234 88 12);
            animation: pulse-ring 1.8s ease-out infinite;
        }
    </style>
</head>
<body class="antialiased bg-black text-white min-h-screen">

    {{-- Navbar --}}
    <nav class="border-b border-white/10 px-8 py-4 flex items-center justify-between gap-6">
        <div class="flex items-center gap-6 shrink-0">
            <a href="/dashboard" class="text-xl font-black tracking-tighter">
                <span class="text-orange-500">HUELVA</span><span class="text-white">NOTES</span>
            </a>
            <a href="{{ route('apuntes.index') }}"
                class="text-[10px] font-bold text-white/40 uppercase tracking-widest hover:text-orange-500 transition hidden sm:block">
                Explorar
            </a>
        </div>

        <form action="{{ route('apuntes.index') }}" method="GET" class="flex-1 max-w-2xl">
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="q" placeholder="Busca apuntes, asignaturas, centros..."
                    class="w-full pl-11 pr-6 py-3 bg-white/5 border border-white/10 rounded-2xl text-white text-sm placeholder-white/20 focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300">
            </div>
        </form>

        <div class="relative shrink-0" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-orange-500 flex items-center justify-center font-black text-black text-sm">
                    @if(Auth::user()->foto)
                        <img src="{{ Storage::url(Auth::user()->foto) }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="text-left hidden sm:block">
                    <p class="text-white text-xs font-bold">{{ Auth::user()->name }}</p>
                    <p class="text-orange-500 text-[10px] uppercase tracking-widest">{{ $user->puntos }} pts</p>
                </div>
                <svg class="w-4 h-4 text-white/30 group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-3 w-52 bg-black border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50">
                <div class="px-5 py-4 border-b border-white/10">
                    <p class="text-white text-sm font-bold">{{ Auth::user()->name }}</p>
                    <p class="text-white/30 text-xs">{{ Auth::user()->email }}</p>
                </div>
                <a href="/profile" class="flex items-center gap-3 px-5 py-3 text-white/60 hover:text-white hover:bg-white/5 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z"/>
                    </svg>
                    Mi perfil
                </a>
                <a href="/dashboard" class="flex items-center gap-3 px-5 py-3 text-white/60 hover:text-white hover:bg-white/5 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 0 0 1 1h3m10-11l2 2m-2-2v10a1 1 0 0 1-1 1h-3m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                <div class="border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-red-400 hover:text-red-300 hover:bg-white/5 transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1"/>
                            </svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-10">

        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-black tracking-tighter">Hola, <span class="text-orange-500">{{ Auth::user()->name }}</span> 👋</h2>
                <p class="text-white/30 text-sm mt-1 uppercase tracking-widest">Este es tu panel de control</p>
            </div>
            <a href="{{ route('apuntes.create') }}"
                class="relative flex items-center gap-3 bg-orange-600 hover:bg-orange-500 text-white font-black px-6 py-4 rounded-2xl transition-all duration-300 active:scale-95 shadow-2xl shadow-orange-900/50 group">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-40"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                </span>
                <span class="uppercase tracking-widest text-xs">Subir apunte</span>
                <svg class="w-4 h-4 group-hover:translate-y-[-2px] transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
            </a>
        </div>

        @if(session('status') === 'apunte-subido')
            <div class="bg-green-500/10 border border-green-500/30 rounded-2xl p-4 mb-6 flex items-center gap-3">
                <span class="text-green-400 text-lg">✅</span>
                <div>
                    <p class="text-green-400 text-sm font-bold">¡Apunte subido correctamente!</p>
                    <p class="text-green-400/60 text-xs mt-0.5">Has ganado <span class="font-black">+20 puntos</span> por compartir.</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">

            <div class="bg-white/5 border border-orange-500/40 rounded-3xl p-8 text-center backdrop-blur-xl relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-transparent pointer-events-none"></div>
                <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-3">Tus puntos</p>
                <p class="text-6xl font-black text-white">{{ $user->puntos }}</p>
                <p class="text-white/30 text-xs mt-3">Sube apuntes para ganar más</p>
                <div class="mt-4 h-1 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-orange-500 rounded-full transition-all duration-700"
                        style="width: {{ min(($user->puntos / 500) * 100, 100) }}%"></div>
                </div>
                <p class="text-white/20 text-[9px] uppercase tracking-widest mt-2">{{ $user->puntos }}/500 para nivel pro</p>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-3xl p-8 text-center backdrop-blur-xl">
                <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-3">Apuntes subidos</p>
                <p class="text-6xl font-black text-white">{{ $apuntesSubidos->count() }}</p>
                <p class="text-white/30 text-xs mt-3">Gracias por compartir</p>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-3xl p-8 text-center backdrop-blur-xl">
                <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-3">Descargas realizadas</p>
                <p class="text-6xl font-black text-white">{{ $ultimasDescargas->count() }}</p>
                <p class="text-white/30 text-xs mt-3">Material descargado</p>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <div class="bg-white/5 border border-white/10 rounded-3xl p-8 backdrop-blur-xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-[10px] font-bold text-orange-500 uppercase tracking-widest">📁 Tus últimos apuntes</h3>
                    <a href="{{ route('apuntes.create') }}" class="text-[9px] font-bold text-orange-500/60 hover:text-orange-500 uppercase tracking-widest transition">+ Subir</a>
                </div>
                @forelse ($apuntesSubidos as $apunte)
                    <div class="border-b border-white/10 py-4">
                        <p class="text-white font-semibold">{{ $apunte->titulo }}</p>
                        <p class="text-white/30 text-xs mt-1">{{ $apunte->asignatura->nombre ?? '-' }} · {{ $apunte->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <div class="text-center py-6">
                        <p class="text-white/20 text-sm mb-3">Todavía no has subido ningún apunte.</p>
                        <a href="{{ route('apuntes.create') }}" class="text-[10px] font-bold text-orange-500 uppercase tracking-widest hover:text-orange-400 transition">
                            Sube el primero →
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="bg-white/5 border border-white/10 rounded-3xl p-8 backdrop-blur-xl">
                <h3 class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-6">📥 Tus últimas descargas</h3>
                @forelse ($ultimasDescargas as $descarga)
                    <div class="border-b border-white/10 py-4">
                        <p class="text-white font-semibold">{{ $descarga->apunte->titulo ?? 'Apunte eliminado' }}</p>
                        <p class="text-white/30 text-xs mt-1">{{ $descarga->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-white/30 text-sm">Todavía no has descargado nada.</p>
                @endforelse
            </div>

            <div class="bg-white/5 border border-white/10 rounded-3xl p-8 backdrop-blur-xl lg:col-span-2">
                <h3 class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-6">🔔 Notificaciones</h3>
                @forelse ($notificaciones as $notificacion)
                    <div class="border-b border-white/10 py-4">
                        <p class="text-white font-semibold">{{ $notificacion->mensaje }}</p>
                        <p class="text-white/30 text-xs mt-1">{{ $notificacion->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-white/30 text-sm">No tienes notificaciones nuevas.</p>
                @endforelse
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>