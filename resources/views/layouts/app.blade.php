<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIEI UAEMex - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-uaemex-dark { background-color: #1b393b; }
        .bg-uaemex { background-color: #0d5c41; }
        .text-uaemex { color: #0d5c41; }
        .btn-uaemex { background-color: #0d5c41; }
        .sidebar-active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #d4af37;
        }
        .text-gold { color: #d4af37; }
        .bg-gold { background-color: #d4af37; }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-uaemex-dark text-white flex flex-col shadow-2xl z-20">
        <div class="p-6 flex items-center gap-3">
            <div class="bg-gold text-uaemex-dark font-bold p-2 rounded-lg h-10 w-10 flex items-center justify-center text-xl">UA</div>
            <div>
                <h1 class="text-lg font-bold tracking-wide">SIEI UAEMex</h1>
            </div>
        </div>

        <nav class="flex-1 px-4 space-y-4 mt-4 overflow-y-auto">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase mb-3 px-2 tracking-wider">Principal</p>
                <div class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'sidebar-active' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }} rounded-r-lg text-white font-medium transition-all duration-200">
                        <i class="fas fa-chart-pie w-5"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('surveys.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('surveys.*') ? 'sidebar-active' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }} rounded-r-lg transition-all duration-200">
                        <i class="fas fa-clipboard-list w-5"></i>
                        Encuestas
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-r-lg transition-all duration-200 border-l-4 border-transparent">
                        <i class="fas fa-chart-line w-5"></i>
                        Estadísticas
                    </a>
                </div>
            </div>

            <div>
                <p class="text-xs font-bold text-gray-400 uppercase mb-3 px-2 tracking-wider">Gestión</p>
                <div class="space-y-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-r-lg transition-all duration-200 border-l-4 border-transparent">
                        <i class="fas fa-book w-5"></i>
                        Bitácora
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-r-lg transition-all duration-200 border-l-4 border-transparent">
                        <i class="fas fa-users w-5"></i>
                        Usuarios
                    </a>
                </div>
            </div>

            <div>
                <p class="text-xs font-bold text-gray-400 uppercase mb-3 px-2 tracking-wider">Configuración</p>
                <div class="space-y-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-r-lg transition-all duration-200 border-l-4 border-transparent">
                        <i class="fas fa-calendar-alt w-5"></i>
                        Períodos
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-r-lg transition-all duration-200 border-l-4 border-transparent">
                        <i class="fas fa-cog w-5"></i>
                        Ajustes
                    </a>
                </div>
            </div>
        </nav>

        <div class="p-4 bg-white/5 m-4 rounded-xl border border-white/10">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-full bg-gold flex items-center justify-center text-uaemex-dark font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400">Administrador</p>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 text-red-300 hover:text-red-100 text-xs font-bold uppercase tracking-wider transition pt-2 border-t border-white/10">
                    <div class="w-1 h-4 bg-red-400 rounded-full"></div> Cerrar Sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-gray-50">
        <div class="p-8 space-y-8 max-w-7xl mx-auto w-full">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
