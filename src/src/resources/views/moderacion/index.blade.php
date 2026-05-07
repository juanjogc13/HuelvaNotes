<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HuelvaNotes | Moderación</title>

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
               class="text-[10px] font-bold text-white/40 uppercase tracking-widest hover:text-orange-500 transition hidden sm:block">
                Ranking
            </a>

            <a href="{{ route('moderacion.index') }}"
               class="text-[10px] font-bold text-orange-500 uppercase tracking-widest hidden sm:block">
                Solicitudes
            </a>
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
                        {{ Auth::user()->rol }} · {{ Auth::user()->puntos }} pts
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

                <a href="{{ route('ranking.index') }}" class="flex items-center gap-3 px-5 py-3 text-white/60 hover:text-white hover:bg-white/5 transition text-sm">
                    <i class="bi bi-trophy-fill text-sm"></i>
                    Ranking
                </a>

                <a href="{{ route('moderacion.index') }}" class="flex items-center gap-3 px-5 py-3 text-orange-500 hover:text-orange-400 hover:bg-white/5 transition text-sm">
                    <i class="bi bi-clipboard-check-fill text-sm"></i>
                    Solicitudes
                </a>

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

    <div class="max-w-7xl mx-auto px-6 py-10">

        {{-- Cabecera --}}
        <div class="flex items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-black tracking-tighter">
                    Panel de <span class="text-orange-500">Moderación</span>
                </h2>

                <p class="text-white/30 text-sm mt-1 uppercase tracking-widest">
                    {{ $apuntesPendientes->total() }} apuntes pendientes de revisión
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="hidden sm:flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-black px-6 py-4 rounded-2xl transition-all duration-300 active:scale-95">
                <span class="uppercase tracking-widest text-xs">Volver al dashboard</span>
                <i class="bi bi-house-door-fill text-orange-500"></i>
            </a>
        </div>

        {{-- Mensajes --}}
        @if(session('status') === 'apunte-aprobado')
            <div class="bg-green-500/10 border border-green-500/30 rounded-2xl p-4 mb-6 flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-green-400 text-lg"></i>

                <div>
                    <p class="text-green-400 text-sm font-bold">Apunte aprobado correctamente.</p>
                    <p class="text-green-400/60 text-xs mt-0.5">
                        El autor ha recibido sus puntos y el apunte ya aparece en explorar.
                    </p>
                </div>
            </div>
        @endif

        @if(session('status') === 'apunte-rechazado')
            <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-4 mb-6 flex items-center gap-3">
                <i class="bi bi-x-circle-fill text-red-400 text-lg"></i>

                <div>
                    <p class="text-red-400 text-sm font-bold">Apunte rechazado correctamente.</p>
                    <p class="text-red-400/60 text-xs mt-0.5">
                        El usuario recibirá una notificación con el motivo.
                    </p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-4 mb-6 flex items-center gap-3">
                <i class="bi bi-exclamation-triangle-fill text-red-400 text-lg"></i>

                <p class="text-red-400 text-sm font-bold">{{ session('error') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-4 mb-6">
                <p class="text-red-400 text-sm font-bold mb-2 flex items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Hay errores en el formulario:
                </p>

                <ul class="list-disc list-inside text-red-400/80 text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Contenido --}}
        @if($apuntesPendientes->isEmpty())
            <div class="bg-white/5 border border-white/10 rounded-3xl p-16 text-center">
                <p class="text-white/20 text-5xl mb-4">
                    <i class="bi bi-check2-circle"></i>
                </p>

                <p class="text-white font-bold">No hay apuntes pendientes</p>
                <p class="text-white/30 text-sm mt-2">Todo está revisado por ahora.</p>

                <a href="{{ route('apuntes.index') }}" class="inline-flex items-center gap-2 mt-6 text-[10px] font-bold text-orange-500 uppercase tracking-widest hover:text-orange-400 transition">
                    Ir a explorar
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                @foreach($apuntesPendientes as $apunte)
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-6 hover:border-orange-500/30 transition-all duration-300">

                        <div class="flex items-start justify-between gap-4 mb-5">
                            <div>
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-widest
                                        {{ $apunte->formato === 'pdf' ? 'bg-red-500/20 text-red-400' :
                                           ($apunte->formato === 'docx' || $apunte->formato === 'doc' ? 'bg-blue-500/20 text-blue-400' :
                                           ($apunte->formato === 'pptx' || $apunte->formato === 'ppt' ? 'bg-orange-500/20 text-orange-400' :
                                           'bg-green-500/20 text-green-400')) }}">
                                        {{ strtoupper($apunte->formato) }}
                                    </span>

                                    <span class="px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-widest bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 flex items-center gap-1">
                                        <i class="bi bi-hourglass-split"></i>
                                        Pendiente
                                    </span>
                                </div>

                                <h3 class="text-white font-black text-xl leading-snug tracking-tight">
                                    {{ $apunte->titulo }}
                                </h3>

                                <p class="text-white/30 text-xs mt-2">
                                    Subido {{ $apunte->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        @if($apunte->descripcion)
                            <div class="mb-5">
                                <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                                    <i class="bi bi-card-text"></i>
                                    Descripción
                                </p>

                                <p class="text-white/60 text-sm leading-relaxed">
                                    {{ $apunte->descripcion }}
                                </p>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-3 mb-5">
                            <div class="bg-white/5 rounded-2xl p-4">
                                <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-1 flex items-center gap-2">
                                    <i class="bi bi-person-fill"></i>
                                    Autor
                                </p>
                                <p class="text-white text-sm font-semibold">{{ $apunte->user->name ?? 'Sin usuario' }}</p>
                            </div>

                            <div class="bg-white/5 rounded-2xl p-4">
                                <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-1 flex items-center gap-2">
                                    <i class="bi bi-building-fill"></i>
                                    Centro
                                </p>
                                <p class="text-white text-sm font-semibold">{{ $apunte->centro->nombre ?? '-' }}</p>
                            </div>

                            <div class="bg-white/5 rounded-2xl p-4">
                                <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-1 flex items-center gap-2">
                                    <i class="bi bi-journal-bookmark-fill"></i>
                                    Curso
                                </p>
                                <p class="text-white text-sm font-semibold">{{ $apunte->curso->nombre ?? '-' }}</p>
                            </div>

                            <div class="bg-white/5 rounded-2xl p-4">
                                <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-1 flex items-center gap-2">
                                    <i class="bi bi-book-fill"></i>
                                    Asignatura
                                </p>
                                <p class="text-white text-sm font-semibold">{{ $apunte->asignatura->nombre ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mb-5">
                            <a href="{{ asset('storage/' . $apunte->archivo) }}"
                               target="_blank"
                               class="flex-1 text-center py-3 bg-white/5 hover:bg-white/10 border border-white/10 text-white/60 hover:text-white rounded-2xl font-black text-xs uppercase tracking-widest transition flex items-center justify-center gap-2">
                                <i class="bi bi-eye-fill"></i>
                                Ver archivo
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <form method="POST" action="{{ route('moderacion.aprobar', $apunte->id) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    class="w-full py-4 bg-green-600 hover:bg-green-500 text-white font-black rounded-2xl transition uppercase tracking-widest text-xs active:scale-95 flex items-center justify-center gap-2">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Aprobar
                                </button>
                            </form>

                            <form method="POST" action="{{ route('moderacion.rechazar', $apunte->id) }}" x-data="{ open: false }">
                                @csrf
                                @method('PATCH')

                                <div x-show="open" x-transition class="mb-3" style="display: none;">
                                    <textarea name="motivo" rows="3"
                                        placeholder="Motivo del rechazo..."
                                        class="w-full px-4 py-3 bg-black/40 border border-white/10 rounded-2xl text-white text-sm placeholder-white/20 focus:outline-none focus:border-red-500/50 transition resize-none"></textarea>
                                </div>

                                <button type="button"
                                    x-show="!open"
                                    @click="open = true"
                                    class="w-full py-4 bg-red-500/10 border border-red-500/30 text-red-400 hover:bg-red-500/20 font-black rounded-2xl transition uppercase tracking-widest text-xs flex items-center justify-center gap-2">
                                    <i class="bi bi-x-circle-fill"></i>
                                    Rechazar
                                </button>

                                <button type="submit"
                                    x-show="open"
                                    x-transition
                                    class="w-full py-4 bg-red-600 hover:bg-red-500 text-white font-black rounded-2xl transition uppercase tracking-widest text-xs active:scale-95 flex items-center justify-center gap-2"
                                    style="display: none;">
                                    <i class="bi bi-send-x-fill"></i>
                                    Confirmar rechazo
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>

            @if($apuntesPendientes->hasPages())
                <div class="mt-8 flex justify-center gap-2 flex-wrap">
                    @if($apuntesPendientes->onFirstPage())
                        <span class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white/20 text-sm">
                            ← Anterior
                        </span>
                    @else
                        <a href="{{ $apuntesPendientes->previousPageUrl() }}" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white/60 hover:text-white hover:border-orange-500/40 transition text-sm">
                            ← Anterior
                        </a>
                    @endif

                    @foreach($apuntesPendientes->getUrlRange(1, $apuntesPendientes->lastPage()) as $page => $url)
                        <a href="{{ $url }}" class="px-4 py-2 rounded-xl text-sm transition
                            {{ $page == $apuntesPendientes->currentPage() ? 'bg-orange-600 text-white font-bold' : 'bg-white/5 border border-white/10 text-white/60 hover:text-white hover:border-orange-500/40' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if($apuntesPendientes->hasMorePages())
                        <a href="{{ $apuntesPendientes->nextPageUrl() }}" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white/60 hover:text-white hover:border-orange-500/40 transition text-sm">
                            Siguiente →
                        </a>
                    @else
                        <span class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white/20 text-sm">
                            Siguiente →
                        </span>
                    @endif
                </div>
            @endif
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>