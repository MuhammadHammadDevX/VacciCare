@extends('layouts.parent')

@section('title', 'My Children | VacciCare')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/parent_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vc-dashboard-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/my-children.css') }}">
@endpush

@section('content')
<main class="dashboard-main">
    <section class="children-content">
        <!-- PAGE INTRO -->
        <div class="children-intro">
            <div class="intro-text">
                <span class="section-label">
                    <i class="bi bi-people-fill"></i>
                    FAMILY MANAGEMENT
                </span>
                <h2>Your Children</h2>
                <p>Keep your children's vaccination information organized and easily accessible.</p>
            </div>

            <!-- ADD CHILD BUTTON -->
            <button class="add-child-btn" id="addChildBtn" type="button">
                <span class="add-icon"><i class="bi bi-plus-lg"></i></span>
                <span>Add Child</span>
            </button>
        </div>

        @if(session('child_success') || session('success'))
            <div class="alert alert-success mt-3" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('child_success') ?? session('success') }}
            </div>
        @endif

        @if(session('child_error') || session('error') || (isset($errors) && $errors->any()))
            <div class="alert alert-danger mt-3" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('child_error') ?? session('error') ?? (isset($errors) ? $errors->first() : '') }}
            </div>
        @endif

        <div class="children-grid" id="childrenGrid">
            @forelse($children as $child)
                @php
                    $genderIcon = 'bi-gender-ambiguous';
                    if ($child->gender === 'Female') {
                        $genderIcon = 'bi-gender-female';
                    } elseif ($child->gender === 'Male') {
                        $genderIcon = 'bi-gender-male';
                    }

                    $statusIcon = 'bi-clock-fill';
                    $progress = 0;
                    if ($child->vaccination_status === 'Up to Date') {
                        $statusIcon = 'bi-check-circle-fill';
                        $progress = 100;
                    } elseif ($child->vaccination_status === 'Partially Vaccinated') {
                        $statusIcon = 'bi-exclamation-circle-fill';
                        $progress = 50;
                    }
                @endphp

                <!-- CHILD CARD -->
                <div class="child-card">
                    <div class="child-card-top">
                        <div class="child-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <span class="child-status">
                            <i class="bi {{ $statusIcon }}"></i>
                            {{ $child->vaccination_status }}
                        </span>
                    </div>

                    <div class="child-info">
                        <h3>{{ $child->child_name }}</h3>

                        <div class="child-detail">
                            <i class="bi bi-calendar3"></i>
                            <span>Born: {{ $child->date_of_birth ? date('d F Y', strtotime($child->date_of_birth)) : 'N/A' }}</span>
                        </div>

                        <div class="child-detail">
                            <i class="bi {{ $genderIcon }}"></i>
                            <span>{{ $child->gender }}</span>
                        </div>

                        @if(!empty($child->blood_group))
                            <div class="child-detail">
                                <i class="bi bi-droplet"></i>
                                <span>Blood Group: {{ $child->blood_group }}</span>
                            </div>
                        @endif

                        @if(!empty($child->contact))
                            <div class="child-detail">
                                <i class="bi bi-telephone"></i>
                                <span>Contact: {{ $child->contact }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- VACCINATION PROGRESS -->
                    <div class="vaccination-progress">
                        <div class="progress-heading">
                            <span>Vaccination Progress</span>
                            <strong>{{ $progress }}%</strong>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $progress }}%;"></div>
                        </div>
                    </div>

                    <!-- CHILD FOOTER -->
                    <div class="child-footer" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <span style="margin-right:auto;">
                            <i class="bi bi-shield-check"></i>
                            {{ $child->vaccination_status }}
                        </span>

                        <a href="{{ route('parent.certificate.download', $child->child_id) }}" class="view-child-btn" style="background:#0284c7; color:#fff; border-color:#0284c7;" title="Download Official Digital Certificate">
                            <i class="bi bi-file-earmark-pdf-fill"></i> Certificate
                        </a>

                        <a href="{{ route('parent.edit-child', $child->child_id) }}" class="view-child-btn">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>

                        <form action="{{ route('parent.children.destroy', $child->child_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this child record?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="view-child-btn" style="background:none; border:none; color:#dc3545; cursor:pointer;">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <!-- No children yet -->
            @endforelse

            <div class="add-child-card" id="addChildCard">
                <div class="add-child-circle">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <h3>Add a Child</h3>
                <p>Add your child's information to keep track of their vaccination schedule.</p>
                <button class="add-card-btn" id="addCardBtn" type="button">
                    <i class="bi bi-plus-lg"></i> Add Child
                </button>
            </div>
        </div>

        <!-- INFORMATION BANNER -->
        <div class="children-info-banner">
            <div class="info-banner-icon">
                <i class="bi bi-info-circle-fill"></i>
            </div>
            <div class="info-banner-text">
                <h4>Keep vaccination records up to date</h4>
                <p>Make sure your children's information is accurate so you can easily track upcoming vaccinations and health records.</p>
            </div>
        </div>
    </section>
</main>

<!-- ADD CHILD MODAL -->
<div class="child-modal-overlay" id="childModal">
    <div class="child-modal">
        <div class="modal-header-custom">
            <div class="modal-title-area">
                <div class="modal-icon">
                    <i class="bi bi-person-plus-fill" id="modalIcon"></i>
                </div>
                <div>
                    <h3 id="modalTitle">Add New Child</h3>
                    <p id="modalDescription">Enter your child's basic information</p>
                </div>
            </div>
            <button type="button" class="modal-close" id="closeModal">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form id="childForm" method="POST" action="{{ route('parent.children.store') }}">
            @csrf
            <input type="hidden" name="child_action" id="childAction" value="add">
            <input type="hidden" name="child_id" id="childIdField" value="">

            <div class="form-row-custom">
                <div class="form-group-custom">
                    <label for="childName">Child's Full Name</label>
                    <div class="input-wrapper">
                        <i class="bi bi-person"></i>
                        <input type="text" id="childName" name="child_name" placeholder="Enter child's name" maxlength="100" required>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label for="childDob">Date of Birth</label>
                    <div class="input-wrapper">
                        <i class="bi bi-calendar3"></i>
                        <input type="date" id="childDob" name="date_of_birth" required>
                    </div>
                </div>
            </div>

            <div class="form-row-custom">
                <div class="form-group-custom">
                    <label for="childGender">Gender</label>
                    <div class="input-wrapper">
                        <i class="bi bi-gender-ambiguous"></i>
                        <select id="childGender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label for="bloodGroup">Blood Group</label>
                    <div class="input-wrapper">
                        <i class="bi bi-droplet"></i>
                        <select id="bloodGroup" name="blood_group">
                            <option value="">Select Blood Group</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group-custom">
                <label for="childContact">Contact Number <span>(Optional)</span></label>
                <div class="input-wrapper">
                    <i class="bi bi-telephone"></i>
                    <input type="text" id="childContact" name="contact" placeholder="Enter contact number" maxlength="30">
                </div>
            </div>

            <div class="form-group-custom">
                <label for="childNotes">Additional Notes <span>(Optional)</span></label>
                <textarea id="childNotes" name="additional_notes" rows="3" placeholder="Add any additional information..."></textarea>
            </div>

            <div class="modal-footer-custom">
                <button type="button" class="cancel-btn" id="cancelModal">Cancel</button>
                <button type="submit" class="save-child-btn" id="saveChildBtn">
                    <i class="bi bi-check-lg" id="saveChildIcon"></i>
                    <span id="saveChildText">Add Child</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/my-children.js') }}"></script>
@endpush
