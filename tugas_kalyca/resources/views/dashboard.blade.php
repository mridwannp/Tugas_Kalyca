@extends('layouts.app')
@section('content')
<h4 class="mb-4">Dashboard</h4>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Masukan (bulan ini)</h6>
                <h4 class="text-success">Rp {{ number_format($totalMasukan, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Keluaran (bulan ini)</h6>
                <h4 class="text-danger">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Pendapatan Bersih</h6>
                <h4 class="{{ $saldo >= 0 ? 'text-primary' : 'text-danger' }}">
                    Rp {{ number_format($saldo, 0, ',', '.') }}
                </h4>
            </div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<form id="filterForm" class="mb-3 d-flex flex-wrap gap-2 align-items-center">
    <select name="filter" id="filter" class="form-select" style="width: auto;">
        <option value="harian">Harian</option>
        <option value="mingguan">Mingguan</option>
        <option value="bulanan" selected>Bulanan</option>
        <option value="custom">Custom</option>
    </select>

    <input type="date" name="start_date" id="start_date" class="form-control" style="width: 150px; display: none;">
    <input type="date" name="end_date" id="end_date" class="form-control" style="width: 150px; display: none;">
    
    <button type="submit" class="btn btn-primary">Terapkan</button>
</form>

<!-- Grafik -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h6>Grafik Masukan dan Keluaran</h6>
        <canvas id="grafikKeuangan" height="100"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let chart = null;

    function updateChart(labels, masukan, pengeluaran) {
        const ctx = document.getElementById('grafikKeuangan').getContext('2d');
        if (chart) chart.destroy();

        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Masukan',
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        data: masukan
                    },
                    {
                        label: 'Keluaran',
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        data: pengeluaran
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function fetchChartData(filter, start = null, end = null) {
        $.ajax({
            url: "{{ route('dashboard.filter') }}",
            method: 'GET',
            data: {
                filter: filter,
                start: start,
                end: end
            },
            success: function(response) {
                updateChart(response.labels, response.masukanData, response.pengeluaranData);
            },
            error: function(xhr) {
                alert("Gagal mengambil data grafik: " + xhr.responseText);
            }
        });
    }

    function toggleDateInputs() {
        const selected = $('#filter').val();
        const isCustom = selected === 'custom';
        $('#start_date').toggle(isCustom);
        $('#end_date').toggle(isCustom);
    }

    $(document).ready(function() {
        toggleDateInputs(); // Saat pertama kali halaman dibuka

        fetchChartData($('#filter').val());

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            const filter = $('#filter').val();
            const start = $('#start_date').val();
            const end = $('#end_date').val();

            if (filter === 'custom' && (!start || !end)) {
                alert('Pilih tanggal mulai dan akhir!');
                return;
            }

            fetchChartData(filter, start, end);
        });

        $('#filter').on('change', toggleDateInputs);
    });
</script>
@endpush