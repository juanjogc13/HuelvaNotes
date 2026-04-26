<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HuelvaNotes | Crear Cuenta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="antialiased bg-black text-white">
    <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('img/foto-login2.jpg') }}" class="w-full h-full object-cover" alt="Huelva">
            <div class="absolute inset-0 bg-black/70 backdrop-blur-[5px]"></div>
        </div>

        <div class="relative z-10 w-full max-w-lg">
            <div class="bg-black/60 backdrop-blur-2xl rounded-[3rem] p-10 md:p-14 border border-white/10 shadow-[0_0_60px_rgba(0,0,0,0.8)]">
                
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-black tracking-tighter text-orange-500">
                        HUELVA<span class="text-white">NOTES</span>
                    </h1>
                    <p class="text-[10px] font-black text-white/40 uppercase tracking-[0.4em] mt-3">Únete a la red de estudiantes</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    {{-- Mensajes de error --}}
                    @if ($errors->any())
                        <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-4">
                            @foreach ($errors->all() as $error)
                                <p class="text-red-400 text-xs">• {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    
                    <div>
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Nombre Completo</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300" placeholder="Ej. Juan Pérez">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300" placeholder="tu@email.com">
                    </div>

                    {{-- Selector de centro con buscador --}}
                    <div x-data="{
                        open: false,
                        search: '',
                        selected: null,
                        selectedId: '',
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
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Tu centro educativo</label>
                        
                        <input type="hidden" name="centro_id" :value="selectedId">

                        <button type="button" @click="open = !open"
                            class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-left transition-all duration-300 focus:outline-none relative"
                            :class="open ? 'border-orange-500/50 bg-white/10' : 'hover:border-white/20'">
                            <span :class="selected ? 'text-white' : 'text-white/20'" class="text-sm">
                                <span x-text="selected || '— Selecciona tu centro (opcional) —'"></span>
                            </span>
                            <svg class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute z-50 w-full mt-2 bg-black border border-white/10 rounded-2xl shadow-2xl overflow-hidden">
                            
                            <div class="p-3 border-b border-white/10">
                                <input type="text" x-model="search" placeholder="Busca tu centro..."
                                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white text-sm placeholder-white/20 focus:outline-none focus:border-orange-500/50">
                            </div>

                            <div class="max-h-52 overflow-y-auto">
                                <button type="button" @click="selected = null; selectedId = ''; open = false"
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
                                <p x-show="filtrados.length === 0" class="text-white/30 text-sm px-5 py-3">No se encontró ningún centro.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Contraseña</label>
                            <input type="password" name="password" required class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300" placeholder="••••••••">
                            <p class="text-white/20 text-[10px] mt-1 ml-1">Mínimo 8 caracteres, mayúscula, número y símbolo</p>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Repetir</label>
                            <input type="password" name="password_confirmation" required class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-orange-600 text-white font-black rounded-2xl hover:bg-orange-500 shadow-2xl shadow-orange-900/40 transform active:scale-95 transition-all uppercase tracking-widest text-xs">
                            Crear mi cuenta
                        </button>
                    </div>
                </form>

                <div class="mt-10 text-center">
                    <p class="text-[10px] text-white/30 uppercase tracking-widest">¿Ya eres parte de HuelvaNotes?</p>
                    <a href="{{ route('login') }}" class="text-sm font-bold text-orange-500 hover:text-white transition-colors duration-300 mt-2 inline-block">Inicia sesión aquí</a>
                </div>
            </div>

            <p class="text-center mt-8 text-white/20 text-[9px] uppercase tracking-[0.5em]">
                Cualquier centro · Cualquier estudio · Toda Huelva
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>