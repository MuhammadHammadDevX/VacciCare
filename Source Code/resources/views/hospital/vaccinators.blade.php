@extends('layouts.hospital')

@section('title', 'Vaccinators | VacciCare')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/vaccine-status.css') }}">
<style>
.vaccinator-page {
    padding: 30px;
}
.vaccinator-container {
    max-width: 1100px;
    margin: 0 auto;
}
.vaccinator-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 28px;
    margin-bottom: 25px;
    box-shadow: 0 8px 30px rgba(0,0,0,.07);
}
.vaccinator-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 25px;
}
.vaccinator-header h1 {
    margin: 0 0 8px;
}
.vaccinator-header p {
    margin: 0;
    color: #6c757d;
}
.hospital-badge {
    padding: 12px 18px;
    border-radius: 30px;
    background: #f1f5f9;
    font-weight: 600;
}
.message {
    padding: 14px 18px;
    border-radius: 10px;
    margin-bottom: 20px;
}
.message.success {
    background: #d1e7dd;
    color: #0f5132;
}
.message.error {
    background: #f8d7da;
    color: #842029;
}
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}
.form-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
}
.form-group label {
    font-weight: 600;
}
.form-group input {
    width: 100%;
    box-sizing: border-box;
    padding: 13px 14px;
    border: 1px solid #dfe3e8;
    border-radius: 9px;
    outline: none;
}
.form-group input:focus {
    border-color: #6c63ff;
}
.full-width {
    grid-column: 1 / -1;
}
.add-btn {
    margin-top: 20px;
    padding: 13px 24px;
    border: 0;
    border-radius: 9px;
    background: #198754;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
}
.table-wrapper {
    overflow-x: auto;
}
.vaccinator-table {
    width: 100%;
    border-collapse: collapse;
}
.vaccinator-table th,
.vaccinator-table td {
    padding: 14px 12px;
    border-bottom: 1px solid #eee;
    text-align: left;
}
.vaccinator-table th {
    background: #f8f9fa;
}
.status-active {
    color: #198754;
    font-weight: 700;
}
.status-inactive {
    color: #dc3545;
    font-weight: 700;
}
.status-btn {
    border: 0;
    border-radius: 7px;
    padding: 8px 12px;
    color: #fff;
    cursor: pointer;
}
.make-inactive {
    background: #dc3545;
}
.make-active {
    background: #198754;
}
@media(max-width: 700px) {
    .vaccinator-page {
        padding: 15px;
    }
    .form-grid {
        grid-template-columns: 1fr;
    }
    .full-width {
        grid-column: auto;
    }
    .vaccinator-header {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
@endpush

@section('content')
<main class="vaccinator-page">
    <div class="vaccinator-container">
        @php
            $activeCount = 0;
            foreach ($vaccinators as $v) {
                $st = is_array($v) ? ($v['status'] ?? '') : ($v->status ?? '');
                if ($st === 'Active') {
                    $activeCount++;
                }
            }
        @endphp

        <div class="vaccinator-header">
            <div>
                <h1>Vaccinators</h1>
                <p>Manage vaccination staff for {{ $hospitalUser->hospital_name ?? $hospital->hospital_name ?? 'Hospital' }}</p>
            </div>
            <div class="hospital-badge">
                Active Vaccinators: {{ $activeCount }}
            </div>
        </div>

        @if(session('successMessage'))
            <div class="message success">
                {{ session('successMessage') }}
            </div>
        @endif

        @if(session('errorMessage'))
            <div class="message error">
                {{ session('errorMessage') }}
            </div>
        @endif

        @if($errors->any())
            <div class="message error">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="vaccinator-card">
            <h2>Add New Vaccinator</h2>
            <p>Register a vaccinator for this hospital.</p>

            <form method="POST" action="{{ route('hospital.vaccinators') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Qualification</label>
                        <input type="text" name="qualification" placeholder="e.g. Certified Vaccinator" value="{{ old('qualification') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required>
                    </div>
                </div>

                <button type="submit" name="add_vaccinator" class="add-btn">
                    <i class="bi bi-person-plus"></i>
                    Add Vaccinator
                </button>
            </form>
        </div>

        <div class="vaccinator-card">
            <h2>Vaccinator Staff List</h2>
            <p>All vaccinators associated with your hospital.</p>

            @if(count($vaccinators) > 0)
                <div class="table-wrapper">
                    <table class="vaccinator-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Qualification</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vaccinators as $index => $vaccinator)
                                @php
                                    $vacId = $vaccinator->vaccinator_id ?? $vaccinator['vaccinator_id'];
                                    $vacName = $vaccinator->name ?? $vaccinator['name'];
                                    $vacQual = $vaccinator->qualification ?? $vaccinator['qualification'];
                                    $vacPhone = $vaccinator->phone ?? $vaccinator['phone'];
                                    $vacStatus = $vaccinator->status ?? $vaccinator['status'];
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $vacName }}</strong></td>
                                    <td>{{ $vacQual }}</td>
                                    <td>{{ $vacPhone }}</td>
                                    <td>
                                        <span class="{{ $vacStatus === 'Active' ? 'status-active' : 'status-inactive' }}">
                                            {{ $vacStatus }}
                                        </span>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('hospital.vaccinators') }}" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="vaccinator_id" value="{{ $vacId }}">
                                            @if($vacStatus === 'Active')
                                                <input type="hidden" name="status" value="Inactive">
                                                <button type="submit" name="change_status" class="status-btn make-inactive">
                                                    Deactivate
                                                </button>
                                            @else
                                                <input type="hidden" name="status" value="Active">
                                                <button type="submit" name="change_status" class="status-btn make-active">
                                                    Activate
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align:center; padding: 40px 20px; color:#888;">
                    <i class="bi bi-people" style="font-size:36px; display:block; margin-bottom:10px; color:#adb5bd;"></i>
                    <p>No vaccinators registered yet. Use the form above to add a vaccinator.</p>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
