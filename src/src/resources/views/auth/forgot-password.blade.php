<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HuelvaNotes | Recuperar Contraseña</title>
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
            <div class="bg-black/60 backdrop-blur-2xl rounded-[3rem] p-10 md:p-14 border border-white/10 shadow-2xl text-center">
                
                <div class="mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-500/10 rounded-full mb-6 border border-orange-500/20">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black tracking-tighter">¿Problemas para <span class="text-orange-500">entrar</span>?</h2>
                    <p class="text-white/50 text-sm mt-4 leading-relaxed">
                        No te preocupes. Introduce tu email y te enviaremos un enlace para que vuelvas a tu cuenta en un momento.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf
                    <div class="text-left">
                        <label class="block text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-3 ml-1">Tu Email</label>
                        <input type="email" name="email" required autofocus class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white focus:outline-none focus:border-orange-500/50 focus:bg-white/10 transition-all duration-300" placeholder="nombre@email.com">
                    </div>

                    <button type="submit" class="w-full py-5 bg-orange-600 text-white font-black rounded-2xl hover:bg-orange-500 shadow-xl shadow-orange-900/20 transition-all uppercase tracking-widest text-xs">
                        Enviar enlace de reset
                    </button>
                </form>

                <div class="mt-10">
                    <a href="{{ route('login') }}" class="text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] hover:text-orange-500 transition flex items-center justify-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                        Volver al login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>