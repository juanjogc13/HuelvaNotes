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

    {{-- Navbar principal con logo, buscador y avatar --}}
    <nav class="border-b border-white/10 px-8 py-4 flex items-center justify-between gap-6">
        <div class="flex items-center gap-6 shrink-0">
            <a href="/dashboard" class="text-xl font-black tracking-tighter">
                <span class="text-orange-500">HUELVA</span><span class="text-white">NOTES</span>
            </a>

            <a href="{{ route('apuntes.index') }}"
                class="text-[10px] font-bold text-orange-500 uppercase tracking-widest hidden sm:block">
                Explorar
            </a>

            @if(in_array(Auth::user()->rol, ['admin', 'moderador']))
                <a href="{{ route('moderacion.index') }}"
                    class="text-[10px] font-bold text-white/40 uppercase tracking-widest hover:text-orange-500 transition hidden sm:block">
                    Solicitudes
                </a>
            @endif
        </div>

        {{-- Buscador por título en la navbar --}}
        <form action="{{ route('apuntes.index') }}" method="GET" class="flex-1 max-w-2xl">
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Busca apuntes, asignaturas, centros..."
                    class="w-full pl-11 pr-6 py-3 bg-white/5 border border-white/10 rounded-2xl text-white text-sm placeholder-white/20 focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300">
            </div>
        </form>

        {{-- Avatar con dropdown de usuario --}}
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
                <svg class="w-4 h-4 text-white/30 group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- Menú desplegable del usuario --}}
            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-3 w-52 bg-black border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50"
                style="display: none;">
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

                @if(in_array(Auth::user()->rol, ['admin', 'moderador']))
                    <a href="{{ route('moderacion.index') }}" class="flex items-center gap-3 px-5 py-3 text-orange-500 hover:text-orange-400 hover:bg-white/5 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/>
                        </svg>
                        Solicitudes
                    </a>
                @endif

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

        @if(session('status') === 'apunte-eliminado')
            <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-4 mb-6 flex items-center gap-3">
                <span class="text-red-400 text-lg">🗑️</span>
                <div>
                    <p class="text-red-400 text-sm font-bold">Apunte eliminado correctamente.</p>
                    <p class="text-red-400/60 text-xs mt-0.5">Se ha borrado el apunte y sus datos relacionados.</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-4 mb-6 flex items-center gap-3">
                <span class="text-red-400 text-lg">⚠️</span>
                <div>
                    <p class="text-red-400 text-sm font-bold">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="flex gap-6">

            {{-- Barra lateral de filtros --}}
            <form method="GET" action="{{ route('apuntes.index') }}" class="w-64 shrink-0 space-y-4">

                {{-- Indicador de filtros activos con botón de limpiar --}}
                @if(request()->hasAny(['nivel_id', 'curso_id', 'asignatura_id', 'centro_id', 'formato', 'q']))
                    <div class="bg-orange-500/10 border border-orange-500/30 rounded-2xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest">Filtros activos</p>
                            <a href="{{ route('apuntes.index') }}" class="text-[10px] text-white/40 hover:text-orange-500 uppercase tracking-widest transition">Limpiar</a>
                        </div>
                        <p class="text-white/40 text-xs">Mostrando resultados filtrados</p>
                    </div>
                @endif

                {{-- Filtro por nivel educativo --}}
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

                {{-- Filtro por curso --}}
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

                {{-- Filtro por asignatura --}}
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

                {{-- Filtro por centro educativo --}}
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

                {{-- Filtro por formato de archivo --}}
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

                <button type="submit"
                    class="w-full py-4 bg-orange-600 hover:bg-orange-500 text-white font-black rounded-2xl transition uppercase tracking-widest text-xs">
                    Aplicar filtros
                </button>

            </form>

            {{-- Grid de tarjetas de apuntes --}}
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

                            {{-- Cada tarjeta tiene su propio estado Alpine para el modal --}}
                            <div x-data="{ open: false }">

                                {{-- TARJETA — al hacer click abre el modal --}}
                                <div @click="open = true"
                                    class="bg-white/5 border border-white/10 rounded-3xl p-6 hover:border-orange-500/30 transition-all duration-300 group flex flex-col justify-between cursor-pointer h-full">
                                    <div>
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center gap-2">
                                                {{-- Badge de formato con color según tipo --}}
                                                <span class="px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-widest
                                                    {{ $apunte->formato === 'pdf' ? 'bg-red-500/20 text-red-400' :
                                                       ($apunte->formato === 'docx' || $apunte->formato === 'doc' ? 'bg-blue-500/20 text-blue-400' :
                                                       ($apunte->formato === 'pptx' || $apunte->formato === 'ppt' ? 'bg-orange-500/20 text-orange-400' :
                                                       'bg-green-500/20 text-green-400')) }}">
                                                    {{ strtoupper($apunte->formato) }}
                                                </span>

                                                <span class="text-white/20 text-xs">{{ $apunte->created_at->diffForHumans() }}</span>
                                            </div>

                                            @if($apunte->user_id === Auth::id() || Auth::user()->rol === 'admin')
                                                <form method="POST"
                                                      action="{{ route('apuntes.destroy', $apunte->id) }}"
                                                      @click.stop
                                                      onsubmit="return confirm('¿Seguro que quieres borrar este apunte? Esta acción no se puede deshacer.');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="w-8 h-8 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 hover:bg-red-500 hover:text-white transition flex items-center justify-center"
                                                        title="Borrar apunte">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m3 0V5a1 1 0 011-1h2a1 1 0 011 1v2"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        <h3 class="text-white font-black text-base leading-snug mb-2 group-hover:text-orange-500 transition">
                                            {{ $apunte->titulo }}
                                        </h3>

                                        @if($apunte->descripcion)
                                            <p class="text-white/30 text-xs leading-relaxed mb-4 line-clamp-2">{{ $apunte->descripcion }}</p>
                                        @endif

                                        <div class="space-y-1 mb-4">
                                            <p class="text-white/30 text-xs">📚 {{ $apunte->asignatura->nombre ?? '-' }} · {{ $apunte->curso->nombre ?? '-' }}</p>
                                            <p class="text-white/30 text-xs">🏫 {{ $apunte->centro->nombre ?? '-' }}</p>
                                            <p class="text-white/30 text-xs">👤 {{ $apunte->user->name ?? 'Anónimo' }}</p>
                                        </div>
                                    </div>

                                    <div class="pt-4 border-t border-white/10">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center gap-3">
                                                <span class="text-yellow-400 text-xs font-bold">⭐ {{ number_format($apunte->valoracion_media, 1) }}</span>
                                                <span class="text-white/20 text-xs">📥 {{ $apunte->total_descargas }}</span>
                                            </div>
                                            <span class="text-orange-500 font-black text-sm">{{ $apunte->coste_puntos }} pts</span>
                                        </div>

                                        {{-- Estado del botón según si es tuyo, ya descargado o disponible --}}
                                        @if($apunte->user_id === Auth::id())
                                            <span class="w-full block text-center py-2 text-white/20 text-xs uppercase tracking-widest">Tu apunte</span>
                                        @elseif($user->descargas()->where('apunte_id', $apunte->id)->exists())
                                            <div class="w-full py-2 bg-green-500/10 border border-green-500/30 text-green-400 font-bold rounded-xl text-xs uppercase tracking-widest text-center">
                                                ✅ Ya descargado
                                            </div>
                                        @else
                                            <div class="w-full py-2 bg-orange-600 text-white font-black rounded-xl text-xs uppercase tracking-widest text-center">
                                                📥 Descargar · {{ $apunte->coste_puntos }} pts
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- MODAL — se abre al hacer click en la tarjeta --}}
                                <div x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    @keydown.escape.window="open = false"
                                    class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                    style="display: none;">

                                    {{-- Fondo oscuro que cierra el modal al hacer click --}}
                                    <div @click="open = false" class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>

                                    {{-- Contenido del modal --}}
                                    <div class="relative bg-gray-950 border border-white/10 rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        @click.stop>

                                        {{-- Cabecera del modal --}}
                                        <div class="p-8 border-b border-white/10">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-3 mb-3">
                                                        <span class="px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-widest
                                                            {{ $apunte->formato === 'pdf' ? 'bg-red-500/20 text-red-400' :
                                                               ($apunte->formato === 'docx' || $apunte->formato === 'doc' ? 'bg-blue-500/20 text-blue-400' :
                                                               ($apunte->formato === 'pptx' || $apunte->formato === 'ppt' ? 'bg-orange-500/20 text-orange-400' :
                                                               'bg-green-500/20 text-green-400')) }}">
                                                            {{ strtoupper($apunte->formato) }}
                                                        </span>
                                                        <span class="text-white/30 text-xs">{{ $apunte->created_at->format('d/m/Y') }}</span>
                                                    </div>
                                                    <h2 class="text-2xl font-black text-white tracking-tighter">{{ $apunte->titulo }}</h2>
                                                </div>

                                                <button @click="open = false" class="text-white/30 hover:text-white transition shrink-0">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Cuerpo del modal --}}
                                        <div class="p-8 space-y-6">

                                            @if($apunte->descripcion)
                                                <div>
                                                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2">Descripción</p>
                                                    <p class="text-white/60 text-sm leading-relaxed">{{ $apunte->descripcion }}</p>
                                                </div>
                                            @endif

                                            <div class="grid grid-cols-2 gap-4">
                                                <div class="bg-white/5 rounded-2xl p-4">
                                                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-1">Asignatura</p>
                                                    <p class="text-white text-sm font-semibold">{{ $apunte->asignatura->nombre ?? '-' }}</p>
                                                </div>
                                                <div class="bg-white/5 rounded-2xl p-4">
                                                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-1">Curso</p>
                                                    <p class="text-white text-sm font-semibold">{{ $apunte->curso->nombre ?? '-' }}</p>
                                                </div>
                                                <div class="bg-white/5 rounded-2xl p-4">
                                                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-1">Nivel</p>
                                                    <p class="text-white text-sm font-semibold">{{ $apunte->nivel->nombre ?? '-' }}</p>
                                                </div>
                                                <div class="bg-white/5 rounded-2xl p-4">
                                                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-1">Centro</p>
                                                    <p class="text-white text-sm font-semibold">{{ $apunte->centro->nombre ?? '-' }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-4 bg-white/5 rounded-2xl p-4">
                                                <div class="w-10 h-10 rounded-full overflow-hidden bg-orange-500 flex items-center justify-center font-black text-black text-sm shrink-0">
                                                    @if($apunte->user && $apunte->user->foto)
                                                        <img src="{{ Storage::url($apunte->user->foto) }}" class="w-full h-full object-cover">
                                                    @else
                                                        {{ strtoupper(substr($apunte->user->name ?? 'A', 0, 1)) }}
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest">Subido por</p>
                                                    <p class="text-white text-sm font-semibold">{{ $apunte->user->name ?? 'Anónimo' }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-6">
                                                <div class="text-center">
                                                    <p class="text-yellow-400 text-xl font-black">{{ number_format($apunte->valoracion_media, 1) }}</p>
                                                    <p class="text-white/30 text-[10px] uppercase tracking-widest">Valoración</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-white text-xl font-black">{{ $apunte->total_descargas }}</p>
                                                    <p class="text-white/30 text-[10px] uppercase tracking-widest">Descargas</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-orange-500 text-xl font-black">{{ $apunte->coste_puntos }}</p>
                                                    <p class="text-white/30 text-[10px] uppercase tracking-widest">Puntos</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-white text-xl font-black">{{ $apunte->valoraciones->count() }}</p>
                                                    <p class="text-white/30 text-[10px] uppercase tracking-widest">Reseñas</p>
                                                </div>
                                            </div>

                                            {{-- Botón de descarga --}}
                                            <div>
                                                @if($apunte->user_id === Auth::id())
                                                    <div class="w-full py-4 bg-white/5 border border-white/10 rounded-2xl text-center text-white/30 text-xs uppercase tracking-widest">
                                                        Este es tu apunte
                                                    </div>
                                                @elseif($user->descargas()->where('apunte_id', $apunte->id)->exists())
                                                    <form method="POST" action="{{ route('apuntes.download', $apunte->id) }}" @click.stop>
                                                        @csrf
                                                        <button type="submit" class="w-full py-4 bg-green-500/10 border border-green-500/30 text-green-400 font-black rounded-2xl text-xs uppercase tracking-widest hover:bg-green-500/20 transition">
                                                            ✅ Descargar de nuevo — gratis
                                                        </button>
                                                    </form>
                                                @elseif($user->puntos >= $apunte->coste_puntos)
                                                    <form method="POST" action="{{ route('apuntes.download', $apunte->id) }}" @click.stop>
                                                        @csrf
                                                        <button type="submit" class="w-full py-4 bg-orange-600 hover:bg-orange-500 text-white font-black rounded-2xl text-xs uppercase tracking-widest transition active:scale-95 shadow-xl shadow-orange-900/40">
                                                            📥 Descargar · {{ $apunte->coste_puntos }} pts
                                                        </button>
                                                    </form>
                                                @else
                                                    <div class="w-full py-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-center text-red-400 text-xs uppercase tracking-widest">
                                                        ❌ Puntos insuficientes — necesitas {{ $apunte->coste_puntos }} pts
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Formulario de valoración --}}
                                            @if($apunte->user_id !== Auth::id() && $user->descargas()->where('apunte_id', $apunte->id)->exists())
                                                @php
                                                    $yaValorado = \App\Models\Valoracion::where('user_id', Auth::id())->where('apunte_id', $apunte->id)->exists();
                                                @endphp

                                                @if(!$yaValorado)
                                                    <div class="bg-white/5 rounded-2xl p-5">
                                                        <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-4">Valora este apunte</p>
                                                        <form method="POST" action="{{ route('apuntes.valorar', $apunte->id) }}" @click.stop x-data="{ stars: 0 }">
                                                            @csrf
                                                            <div class="flex gap-2 mb-4">
                                                                <input type="hidden" name="puntuacion" :value="stars">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <button type="button" @click="stars = {{ $i }}"
                                                                        class="text-3xl transition"
                                                                        :class="stars >= {{ $i }} ? 'text-yellow-400' : 'text-white/20'">
                                                                        ★
                                                                    </button>
                                                                @endfor
                                                            </div>

                                                            <textarea name="comentario" rows="2" placeholder="Comentario opcional..."
                                                                class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white text-sm placeholder-white/20 focus:outline-none focus:border-orange-500/50 transition mb-3 resize-none"></textarea>

                                                            <button type="submit" class="w-full py-3 bg-white/10 hover:bg-white/20 text-white font-black rounded-xl text-xs uppercase tracking-widest transition">
                                                                Enviar valoración
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="bg-green-500/10 border border-green-500/20 rounded-2xl p-4 text-center">
                                                        <p class="text-green-400 text-xs uppercase tracking-widest font-bold">✅ Ya has valorado este apunte</p>
                                                    </div>
                                                @endif
                                            @elseif($apunte->user_id !== Auth::id())
                                                <div class="bg-white/5 rounded-2xl p-4 text-center">
                                                    <p class="text-white/30 text-xs uppercase tracking-widest">Descarga el apunte para poder valorarlo</p>
                                                </div>
                                            @endif

                                            {{-- Lista de valoraciones existentes --}}
                                            @if($apunte->valoraciones->count() > 0)
                                                <div>
                                                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-4">Valoraciones</p>
                                                    <div class="space-y-3">
                                                        @foreach($apunte->valoraciones->take(3) as $valoracion)
                                                            <div class="bg-white/5 rounded-2xl p-4">
                                                                <div class="flex items-center justify-between mb-2">
                                                                    <p class="text-white text-xs font-bold">{{ $valoracion->usuario->name ?? 'Anónimo' }}</p>
                                                                    <div class="flex gap-0.5">
                                                                        @for($i = 1; $i <= 5; $i++)
                                                                            <span class="{{ $i <= $valoracion->puntuacion ? 'text-yellow-400' : 'text-white/10' }} text-xs">★</span>
                                                                        @endfor
                                                                    </div>
                                                                </div>
                                                                @if($valoracion->comentario)
                                                                    <p class="text-white/40 text-xs">{{ $valoracion->comentario }}</p>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
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