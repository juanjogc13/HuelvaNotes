<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HuelvaNotes | Apuntes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="antialiased bg-black text-white min-h-screen">

    {{-- Navbar --}}
    <nav class="border-b border-white/10 px-8 py-4 flex items-center justify-between gap-6">
        <a href="/dashboard" class="text-xl font-black tracking-tighter shrink-0">
            <span class="text-orange-500">HUELVA</span><span class="text-white">NOTES</span>
        </a>

        <form action="{{ route('apuntes.index') }}" method="GET" class="flex-1 max-w-2xl">
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Busca apuntes, asignaturas, centros..."
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
                    <p class="text-orange-500 text-[10px] uppercase tracking-widest">{{ Auth::user()->puntos }} pts</p>
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

        {{-- Cabecera --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-black tracking-tighter">Todos los <span class="text-orange-500">Apuntes</span></h2>
                <p class="text-white/30 text-sm mt-1 uppercase tracking-widest">{{ $apuntes->total() }} apuntes disponibles</p>
            </div>
            <a href="{{ route('apuntes.create') }}"
                class="flex items-center gap-3 bg-orange-600 hover:bg-orange-500 text-white font-black px-6 py-4 rounded-2xl transition-all duration-300 active:scale-95 shadow-2xl shadow-orange-900/50">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-40"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                </span>
                <span class="uppercase tracking-widest text-xs">Subir apunte</span>
            </a>
        </div>

        <div class="flex gap-6">

            {{-- Barra lateral de filtros --}}
            <form method="GET" action="{{ route('apuntes.index') }}" class="w-64 shrink-0 space-y-4">

                {{-- Filtros activos --}}
                @if(request()->hasAny(['nivel_id', 'curso_id', 'asignatura_id', 'centro_id', 'formato', 'q']))
                    <div class="bg-orange-500/10 border border-orange-500/30 rounded-2xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest">Filtros activos</p>
                            <a href="{{ route('apuntes.index') }}" class="text-[10px] text-white/40 hover:text-orange-500 uppercase tracking-widest transition">Limpiar</a>
                        </div>
                        <p class="text-white/40 text-xs">Mostrando resultados filtrados</p>
                    </div>
                @endif

                {{-- Nivel --}}
                <div class="bg-white/5 border border-white/10 rounded-2xl p-5">
                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-3">Nivel</p>
                    <div class="space-y-2">
                        @foreach($niveles as $nivel)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="nivel_id" value="{{ $nivel->id }}"
                                    {{ request('nivel_id') == $nivel->id ? 'checked' : '' }}
                                    class="accent-orange-500">
                                <span class="text-white/60 text-sm group-hover:text-white transition">{{ $nivel->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Curso --}}
                <div class="bg-white/5 border border-white/10 rounded-2xl p-5">
                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-3">Curso</p>
                    <select name="curso_id"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-orange-500/50 transition appearance-none">
                        <option value="" class="bg-black">Todos los cursos</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}" class="bg-black" {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                {{ $curso->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Asignatura --}}
                <div class="bg-white/5 border border-white/10 rounded-2xl p-5">
                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-3">Asignatura</p>
                    <select name="asignatura_id"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-orange-500/50 transition appearance-none">
                        <option value="" class="bg-black">Todas las asignaturas</option>
                        @foreach($asignaturas as $asignatura)
                            <option value="{{ $asignatura->id }}" class="bg-black" {{ request('asignatura_id') == $asignatura->id ? 'selected' : '' }}>
                                {{ $asignatura->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Centro --}}
                <div class="bg-white/5 border border-white/10 rounded-2xl p-5">
                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-3">Centro</p>
                    <select name="centro_id"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-orange-500/50 transition appearance-none">
                        <option value="" class="bg-black">Todos los centros</option>
                        @foreach($centros as $centro)
                            <option value="{{ $centro->id }}" class="bg-black" {{ request('centro_id') == $centro->id ? 'selected' : '' }}>
                                {{ $centro->localidad }} · {{ $centro->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Formato --}}
                <div class="bg-white/5 border border-white/10 rounded-2xl p-5">
                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-3">Formato</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['pdf', 'docx', 'pptx', 'jpg', 'png'] as $fmt)
                            <label class="cursor-pointer">
                                <input type="radio" name="formato" value="{{ $fmt }}"
                                    {{ request('formato') == $fmt ? 'checked' : '' }} class="hidden peer">
                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-widest border transition
                                    peer-checked:bg-orange-500 peer-checked:border-orange-500 peer-checked:text-black
                                    border-white/10 text-white/40 hover:border-orange-500/40 hover:text-white">
                                    {{ strtoupper($fmt) }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Botón aplicar --}}
                <button type="submit"
                    class="w-full py-4 bg-orange-600 hover:bg-orange-500 text-white font-black rounded-2xl transition uppercase tracking-widest text-xs">
                    Aplicar filtros
                </button>

            </form>

            {{-- Grid de apuntes --}}
            <div class="flex-1">

                @if($apuntes->isEmpty())
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-16 text-center">
                        <p class="text-white/20 text-4xl mb-4">📭</p>
                        <p class="text-white font-bold">No se encontraron apuntes</p>
                        <p class="text-white/30 text-sm mt-2">Prueba a cambiar los filtros o sé el primero en subir uno</p>
                        <a href="{{ route('apuntes.create') }}" class="inline-block mt-6 text-[10px] font-bold text-orange-500 uppercase tracking-widest hover:text-orange-400 transition">
                            Subir apunte →
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($apuntes as $apunte)
                            <div class="bg-white/5 border border-white/10 rounded-3xl p-6 hover:border-orange-500/30 transition-all duration-300 group flex flex-col justify-between">

                                {{-- Cabecera de la tarjeta --}}
                                <div>
                                    {{-- Formato badge --}}
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-widest
                                            {{ $apunte->formato === 'pdf' ? 'bg-red-500/20 text-red-400' :
                                               ($apunte->formato === 'docx' || $apunte->formato === 'doc' ? 'bg-blue-500/20 text-blue-400' :
                                               ($apunte->formato === 'pptx' || $apunte->formato === 'ppt' ? 'bg-orange-500/20 text-orange-400' :
                                               'bg-green-500/20 text-green-400')) }}">
                                            {{ strtoupper($apunte->formato) }}
                                        </span>
                                        <span class="text-white/20 text-xs">{{ $apunte->created_at->diffForHumans() }}</span>
                                    </div>

                                    {{-- Título --}}
                                    <h3 class="text-white font-black text-base leading-snug mb-2 group-hover:text-orange-500 transition">
                                        {{ $apunte->titulo }}
                                    </h3>

                                    {{-- Descripción --}}
                                    @if($apunte->descripcion)
                                        <p class="text-white/30 text-xs leading-relaxed mb-4 line-clamp-2">{{ $apunte->descripcion }}</p>
                                    @endif

                                    {{-- Metadatos --}}
                                    <div class="space-y-1 mb-4">
                                        <p class="text-white/30 text-xs">
                                            📚 {{ $apunte->asignatura->nombre ?? '-' }} · {{ $apunte->curso->nombre ?? '-' }}
                                        </p>
                                        <p class="text-white/30 text-xs">
                                            🏫 {{ $apunte->centro->nombre ?? '-' }}
                                        </p>
                                        <p class="text-white/30 text-xs">
                                            👤 {{ $apunte->user->name ?? 'Anónimo' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Footer de la tarjeta --}}
                                <div class="flex items-center justify-between pt-4 border-t border-white/10">
                                    <div class="flex items-center gap-3">
                                        {{-- Valoración --}}
                                        <span class="text-yellow-400 text-xs font-bold">
                                            ⭐ {{ number_format($apunte->valoracion_media, 1) }}
                                        </span>
                                        {{-- Descargas --}}
                                        <span class="text-white/20 text-xs">
                                            📥 {{ $apunte->total_descargas }}
                                        </span>
                                    </div>
                                    {{-- Coste --}}
                                    <span class="text-orange-500 font-black text-sm">
                                        {{ $apunte->coste_puntos }} pts
                                    </span>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    {{-- Paginación --}}
                    @if($apuntes->hasPages())
                        <div class="mt-8 flex justify-center gap-2">
                            @if($apuntes->onFirstPage())
                                <span class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white/20 text-sm">← Anterior</span>
                            @else
                                <a href="{{ $apuntes->previousPageUrl() }}" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white/60 hover:text-white hover:border-orange-500/40 transition text-sm">← Anterior</a>
                            @endif

                            @foreach($apuntes->getUrlRange(1, $apuntes->lastPage()) as $page => $url)
                                <a href="{{ $url }}" class="px-4 py-2 rounded-xl text-sm transition
                                    {{ $page == $apuntes->currentPage() ? 'bg-orange-600 text-white font-bold' : 'bg-white/5 border border-white/10 text-white/60 hover:text-white hover:border-orange-500/40' }}">
                                    {{ $page }}
                                </a>
                            @endforeach

                            @if($apuntes->hasMorePages())
                                <a href="{{ $apuntes->nextPageUrl() }}" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white/60 hover:text-white hover:border-orange-500/40 transition text-sm">Siguiente →</a>
                            @else
                                <span class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white/20 text-sm">Siguiente →</span>
                            @endif
                        </div>
                    @endif

                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>