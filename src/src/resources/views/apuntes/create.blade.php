<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HuelvaNotes | Subir Apunte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="antialiased bg-black text-white min-h-screen">

    <nav class="border-b border-white/10 px-8 py-4 flex items-center justify-between gap-6">
        <div class="flex items-center gap-6 shrink-0">
            <a href="/dashboard" class="text-xl font-black tracking-tighter">
                <span class="text-orange-500">HUELVA</span><span class="text-white">NOTES</span>
            </a>

            <a href="{{ route('apuntes.index') }}"
                class="text-[10px] font-bold text-white/40 uppercase tracking-widest hover:text-orange-500 transition hidden sm:block">
                Explorar
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
                    <p class="text-orange-500 text-[10px] uppercase tracking-widest">
                        {{ $user->puntos }} pts
                        @if(in_array(Auth::user()->rol, ['admin', 'moderador']))
                            · {{ Auth::user()->rol }}
                        @endif
                    </p>
                </div>

                <svg class="w-4 h-4 text-white/30 group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-3 w-52 bg-black border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50"
                style="display: none;">
                <div class="px-5 py-4 border-b border-white/10">
                    <p class="text-white text-sm font-bold">{{ Auth::user()->name }}</p>
                    <p class="text-white/30 text-xs">{{ Auth::user()->email }}</p>
                </div>

                <a href="/profile" class="flex items-center gap-3 px-5 py-3 text-white/60 hover:text-white hover:bg-white/5 transition text-sm">
                    Mi perfil
                </a>

                <a href="/dashboard" class="flex items-center gap-3 px-5 py-3 text-white/60 hover:text-white hover:bg-white/5 transition text-sm">
                    Dashboard
                </a>

                @if(in_array(Auth::user()->rol, ['admin', 'moderador']))
                    <a href="{{ route('moderacion.index') }}" class="flex items-center gap-3 px-5 py-3 text-orange-500 hover:text-orange-400 hover:bg-white/5 transition text-sm">
                        Solicitudes
                    </a>
                @endif

                <div class="border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-red-400 hover:text-red-300 hover:bg-white/5 transition text-sm">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-6 py-10">

        <div class="mb-10">
            <a href="{{ route('dashboard') }}" class="text-white/30 text-xs uppercase tracking-widest hover:text-orange-500 transition flex items-center gap-2 mb-4">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Volver al dashboard
            </a>

            <h2 class="text-3xl font-black tracking-tighter">Subir <span class="text-orange-500">Apunte</span></h2>

            <p class="text-white/30 text-sm mt-1 uppercase tracking-widest">
                Tu apunte quedará pendiente hasta que un moderador lo apruebe
            </p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-4 mb-6">
                @foreach($errors->all() as $error)
                    <p class="text-red-400 text-xs">• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('apuntes.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Archivo --}}
            <div x-data="{
                archivo: null,
                nombre: '',
                tamanio: '',
                dragover: false,
                seleccionar(files) {
                    if (!files.length) return;
                    const f = files[0];
                    this.archivo = f;
                    this.nombre = f.name;
                    this.tamanio = (f.size / 1024 / 1024).toFixed(2) + ' MB';
                    document.getElementById('archivo-input').files = files;
                }
            }">
                <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Archivo</label>

                <div
                    @dragover.prevent="dragover = true"
                    @dragleave="dragover = false"
                    @drop.prevent="dragover = false; seleccionar($event.dataTransfer.files)"
                    @click="$refs.fileInput.click()"
                    :class="dragover ? 'border-orange-500 bg-orange-500/10' : 'border-white/10 hover:border-orange-500/40'"
                    class="relative border-2 border-dashed rounded-3xl p-10 text-center cursor-pointer transition-all duration-300">

                    <input type="file" id="archivo-input" name="archivo" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png"
                        class="hidden" x-ref="fileInput"
                        @change="seleccionar($event.target.files)">

                    <div x-show="!archivo">
                        <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <p class="text-white font-bold text-sm">Arrastra tu archivo aquí</p>
                        <p class="text-white/30 text-xs mt-1">o haz clic para seleccionarlo</p>
                        <p class="text-white/20 text-[10px] mt-3 uppercase tracking-widest">PDF · DOCX · PPTX · JPG · PNG · Máx. 15MB</p>
                    </div>

                    <div x-show="archivo" class="flex items-center justify-center gap-4" style="display: none;">
                        <div class="w-12 h-12 rounded-2xl bg-orange-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        <div class="text-left">
                            <p class="text-white font-bold text-sm" x-text="nombre"></p>
                            <p class="text-white/30 text-xs" x-text="tamanio"></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Título --}}
            <div>
                <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Título</label>
                <input type="text" name="titulo" value="{{ old('titulo') }}" required maxlength="100"
                    placeholder="Ej. Apuntes Tema 3 — Funciones"
                    class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300">
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">
                    Descripción <span class="text-white/20">(opcional)</span>
                </label>
                <textarea name="descripcion" rows="3" maxlength="500"
                    placeholder="Describe brevemente el contenido del apunte..."
                    class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300 resize-none">{{ old('descripcion') }}</textarea>
            </div>

            {{-- Centro fijo del usuario --}}
            <div class="bg-white/5 border border-white/10 rounded-2xl p-5">
                <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2">Centro educativo</p>

                <p class="text-white font-bold text-sm">
                    {{ $user->centro->localidad ?? '' }}
                    @if($user->centro)
                        ·
                    @endif
                    {{ $user->centro->nombre ?? 'Sin centro asignado' }}
                </p>

                <p class="text-white/30 text-xs mt-1">
                    Este centro se toma automáticamente de tu perfil. Si no es correcto, actualízalo desde Mi perfil.
                </p>
            </div>

            {{-- Nivel → Titulación → Curso → Asignatura --}}
            <div x-data="{
                niveles: {{ $niveles->map(fn($n) => ['id' => $n->id, 'nombre' => $n->nombre])->values()->toJson() }},
                titulaciones: {{ $titulaciones->map(fn($t) => ['id' => $t->id, 'nombre' => $t->nombre, 'nivel_id' => $t->nivel_id, 'centro_id' => $t->centro_id])->values()->toJson() }},
                cursos: {{ $cursos->map(fn($c) => ['id' => $c->id, 'nombre' => $c->nombre, 'nivel_id' => $c->nivel_id, 'titulacion_id' => $c->titulacion_id])->values()->toJson() }},
                asignaturas: {{ $asignaturas->map(fn($a) => ['id' => $a->id, 'nombre' => $a->nombre, 'curso_id' => $a->curso_id])->values()->toJson() }},

                nivelId: '{{ old('nivel_id') }}',
                titulacionId: '{{ old('titulacion_id') }}',
                cursoId: '{{ old('curso_id') }}',
                asignaturaId: '{{ old('asignatura_id') }}',

                get titulacionesFiltradas() {
                    if (!this.nivelId) return [];
                    return this.titulaciones.filter(t => t.nivel_id == this.nivelId);
                },

                get cursosFiltrados() {
                    if (!this.titulacionId) return [];
                    return this.cursos.filter(c => c.titulacion_id == this.titulacionId);
                },

                get asignaturasFiltradas() {
                    if (!this.cursoId) return [];
                    return this.asignaturas.filter(a => a.curso_id == this.cursoId);
                }
            }" class="space-y-4">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Nivel --}}
                    <div>
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Nivel</label>
                        <select name="nivel_id"
                            x-model="nivelId"
                            @change="titulacionId = ''; cursoId = ''; asignaturaId = ''"
                            required
                            class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 transition-all duration-300 appearance-none">
                            <option value="" class="bg-black">— Nivel —</option>

                            <template x-for="nivel in niveles" :key="nivel.id">
                                <option :value="nivel.id" class="bg-black" x-text="nivel.nombre"></option>
                            </template>
                        </select>
                    </div>

                    {{-- Titulación --}}
                    <div>
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">
                            Titulación / Ciclo / Carrera
                        </label>
                        <select name="titulacion_id"
                            x-model="titulacionId"
                            @change="cursoId = ''; asignaturaId = ''"
                            required
                            :disabled="!nivelId"
                            class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 transition-all duration-300 appearance-none disabled:opacity-30">
                            <option value="" class="bg-black">— Titulación —</option>

                            <template x-for="titulacion in titulacionesFiltradas" :key="titulacion.id">
                                <option :value="titulacion.id" class="bg-black" x-text="titulacion.nombre"></option>
                            </template>
                        </select>

                        <p x-show="nivelId && titulacionesFiltradas.length === 0"
                           class="text-red-400/70 text-[10px] mt-2 uppercase tracking-widest"
                           style="display: none;">
                            No hay titulaciones cargadas para tu centro y ese nivel.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Curso --}}
                    <div>
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Curso</label>
                        <select name="curso_id"
                            x-model="cursoId"
                            @change="asignaturaId = ''"
                            required
                            :disabled="!titulacionId"
                            class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 transition-all duration-300 appearance-none disabled:opacity-30">
                            <option value="" class="bg-black">— Curso —</option>

                            <template x-for="curso in cursosFiltrados" :key="curso.id">
                                <option :value="curso.id" class="bg-black" x-text="curso.nombre"></option>
                            </template>
                        </select>

                        <p x-show="titulacionId && cursosFiltrados.length === 0"
                           class="text-red-400/70 text-[10px] mt-2 uppercase tracking-widest"
                           style="display: none;">
                            No hay cursos cargados para esta titulación.
                        </p>
                    </div>

                    {{-- Asignatura --}}
                    <div>
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Asignatura</label>
                        <select name="asignatura_id"
                            x-model="asignaturaId"
                            required
                            :disabled="!cursoId"
                            class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 transition-all duration-300 appearance-none disabled:opacity-30">
                            <option value="" class="bg-black">— Asignatura —</option>

                            <template x-for="asignatura in asignaturasFiltradas" :key="asignatura.id">
                                <option :value="asignatura.id" class="bg-black" x-text="asignatura.nombre"></option>
                            </template>
                        </select>

                        <p x-show="cursoId && asignaturasFiltradas.length === 0"
                           class="text-red-400/70 text-[10px] mt-2 uppercase tracking-widest"
                           style="display: none;">
                            No hay asignaturas cargadas para este curso.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Botón --}}
            <div class="pt-4">
                <button type="submit"
                    class="w-full py-5 bg-orange-600 text-white font-black rounded-2xl hover:bg-orange-500 shadow-2xl shadow-orange-900/40 transform active:scale-95 transition-all uppercase tracking-widest text-xs flex items-center justify-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Enviar apunte a revisión
                </button>

                <p class="text-white/20 text-[10px] text-center mt-3 uppercase tracking-widest">
                    Recibirás los puntos cuando el apunte sea aprobado.
                </p>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>