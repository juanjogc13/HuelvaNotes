<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HuelvaNotes | Nueva Contraseña</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="antialiased bg-black text-white">
    <div class="relative min-h-screen flex items-center justify-center p-6">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('img/foto-login2.jpg') }}" class="w-full h-full object-cover" alt="Huelva">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-[6px]"></div>
        </div>

        <div class="relative z-10 w-full max-w-md">
            <div class="bg-black/60 backdrop-blur-2xl rounded-[3rem] p-10 md:p-14 border border-white/10 shadow-2xl">
                
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-black tracking-tighter text-orange-500">
                        HUELVA<span class="text-white">NOTES</span>
                    </h1>
                    <p class="text-[10px] font-black text-white/40 uppercase tracking-[0.4em] mt-3 italic">Actualiza tus credenciales</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Confirmar Email</label>
                        <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white/50 focus:outline-none border-white/5 cursor-not-allowed" readonly>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Nueva Contraseña</label>
                        <input type="password" name="password" required class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300" placeholder="••••••••">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-2 ml-1">Repetir Contraseña</label>
                        <input type="password" name="password_confirmation" required class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300" placeholder="••••••••">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-orange-600 text-white font-black rounded-2xl hover:bg-orange-500 shadow-2xl shadow-orange-900/40 transform active:scale-95 transition-all uppercase tracking-widest text-xs">
                            Restablecer Contraseña
                        </button>
                    </div>
                </form>

            </div>
            
            <p class="text-center mt-8 text-white/20 text-[9px] uppercase tracking-[0.5em]">
                Seguridad garantizada por HuelvaNotes
            </p>
        </div>
    </div>
</body>
</html>