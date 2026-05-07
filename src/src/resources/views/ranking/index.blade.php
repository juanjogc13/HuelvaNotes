<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HuelvaNotes | Ranking</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
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

            <a href="{{ route('ranking.index') }}"
                class="text-[10px] font-bold text-orange-500 uppercase tracking-widest hidden sm:block">
                Ranking
            </a>

            @if(in_array(Auth::user()->rol, ['admin', 'moderador']))
                <a href="{{ route('moderacion.index') }}"
                    class="text-[10px] font-bold text-white/40 uppercase tracking-widest hover:text-orange-500 transition hidden sm:block">
                    Solicitudes
                </a>
            @endif
        </div>

        <form action="{{ route('apuntes.index') }}" method="GET" class="flex-1 max-w-2xl">
            <div class="relative">
                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>

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
                    <p class="text-orange-500 text-[10px] uppercase tracking-widest">
                        {{ Auth::user()->puntos }} pts
                        @if(in_array(Auth::user()->rol, ['admin', 'moderador']))
                            · {{ Auth::user()->rol }}
                        @endif
                    </p>
                </div>

                <i class="bi bi-chevron-down text-white/30 group-hover:text-orange-500 transition text-sm"></i>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-3 w-52 bg-black border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50"
                style="display: none;">
                <div class="px-5 py-4 border-b border-white/10">
                    <p class="text-white text-sm font-bold">{{ Auth::user()->name }}</p>
                    <p class="text-white/30 text-xs">{{ Auth::user()->email }}</p>
                </div>

                <a href="/profile" class="flex items-center gap-3 px-5 py-3 text-white/60 hover:text-white hover:bg-white/5 transition text-sm">
                    <i class="bi bi-person-fill text-sm"></i>
                    Mi perfil
                </a>

                <a href="/dashboard" class="flex items-center gap-3 px-5 py-3 text-white/60 hover:text-white hover:bg-white/5 transition text-sm">
                    <i class="bi bi-house-door-fill text-sm"></i>
                    Dashboard
                </a>

                <a href="{{ route('ranking.index') }}" class="flex items-center gap-3 px-5 py-3 text-orange-500 hover:text-orange-400 hover:bg-white/5 transition text-sm">
                    <i class="bi bi-trophy-fill text-sm"></i>
                    Ranking
                </a>

                @if(in_array(Auth::user()->rol, ['admin', 'moderador']))
                    <a href="{{ route('moderacion.index') }}" class="flex items-center gap-3 px-5 py-3 text-white/60 hover:text-white hover:bg-white/5 transition text-sm">
                        <i class="bi bi-clipboard-check-fill text-sm"></i>
                        Solicitudes
                    </a>
                @endif

                <div class="border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-red-400 hover:text-red-300 hover:bg-white/5 transition text-sm">
                            <i class="bi bi-box-arrow-right text-sm"></i>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-10">

        {{-- Cabecera --}}
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-black tracking-tighter">
                    Ranking de <span class="text-orange-500">Puntos</span>
                </h2>

                <p class="text-white/30 text-sm mt-1 uppercase tracking-widest">
                    Los usuarios que más participan en HuelvaNotes
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
                class="hidden sm:flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-black px-6 py-4 rounded-2xl transition-all duration-300 active:scale-95">
                <span class="uppercase tracking-widest text-xs">Dashboard</span>
                <i class="bi bi-house-door-fill text-orange-500"></i>
            </a>
        </div>

        {{-- Top 3 --}}
        @if($usuarios->count() > 0 && $usuarios->currentPage() === 1)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                @foreach($usuarios->take(3) as $index => $usuarioTop)
                    @php
                        $posicion = $index + 1;

                        $estilo = match($posicion) {
                            1 => 'border-orange-500/50 bg-orange-500/10 shadow-orange-900/30',
                            2 => 'border-white/20 bg-white/5 shadow-white/5',
                            3 => 'border-yellow-600/30 bg-yellow-500/5 shadow-yellow-900/10',
                            default => 'border-white/10 bg-white/5',
                        };

                        $icono = match($posicion) {
                            1 => 'bi-trophy-fill',
                            2 => 'bi-award-fill',
                            3 => 'bi-star-fill',
                            default => 'bi-person-fill',
                        };

                        $colorIcono = match($posicion) {
                            1 => 'text-orange-500',
                            2 => 'text-white/70',
                            3 => 'text-yellow-500',
                            default => 'text-white/40',
                        };

                        $titulo = match($posicion) {
                            1 => 'Top 1',
                            2 => 'Top 2',
                            3 => 'Top 3',
                            default => 'Ranking',
                        };
                    @endphp

                    <div class="border {{ $estilo }} rounded-3xl p-6 text-center relative overflow-hidden shadow-2xl">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-transparent pointer-events-none"></div>

                        <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-3">
                            {{ $titulo }}
                        </p>

                        <p class="text-5xl mb-4 {{ $colorIcono }}">
                            <i class="bi {{ $icono }}"></i>
                        </p>

                        <div class="w-16 h-16 rounded-full overflow-hidden bg-orange-500 flex items-center justify-center font-black text-black text-xl mx-auto mb-4">
                            @if($usuarioTop->foto)
                                <img src="{{ Storage::url($usuarioTop->foto) }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($usuarioTop->name, 0, 1)) }}
                            @endif
                        </div>

                        <p class="text-white font-black text-lg leading-tight">{{ $usuarioTop->name }}</p>

                        <p class="text-white/30 text-xs mt-1 line-clamp-1">
                            {{ $usuarioTop->centro->localidad ?? '' }}
                            @if($usuarioTop->centro)
                                ·
                            @endif
                            {{ $usuarioTop->centro->nombre ?? 'Sin centro' }}
                        </p>

                        <p class="text-orange-500 text-4xl font-black mt-5">
                            {{ $usuarioTop->puntos }}
                        </p>

                        <p class="text-white/30 text-[10px] uppercase tracking-widest">
                            puntos
                        </p>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Posición del usuario actual --}}
        @php
            $miPosicion = \App\Models\User::where(function ($query) {
                    $query->where('puntos', '>', Auth::user()->puntos)
                        ->orWhere(function ($query) {
                            $query->where('puntos', Auth::user()->puntos)
                                ->where('name', '<', Auth::user()->name);
                        });
                })
                ->count() + 1;
        @endphp

        <div class="bg-orange-500/10 border border-orange-500/30 rounded-3xl p-6 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                    <i class="bi bi-geo-alt-fill"></i>
                    Tu posición
                </p>

                <h3 class="text-white font-black text-xl tracking-tight">
                    Vas en el puesto <span class="text-orange-500">#{{ $miPosicion }}</span>
                </h3>

                <p class="text-white/40 text-sm mt-1">
                    Tienes {{ Auth::user()->puntos }} puntos. Sube apuntes aprobados y recibe valoraciones para subir posiciones.
                </p>
            </div>

            <a href="{{ route('apuntes.create') }}"
                class="inline-flex justify-center items-center gap-3 bg-orange-600 hover:bg-orange-500 text-white font-black px-6 py-4 rounded-2xl transition-all duration-300 active:scale-95 shadow-xl shadow-orange-900/40">
                <span class="uppercase tracking-widest text-xs">Subir apunte</span>
                <i class="bi bi-upload"></i>
            </a>
        </div>

        {{-- Ranking completo --}}
        <div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden">
            <div class="px-6 py-5 border-b border-white/10 flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest flex items-center gap-2">
                        <i class="bi bi-list-ol"></i>
                        Clasificación general
                    </p>

                    <p class="text-white/30 text-xs mt-1">
                        {{ $usuarios->total() }} usuarios registrados
                    </p>
                </div>
            </div>

            <div class="divide-y divide-white/10">
                @forelse($usuarios as $index => $usuario)
                    @php
                        $posicionGlobal = ($usuarios->currentPage() - 1) * $usuarios->perPage() + $index + 1;
                        $esYo = $usuario->id === Auth::id();
                    @endphp

                    <div class="px-6 py-5 flex items-center gap-4 transition {{ $esYo ? 'bg-orange-500/10' : 'hover:bg-white/[0.03]' }}">
                        <div class="w-12 text-center shrink-0">
                            @if($posicionGlobal === 1)
                                <i class="bi bi-trophy-fill text-orange-500 text-2xl"></i>
                            @elseif($posicionGlobal === 2)
                                <i class="bi bi-award-fill text-white/70 text-2xl"></i>
                            @elseif($posicionGlobal === 3)
                                <i class="bi bi-star-fill text-yellow-500 text-2xl"></i>
                            @else
                                <span class="text-white/30 text-sm font-black">#{{ $posicionGlobal }}</span>
                            @endif
                        </div>

                        <div class="w-12 h-12 rounded-full overflow-hidden bg-orange-500 flex items-center justify-center font-black text-black text-sm shrink-0">
                            @if($usuario->foto)
                                <img src="{{ Storage::url($usuario->foto) }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($usuario->name, 0, 1)) }}
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <p class="text-white font-bold truncate">{{ $usuario->name }}</p>

                                @if($esYo)
                                    <span class="px-2 py-0.5 rounded-lg bg-orange-500/20 text-orange-400 text-[9px] font-black uppercase tracking-widest">
                                        Tú
                                    </span>
                                @endif

                                @if(in_array($usuario->rol, ['admin', 'moderador']))
                                    <span class="px-2 py-0.5 rounded-lg bg-white/10 text-white/40 text-[9px] font-black uppercase tracking-widest">
                                        {{ $usuario->rol }}
                                    </span>
                                @endif
                            </div>

                            <p class="text-white/30 text-xs truncate">
                                {{ $usuario->centro->localidad ?? '' }}
                                @if($usuario->centro)
                                    ·
                                @endif
                                {{ $usuario->centro->nombre ?? 'Sin centro asignado' }}
                            </p>
                        </div>

                        <div class="text-right shrink-0">
                            <p class="text-orange-500 text-xl font-black">
                                {{ $usuario->puntos }}
                            </p>

                            <p class="text-white/30 text-[10px] uppercase tracking-widest">
                                pts
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <p class="text-white/20 text-5xl mb-4">
                            <i class="bi bi-inbox-fill"></i>
                        </p>

                        <p class="text-white font-bold">
                            Todavía no hay usuarios en el ranking
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Paginación --}}
        @if($usuarios->hasPages())
            <div class="mt-8 flex justify-center gap-2 flex-wrap">
                @if($usuarios->onFirstPage())
                    <span class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white/20 text-sm">
                        ← Anterior
                    </span>
                @else
                    <a href="{{ $usuarios->previousPageUrl() }}" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white/60 hover:text-white hover:border-orange-500/40 transition text-sm">
                        ← Anterior
                    </a>
                @endif

                @foreach($usuarios->getUrlRange(1, $usuarios->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="px-4 py-2 rounded-xl text-sm transition
                        {{ $page == $usuarios->currentPage() ? 'bg-orange-600 text-white font-bold' : 'bg-white/5 border border-white/10 text-white/60 hover:text-white hover:border-orange-500/40' }}">
                        {{ $page }}
                    </a>
                @endforeach

                @if($usuarios->hasMorePages())
                    <a href="{{ $usuarios->nextPageUrl() }}" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white/60 hover:text-white hover:border-orange-500/40 transition text-sm">
                        Siguiente →
                    </a>
                @else
                    <span class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white/20 text-sm">
                        Siguiente →
                    </span>
                @endif
            </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>