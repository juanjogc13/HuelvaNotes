<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HuelvaNotes | Mi Perfil</title>
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

        <div class="flex-1 max-w-2xl">
            <form action="/buscar" method="GET">
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                    <input type="text" name="q" placeholder="Busca apuntes, asignaturas, centros..."
                        class="w-full pl-11 pr-6 py-3 bg-white/5 border border-white/10 rounded-2xl text-white text-sm placeholder-white/20 focus:outline-none focus:border-orange-500/50 transition-all duration-300">
                </div>
            </form>
        </div>

        <div class="relative shrink-0" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-orange-500 flex items-center justify-center font-black text-black text-sm">
                    @if($user->foto)
                        <img src="{{ Storage::url($user->foto) }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div class="text-left hidden sm:block">
                    <p class="text-white text-xs font-bold">{{ $user->name }}</p>
                    <p class="text-orange-500 text-[10px] uppercase tracking-widest">{{ $user->puntos }} pts</p>
                </div>
                <svg class="w-4 h-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-3 w-52 bg-black border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50">
                <div class="px-5 py-4 border-b border-white/10">
                    <p class="text-white text-sm font-bold">{{ $user->name }}</p>
                    <p class="text-white/30 text-xs">{{ $user->email }}</p>
                </div>
                <a href="/profile" class="flex items-center gap-3 px-5 py-3 text-orange-500 hover:bg-white/5 transition text-sm font-bold">
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

    <div class="max-w-5xl mx-auto px-6 py-10">

        {{-- Cabecera --}}
        <div class="mb-10">
            <h2 class="text-3xl font-black tracking-tighter">Mi <span class="text-orange-500">Perfil</span></h2>
            <p class="text-white/30 text-sm mt-1 uppercase tracking-widest">Gestiona tu cuenta y preferencias</p>
        </div>

        {{-- Mensajes de éxito --}}
        @if(session('status') === 'perfil-actualizado')
            <div class="bg-green-500/10 border border-green-500/30 rounded-2xl p-4 mb-6">
                <p class="text-green-400 text-sm">✅ Perfil actualizado correctamente.</p>
            </div>
        @endif
        @if(session('status') === 'password-actualizado')
            <div class="bg-green-500/10 border border-green-500/30 rounded-2xl p-4 mb-6">
                <p class="text-green-400 text-sm">✅ Contraseña actualizada correctamente.</p>
            </div>
        @endif

        {{-- Errores --}}
        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-4 mb-6">
                @foreach($errors->all() as $error)
                    <p class="text-red-400 text-xs">• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Columna izquierda: foto y estadísticas --}}
            <div class="space-y-4">

                {{-- Foto de perfil --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-8 text-center">
                    <div class="w-24 h-24 rounded-full overflow-hidden bg-orange-500 flex items-center justify-center font-black text-black text-3xl mx-auto mb-4">
                        @if($user->foto)
                            <img src="{{ Storage::url($user->foto) }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <p class="text-white font-bold">{{ $user->name }}</p>
                    <p class="text-white/30 text-xs mt-1">{{ $user->email }}</p>
                    @if($user->centro)
                        <p class="text-orange-500 text-xs mt-2">{{ $user->centro->nombre }}</p>
                    @endif

                    {{-- Formulario para cambiar foto --}}
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="centro_id" value="{{ $user->centro_id }}">
                        <label class="cursor-pointer">
                            <span class="text-[10px] font-bold text-orange-500 uppercase tracking-widest border border-orange-500/30 rounded-xl px-4 py-2 hover:bg-orange-500/10 transition">
                                Cambiar foto
                            </span>
                            <input type="file" name="foto" accept="image/*" class="hidden" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>

                {{-- Estadísticas --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6">
                    <h3 class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-4">Tus estadísticas</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-white/40 text-sm">Puntos</span>
                            <span class="text-orange-500 font-black">{{ $user->puntos }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-white/40 text-sm">Apuntes subidos</span>
                            <span class="text-white font-bold">{{ $totalApuntes }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-white/40 text-sm">Descargas realizadas</span>
                            <span class="text-white font-bold">{{ $totalDescargas }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-white/40 text-sm">Valoración media</span>
                            <span class="text-white font-bold">{{ number_format($valoracionMedia, 1) }} ⭐</span>
                        </div>
                    </div>
                </div>

                {{-- Historial de puntos --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6">
                    <h3 class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-4">Últimos movimientos</h3>
                    @forelse($historialPuntos as $t)
                        <div class="flex justify-between items-center py-2 border-b border-white/5">
                            <span class="text-white/40 text-xs capitalize">{{ $t->tipo }}</span>
                            <span class="font-bold text-sm {{ $t->cantidad > 0 ? 'text-green-400' : 'text-red-400' }}">
                                {{ $t->cantidad > 0 ? '+' : '' }}{{ $t->cantidad }} pts
                            </span>
                        </div>
                    @empty
                        <p class="text-white/30 text-sm">Sin movimientos aún.</p>
                    @endforelse
                </div>

            </div>

            {{-- Columna derecha: formularios --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Datos personales --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-8">
                    <h3 class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-6">Datos personales</h3>
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 transition-all duration-300">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 transition-all duration-300">
                        </div>

                        {{-- Selector de centro --}}
                        <div x-data="{
                            open: false,
                            search: '',
                            selected: '{{ $user->centro ? $user->centro->localidad . ' · ' . $user->centro->nombre : '' }}',
                            selectedId: '{{ $user->centro_id ?? '' }}',
                            centros: {{ $centros->map(fn($c) => ['id' => $c->id, 'nombre' => $c->nombre, 'localidad' => $c->localidad])->toJson() }},
                            get filtrados() {
                                if (!this.search) return this.centros;
                                return this.centros.filter(c =>
                                    (c.nombre + ' ' + c.localidad).toLowerCase().includes(this.search.toLowerCase())
                                );
                            },
                            seleccionar(centro) {
                                this.selected = centro.localidad + ' · ' + centro.nombre;
                                this.selectedId = centro.id;
                                this.open = false;
                                this.search = '';
                            }
                        }" class="relative">
                            <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Centro educativo</label>
                            <input type="hidden" name="centro_id" :value="selectedId">
                            <button type="button" @click="open = !open"
                                class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-left transition-all duration-300 relative"
                                :class="open ? 'border-orange-500/50' : 'hover:border-white/20'">
                                <span :class="selected ? 'text-white' : 'text-white/20'" class="text-sm" x-text="selected || '— Sin centro —'"></span>
                                <svg class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute z-50 w-full mt-2 bg-black border border-white/10 rounded-2xl shadow-2xl overflow-hidden">
                                <div class="p-3 border-b border-white/10">
                                    <input type="text" x-model="search" placeholder="Busca tu centro..."
                                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white text-sm placeholder-white/20 focus:outline-none">
                                </div>
                                <div class="max-h-48 overflow-y-auto">
                                    <button type="button" @click="selected = ''; selectedId = ''; open = false"
                                        class="w-full text-left px-5 py-3 text-white/30 hover:bg-white/5 text-sm transition">
                                        — Sin centro —
                                    </button>
                                    <template x-for="centro in filtrados" :key="centro.id">
                                        <button type="button" @click="seleccionar(centro)"
                                            class="w-full text-left px-5 py-3 hover:bg-white/5 transition text-sm"
                                            :class="selectedId == centro.id ? 'text-orange-500' : 'text-white/70'">
                                            <span class="text-white/30 text-xs" x-text="centro.localidad + ' ·'"></span>
                                            <span x-text="' ' + centro.nombre"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 bg-orange-600 text-white font-black rounded-2xl hover:bg-orange-500 transition uppercase tracking-widest text-xs">
                            Guardar cambios
                        </button>
                    </form>
                </div>

                {{-- Cambiar contraseña --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-8">
                    <h3 class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-6">Cambiar contraseña</h3>
                    <form method="POST" action="{{ route('profile.password') }}" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Contraseña actual</label>
                            <input type="password" name="current_password" required
                                class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 transition-all duration-300" placeholder="••••••••">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Nueva contraseña</label>
                            <input type="password" name="password" required
                                class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 transition-all duration-300" placeholder="••••••••">
                            <p class="text-white/20 text-[10px] mt-1 ml-1">Mínimo 8 caracteres, mayúscula y carácter especial</p>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Repetir nueva contraseña</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 transition-all duration-300" placeholder="••••••••">
                        </div>

                        <button type="submit" class="w-full py-4 bg-white/10 text-white font-black rounded-2xl hover:bg-white/20 transition uppercase tracking-widest text-xs">
                            Cambiar contraseña
                        </button>
                    </form>
                </div>

                {{-- Mis apuntes --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-8">
                    <h3 class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-6">📁 Mis apuntes</h3>
                    @forelse($apuntes as $apunte)
                        <div class="flex justify-between items-center border-b border-white/10 py-3">
                            <div>
                                <p class="text-white font-semibold text-sm">{{ $apunte->titulo }}</p>
                                <p class="text-white/30 text-xs mt-1">{{ $apunte->created_at->diffForHumans() }}</p>
                            </div>
                            <form method="POST" action="/apuntes/{{ $apunte->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Seguro que quieres eliminar este apunte?')"
                                    class="text-red-400 hover:text-red-300 text-xs font-bold uppercase tracking-widest transition">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-white/30 text-sm">Todavía no has subido ningún apunte.</p>
                    @endforelse
                </div>

                {{-- Favoritos --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-8">
                    <h3 class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-6">⭐ Mis favoritos</h3>
                    @forelse($favoritos as $favorito)
                        <div class="border-b border-white/10 py-3">
                            <p class="text-white font-semibold text-sm">{{ $favorito->apunte->titulo ?? 'Apunte eliminado' }}</p>
                            <p class="text-white/30 text-xs mt-1">{{ $favorito->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-white/30 text-sm">No tienes apuntes en favoritos.</p>
                    @endforelse
                </div>

                {{-- Eliminar cuenta --}}
                <div class="bg-red-500/5 border border-red-500/20 rounded-3xl p-8">
                    <h3 class="text-[10px] font-bold text-red-400 uppercase tracking-widest mb-2">Zona de peligro</h3>
                    <p class="text-white/30 text-sm mb-6">Si eliminas tu cuenta perderás todos tus apuntes, puntos y datos. Esta acción no se puede deshacer.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('¿Estás seguro? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <div class="mb-4">
                            <label class="block text-[10px] font-bold text-red-400 uppercase tracking-widest mb-2 ml-1">Confirma tu contraseña</label>
                            <input type="password" name="password" required
                                class="w-full px-6 py-4 bg-white/5 border border-red-500/20 rounded-2xl text-white focus:outline-none focus:border-red-500/50 transition-all duration-300" placeholder="••••••••">
                        </div>
                        <button type="submit" class="w-full py-4 bg-red-600 text-white font-black rounded-2xl hover:bg-red-500 transition uppercase tracking-widest text-xs">
                            Eliminar mi cuenta
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>