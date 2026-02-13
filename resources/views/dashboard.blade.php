@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Header Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>
            <p class="text-gray-500 mt-1">Resumen de evaluaciones 2025 • <span class="font-semibold text-gray-700">3 activas, 0 inactivas</span></p>
        </div>
        <a href="{{ route('surveys.create') }}" class="bg-uaemex text-white px-6 py-3 rounded-lg shadow-lg shadow-green-900/20 hover:bg-green-800 transition font-bold flex items-center gap-2">
            <i class="fas fa-plus"></i> Nueva Encuesta
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-wrap gap-4 items-center">
        <div class="flex items-center gap-3 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
            <label class="text-sm font-bold text-gray-600">Año:</label>
            <select class="bg-transparent text-sm font-medium focus:outline-none text-gray-800">
                <option>2025</option>
                <option>2024</option>
            </select>
        </div>
        <div class="flex items-center gap-3 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
            <label class="text-sm font-bold text-gray-600">Estado:</label>
            <select class="bg-transparent text-sm font-medium focus:outline-none text-gray-800">
                <option>Todas</option>
                <option>Activas</option>
            </select>
        </div>
        
        <button class="text-uaemex text-sm font-bold border border-uaemex px-4 py-1.5 rounded-lg hover:bg-uaemex hover:text-white transition flex items-center gap-2">
            <i class="fas fa-sync-alt"></i> Resetear
        </button>

        <div class="ml-auto bg-gold/10 text-yellow-700 px-4 py-1.5 rounded-full text-sm font-bold border border-gold/30 flex items-center gap-2">
            <i class="far fa-calendar-alt"></i> Mostrando: 2025
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-orange-50 rounded-xl text-orange-400 shadow-sm">
                    <i class="fas fa-clipboard text-xl"></i>
                </div>
                <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                    <i class="fas fa-arrow-up"></i> 50%
                </span>
            </div>
            <h3 class="text-4xl font-bold text-gray-800 mb-2">3</h3>
            <p class="text-gray-500 text-sm font-medium">Encuestas 2025</p>
            <div class="mt-4 flex gap-2">
                <span class="bg-green-50 text-green-700 text-xs px-2 py-1 rounded border border-green-100 font-bold">3 activas</span>
                <span class="bg-red-50 text-red-700 text-xs px-2 py-1 rounded border border-red-100 font-bold">0 inactivas</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-blue-50 rounded-xl text-blue-400 shadow-sm">
                    <i class="fas fa-chart-bar text-xl"></i>
                </div>
                <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                    <i class="fas fa-arrow-down"></i> 40%
                </span>
            </div>
            <h3 class="text-4xl font-bold text-gray-800 mb-2">146</h3>
            <p class="text-gray-500 text-sm font-medium">Respuestas recibidas</p>
            <p class="text-xs text-gray-400 mt-1">Promedio: 49 por encuesta</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-pink-50 rounded-xl text-pink-400 shadow-sm">
                    <i class="fas fa-bullseye text-xl"></i>
                </div>
            </div>
            <h3 class="text-4xl font-bold text-gray-800 mb-2">32%</h3>
            <p class="text-gray-500 text-sm font-medium">Tasa de respuesta</p>
            <div class="w-full bg-gray-100 rounded-full h-2 mt-5">
                <div class="bg-gradient-to-r from-uaemex to-green-400 h-2 rounded-full" style="width: 32%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-2 text-right">Meta: 80%</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-gray-800">Respuestas por Encuesta</h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded">2025</span>
            </div>
            <div class="h-64 relative">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- Chart 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-gray-800">Estado de Encuestas</h3>
                <span class="bg-gray-100 text-gray-600 text-xs font-bold px-2 py-1 rounded">Activas/Inactivas</span>
            </div>
            <div class="h-64 relative flex justify-center">
                <canvas id="doughnutChart"></canvas>
            </div>
            <div class="flex justify-center gap-6 mt-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full" style="background-color: #0d5c41"></div>
                    <span class="text-xs text-gray-600 font-bold">Activas</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full" style="background-color: #d4af37"></div>
                    <span class="text-xs text-gray-600 font-bold">Inactivas</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Surveys List -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-xl text-gray-800">Encuestas Recientes</h3>
            <div class="bg-gold/10 text-yellow-700 px-4 py-1.5 rounded-full text-sm font-bold border border-gold/30 flex items-center gap-2">
                <i class="far fa-calendar-alt"></i> Mostrando: 2025
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Survey Item 1 -->
            <div class="border border-gray-200 rounded-xl p-4 hover:border-uaemex transition cursor-pointer group">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-bold text-gray-800 group-hover:text-uaemex transition">Evaluación de Tutorías 2025</h4>
                        <p class="text-xs text-gray-500 mt-1">Evaluación del Programa Institucional de Tutorías</p>
                    </div>
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded">Activa</span>
                </div>
                <div class="mt-4 flex items-center gap-4 text-xs text-gray-500">
                    <div class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded">
                        <i class="far fa-calendar text-gray-400"></i> 2025
                    </div>
                    <div class="flex items-center gap-1 bg-blue-50 text-blue-600 px-2 py-1 rounded">
                        <i class="fas fa-lock"></i> Anónima
                    </div>
                    <div class="flex items-center gap-1 bg-purple-50 text-purple-600 px-2 py-1 rounded">
                        <i class="fas fa-envelope"></i> Solicita correo
                    </div>
                </div>
            </div>

            <!-- Survey Item 2 -->
            <div class="border border-gray-200 rounded-xl p-4 hover:border-uaemex transition cursor-pointer group">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-bold text-gray-800 group-hover:text-uaemex transition">Satisfacción Estudiantil 2025</h4>
                        <p class="text-xs text-gray-500 mt-1">Evaluación de servicios escolares e infraestructura</p>
                    </div>
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded">Activa</span>
                </div>
                <div class="mt-4 flex items-center gap-4 text-xs text-gray-500">
                    <div class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded">
                        <i class="far fa-calendar text-gray-400"></i> 2025
                    </div>
                    <div class="flex items-center gap-1 bg-blue-50 text-blue-600 px-2 py-1 rounded">
                        <i class="fas fa-lock"></i> Anónima
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Bar Chart
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Evaluación Docente', 'Satisfacción Estudiantil', 'Tutorías'],
            datasets: [{
                label: 'Respuestas',
                data: [65, 45, 36],
                backgroundColor: '#4ade80',
                borderRadius: 6,
                barThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 2] } },
                x: { grid: { display: false } }
            }
        }
    });

    // Doughnut Chart
    const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
    new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: ['Activas', 'Inactivas'],
            datasets: [{
                data: [3, 1],
                backgroundColor: ['#0d5c41', '#d4af37'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush
