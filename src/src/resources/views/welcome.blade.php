<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HuelvaNotes | La red de estudiantes de Huelva</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#0a0a0a] text-white overflow-x-hidden">

    <nav class="fixed w-full z-50 bg-black/60 backdrop-blur-xl border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="text-2xl font-black tracking-tighter text-orange-500">
                HUELVA<span class="text-white">NOTES</span>
            </div>
            <div class="flex items-center space-x-6 text-sm font-bold">
                <a href="{{ route('login') }}" class="text-white/60 hover:text-orange-500 transition">Entrar</a>
                <a href="{{ route('register') }}" class="px-6 py-2.5 bg-orange-600 text-white rounded-full hover:bg-orange-500 shadow-lg shadow-orange-900/20 transition">Regístrate</a>
            </div>
        </div>
    </nav>

    <section class="relative pt-48 pb-32 px-6 overflow-hidden">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center relative z-10">
            <div class="space-y-8">
                <div class="inline-block px-4 py-1.5 bg-orange-500/10 border border-orange-500/20 rounded-full">
                    <span class="text-xs font-bold text-orange-500 uppercase tracking-widest italic">Por y para los choqueros.</span>
                </div>
                <h1 class="text-6xl md:text-7xl font-extrabold leading-tight tracking-tighter">
                    Tu éxito empieza <span class="text-orange-500">compartiendo</span>.
                </h1>
                <p class="text-xl text-white/50 max-w-lg leading-relaxed">
                    Da igual qué estudies o dónde estés. Sube tus recursos, ayuda a otros estudiantes de Huelva y consigue lo que necesitas para aprobar.
                </p>
                <a href="{{ route('register') }}" class="inline-block px-10 py-5 bg-orange-600 text-white font-black rounded-2xl hover:bg-orange-500 shadow-2xl shadow-orange-600/20 transition uppercase tracking-widest text-sm">
                    Empezar ahora
                </a>
            </div>
            <div class="relative">
                <div class="absolute -inset-1 bg-orange-500/20 blur-2xl rounded-full"></div>
                <img src="{{ asset('img/FotoWelcome1.jpg') }}" class="relative rounded-[3rem] shadow-2xl border border-white/10 w-full h-[450px] object-cover">
            </div>
        </div>
    </section>

    <section class="py-24 px-6 bg-[#0f0f0f]">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-20 items-center">
            <img src="{{ asset('img/FotoWelcome2.jpg') }}" class="rounded-[2.5rem] shadow-2xl border border-white/5 h-[400px] w-full object-cover grayscale hover:grayscale-0 transition duration-700">
            <div class="space-y-6">
                <div class="inline-block px-3 py-1 bg-white/5 rounded-lg text-xs font-bold text-orange-400 uppercase tracking-tighter">Conexión Local</div>
                <h2 class="text-4xl font-black tracking-tight italic">Unidos por el estudio.</h2>
                <p class="text-lg text-white/60 leading-relaxed">
                    Desde la capital hasta el último rincón de la provincia. HuelvaNotes es el punto de encuentro para todos los que buscan mejorar sus notas y compartir su conocimiento.
                </p>
                <div class="h-1 w-20 bg-orange-600"></div>
            </div>
        </div>
    </section>

    <section class="py-32 px-6">
        <div class="max-w-7xl mx-auto bg-gradient-to-br from-orange-600 to-orange-800 rounded-[4rem] p-12 lg:p-20 relative overflow-hidden text-center lg:text-left">
            <div class="grid lg:grid-cols-2 gap-12 items-center relative z-10">
                <div class="space-y-8">
                    <h2 class="text-5xl font-black tracking-tighter leading-none italic">Todo Huelva en tu mochila.</h2>
                    <p class="text-orange-100 text-lg opacity-80">Encuentra exámenes, resúmenes y esquemas de cualquier centro, instituto o facultad de la provincia.</p>
                    <a href="{{ route('register') }}" class="inline-block px-10 py-5 bg-black text-white font-black rounded-2xl hover:bg-zinc-900 transition shadow-2xl uppercase tracking-widest text-sm">
                        Unirse gratis
                    </a>
                </div>
                <img src="{{ asset('img/FotoWelcome3.webp') }}" class="rounded-[2.5rem] shadow-2xl border-4 border-white/20 h-[350px] w-full object-cover rotate-2">
            </div>
        </div>
    </section>

    <footer class="py-20 border-t border-white/5 text-center">
        <div class="max-w-7xl mx-auto px-6 space-y-8">
            <div class="text-2xl font-black text-orange-500 tracking-tighter">HUELVA<span class="text-white">NOTES</span></div>
            <p class="text-white/20 text-xs italic tracking-widest uppercase font-bold">"La red de todos los estudiantes de Huelva"</p>
            <div class="flex justify-center space-x-12 text-[10px] font-bold text-white/30 uppercase tracking-[0.3em]">
                <a href="#" class="hover:text-orange-500 transition">Privacidad</a>
                <a href="#" class="hover:text-orange-500 transition">Términos</a>
                <a href="#" class="hover:text-orange-500 transition">Contacto</a>
            </div>
        </div>
    </footer>

</body>
</html>