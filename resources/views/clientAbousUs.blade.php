@extends('format.layout')

@section('title')
    About Us
@endsection

@section('header')
    @parent
@endsection

@section('content')
<style>
    .about-card {
        border: none;
        border-radius: 1rem;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }
    .about-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.09) !important;
    }
    .team-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }
    .value-icon {
        font-size: 2rem;
        margin-bottom: .5rem;
    }
</style>

<!-- Hero Banner -->
<div class="rounded-3 p-4 mb-4 text-white" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <h3 class="fw-bold mb-2">About Client Portal</h3>
            <p class="mb-0 opacity-90">We are committed to delivering exceptional service and building lasting relationships with every client we serve. Our platform connects you with everything you need, seamlessly.</p>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <span style="font-size: 4rem;">&#127963;</span>
        </div>
    </div>
</div>

<!-- Mission & Vision -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card about-card shadow-sm h-100 p-4">
            <div class="value-icon">&#127919;</div>
            <h5 class="fw-bold mb-2">Our Mission</h5>
            <p class="text-muted mb-0">To empower clients through a reliable, user-friendly portal that simplifies service management, fosters transparency, and delivers real value at every touchpoint. We strive to make every interaction meaningful and efficient.</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card about-card shadow-sm h-100 p-4">
            <div class="value-icon">&#128161;</div>
            <h5 class="fw-bold mb-2">Our Vision</h5>
            <p class="text-muted mb-0">To become the most trusted client service platform — where technology meets care. We envision a future where every client feels valued, heard, and well-supported through innovative digital solutions.</p>
        </div>
    </div>
</div>

<!-- Core Values -->
<div class="card about-card shadow-sm mb-4">
    <div class="card-header bg-transparent fw-bold border-bottom py-3">
        &#11088; Core Values
    </div>
    <div class="card-body">
        <div class="row g-3 text-center">
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 bg-primary bg-opacity-10 h-100">
                    <div class="value-icon">&#129309;</div>
                    <div class="fw-semibold">Integrity</div>
                    <div class="text-muted small">We act with honesty and transparency in all we do.</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 bg-success bg-opacity-10 h-100">
                    <div class="value-icon">&#128640;</div>
                    <div class="fw-semibold">Innovation</div>
                    <div class="text-muted small">We continuously improve to better serve our clients.</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 bg-warning bg-opacity-10 h-100">
                    <div class="value-icon">&#129351;</div>
                    <div class="fw-semibold">Excellence</div>
                    <div class="text-muted small">We pursue the highest standards in service quality.</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 bg-info bg-opacity-10 h-100">
                    <div class="value-icon">&#128161;</div>
                    <div class="fw-semibold">Client Focus</div>
                    <div class="text-muted small">Our clients are at the heart of every decision.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Team -->
<div class="card about-card shadow-sm mb-4">
    <div class="card-header bg-transparent fw-bold border-bottom py-3">
        &#128101; Meet the Team
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="team-avatar" style="background: linear-gradient(135deg,#0d6efd,#6610f2);">JC</div>
                    <div>
                        <div class="fw-semibold">John Carlo</div>
                        <div class="text-muted small">Lead Developer</div>
                        <div class="text-muted" style="font-size:.75rem">j.carlo@portal.com</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="team-avatar" style="background: linear-gradient(135deg,#198754,#20c997);">MR</div>
                    <div>
                        <div class="fw-semibold">Maria Reyes</div>
                        <div class="text-muted small">Project Manager</div>
                        <div class="text-muted" style="font-size:.75rem">m.reyes@portal.com</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="team-avatar" style="background: linear-gradient(135deg,#fd7e14,#dc3545);">BC</div>
                    <div>
                        <div class="fw-semibold">Mia Shiela Grace Uson</div>
                        <div class="text-muted small">UI/UX Designer</div>
                        <div class="text-muted" style="font-size:.75rem">m.uson@portal.com</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact -->
<div class="card about-card shadow-sm">
    <div class="card-header bg-transparent fw-bold border-bottom py-3">
        &#128222; Contact Us
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4 d-flex align-items-center gap-3">
                <span class="fs-3">&#128205;</span>
                <div>
                    <div class="fw-semibold small">Address</div>
                    <div class="text-muted small">San Carlos City, Pangasinan, Philippines</div>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center gap-3">
                <span class="fs-3">&#128222;</span>
                <div>
                    <div class="fw-semibold small">Phone</div>
                    <div class="text-muted small">+63 930 434 8308</div>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center gap-3">
                <span class="fs-3">&#128140;</span>
                <div>
                    <div class="fw-semibold small">Email</div>
                    <div class="text-muted small">support@clientportal.com</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @parent
@endsection







