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
                    
                    <div>
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Nombre Completo</label>
                        <input type="text" name="name" required autofocus class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300" placeholder="Ej. Juan Pérez">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Email o Usuario</label>
                        <input type="email" name="email" required class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300" placeholder="tu@email.com">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Contraseña</label>
                            <input type="password" name="password" required class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300" placeholder="••••••••">
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
</body>
</html>