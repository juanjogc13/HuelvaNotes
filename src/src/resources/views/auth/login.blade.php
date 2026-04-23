<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HuelvaNotes | Acceso</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="antialiased bg-black text-white">
    <div class="relative min-h-screen flex items-center justify-center">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('img/foto-login2.jpg') }}" class="w-full h-full object-cover" alt="Huelva">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-[4px]"></div>
        </div>

        <div class="relative z-10 w-full max-w-md p-6">
            <div class="bg-black/60 backdrop-blur-2xl rounded-[3rem] p-12 border border-white/10 shadow-[0_0_50px_rgba(0,0,0,1)]">
                
                <div class="text-center mb-12">
                    <h1 class="text-3xl font-black tracking-tighter text-orange-500">
                        HUELVA<span class="text-white">NOTES</span>
                    </h1>
                    <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.4em] mt-3 italic">Toda Huelva, un solo sitio</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-3 ml-1">Email o Usuario</label>
                        <input type="email" name="email" required class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300" placeholder="tu@email.com">
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-3 ml-1">
                            <label class="text-[10px] font-bold text-orange-500 uppercase tracking-widest">Contraseña</label>
                            <a href="{{ route('password.request') }}" class="text-[9px] font-bold text-white/40 uppercase hover:text-orange-500 transition">¿La has olvidado?</a>
                        </div>
                        <input type="password" name="password" required class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300" placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full py-5 bg-orange-600 text-white font-black rounded-2xl hover:bg-orange-500 shadow-2xl shadow-orange-900/40 transform active:scale-95 transition-all uppercase tracking-widest text-xs">
                        Entrar ahora
                    </button>
                </form>

                <div class="mt-12 text-center">
                    <a href="{{ route('register') }}" class="text-[10px] font-bold text-white/40 uppercase tracking-widest hover:text-orange-500 transition">¿Eres nuevo? Crea tu cuenta aquí</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>