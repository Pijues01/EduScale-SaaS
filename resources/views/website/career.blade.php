<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Opportunities | Inspire Coaching Academy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3399ff;
            --secondary-color: #97bc62;
            --accent-color: #f5f5dc;
        }

        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
            text-align: center;
        }

        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 10px;
            margin-bottom: 25px;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px;
        }

        .job-type {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .full-time {
            background-color: #d4edda;
            color: #155724;
        }

        .part-time {
            background-color: #fff3cd;
            color: #856404;
        }

        .btn-apply {
            background-color: var(--primary-color);
            border: none;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-apply:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-home {
            background-color: transparent;
            border: 2px solid white;
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s;
            margin-top: 15px;
        }

        .btn-home:hover {
            background-color: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        .benefits-section {
            background-color: var(--accent-color);
            padding: 60px 0;
            margin: 60px 0;
        }

        .benefit-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .testimonial-card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin: 15px 0;
        }

        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--secondary-color);
        }

        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }

        .social-icon {
            color: white;
            font-size: 1.5rem;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .social-icon:hover {
            color: var(--secondary-color);
        }

        .job-highlight {
            border-left: 4px solid var(--secondary-color);
            padding-left: 15px;
            margin: 20px 0;
        }

        h1.display-4.fw-bold.mb-4 {
            color: #ff0000;
        }

        .back-to-home {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }

            .hero-section h1 {
                font-size: 2rem;
            }

            .back-to-home {

                display: none;
                /* position: static;
                margin-bottom: 20px;
                text-align: center; */
            }
        }
    </style>
</head>

<body>
    <!-- Back to Home Button (Top Left) -->
    <div class="back-to-home">
        <a href="/" class="btn btn-home">
            <i class="fas fa-arrow-left me-2"></i> Back to Home
        </a>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Inspire Coaching Academy</h1>
            <h3 class="display-4 fw-bold mb-4">Join Our Team</h3>
            <p class="lead mb-4">Shape the future by educating the leaders of tomorrow at Inspire Coaching Academy</p>
            <a href="#openings" class="btn btn-lg btn-outline-light">View Current Openings</a>
            <!-- Secondary Back to Home Button in Hero -->
            <div class="mt-4">
                <a href="/" class="btn btn-home">
                    <i class="fas fa-home me-2"></i> Return to Homepage
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container" id="openings">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="fw-bold mb-3">Current Job Openings</h2>
                <p class="lead text-muted">We're looking for passionate educators and staff to join our growing team.
                    Browse our current opportunities below.</p>
            </div>
        </div>

        <div class="row">
            @foreach ($jobs as $job)
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">
                            {{ $job->title }}
                        </div>
                        <div class="card-body">
                            <span class="job-type {{ strtolower(str_replace(' ', '-', $job->type)) }}">
                                {{ $job->type }}
                            </span>
                            <p class="text-muted mb-3">
                                <i class="fas fa-map-marker-alt me-2"></i>{{ $job->location }}
                            </p>

                            <div class="job-highlight">
                                <p class="card-text">{{ Str::limit($job->description, 120) }}</p>
                            </div>

                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Competitive
                                    salary</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Professional
                                    development</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Supportive environment</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <button class="btn btn-apply w-100 apply-btn" data-bs-toggle="modal"
                                data-bs-target="#applyModal" data-id="{{ $job->id }}"
                                data-title="{{ $job->title }}">
                                Apply Now <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($jobs->isEmpty())
            <div class="text-center py-5">
                <h4 class="mb-3">No current openings at this time</h4>
                <p>We're always interested in meeting talented educators. Please check back later or submit your resume
                    for future opportunities.</p>
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#applyModal">
                    Submit General Application
                </button>
                <!-- Back to Home Button in Empty State -->
                <div class="mt-4">
                    <a href="/" class="btn btn-home" style="border-color: var(--primary-color); color: var(--primary-color);">
                        <i class="fas fa-home me-2"></i> Return to Homepage
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Why Work With Us Section -->
    <section class="benefits-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-3">Why Work at Inspire Coaching Academy?</h2>
                    <p class="lead">We value our staff and provide an environment where educators can thrive.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <div class="benefit-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h4>Professional Growth</h4>
                    <p>Annual stipend for professional development and conference opportunities.</p>
                </div>

                <div class="col-md-4 text-center mb-4">
                    <div class="benefit-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4>Health & Wellness</h4>
                    <p>Comprehensive health insurance and wellness programs for all full-time staff.</p>
                </div>

                <div class="col-md-4 text-center mb-4">
                    <div class="benefit-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Collaborative Culture</h4>
                    <p>Work with a team of passionate educators in a supportive environment.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <div class="container mb-5">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="fw-bold mb-3">What Our Staff Say</h2>
                <p class="lead text-muted">Hear from current members of our team.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="testimonial-card text-center">
                    <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Teacher"
                        class="testimonial-img mb-3">
                    <h5>Sarah Johnson</h5>
                    <p class="text-muted">Mathematics Teacher</p>
                    <p>"The collaborative environment at Inspire Coaching Academy has helped me grow as an educator more
                        than I ever imagined."</p>
                    <div class="text-warning">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="testimonial-card text-center">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Teacher"
                        class="testimonial-img mb-3">
                    <h5>Michael Chen</h5>
                    <p class="text-muted">Science Department Head</p>
                    <p>"The administration truly supports innovative teaching methods and provides the resources we need
                        to succeed."</p>
                    <div class="text-warning">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="testimonial-card text-center">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Staff"
                        class="testimonial-img mb-3">
                    <h5>Angela Martinez</h5>
                    <p class="text-muted">School Counselor</p>
                    <p>"I've worked at several schools, but Inspire Coaching Academy stands out for its commitment."</p>
                    <div class="text-warning">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Form Modal -->
    <div class="modal fade" id="applyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Apply for: <span id="jobTitle" class="fw-bold"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="applyForm" action="{{ route('job.apply') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="job_id" id="jobId">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name*</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email*</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone*</label>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Upload Resume*</label>
                                <input type="file" name="resume" class="form-control" required>
                                <small class="text-muted">PDF, DOC, or DOCX (Max 5MB)</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Why are you interested in this position?*</label>
                            <textarea name="cover_letter" class="form-control" rows="4"
                                placeholder="Please share your qualifications and why you'd be a great fit..." required></textarea>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="consentCheck" required>
                            <label class="form-check-label" for="consentCheck">
                                I consent to Inspire Coaching Academy processing my personal data for recruitment
                                purposes.*
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fas fa-paper-plane me-2"></i> Submit Application
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>Inspire Coaching Academy</h5>
                    <p>Preparing students for success in a changing world since 1985.</p>
                    <!-- Footer Back to Home Button -->
                    <a href="/" class="btn btn-home mt-3">
                        <i class="fas fa-home me-2"></i> Return to Homepage
                    </a>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>Contact Us</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i> 123 Education Way, Learning City, LC 12345</p>
                    <p><i class="fas fa-phone me-2"></i> (555) 123-4567</p>
                    <p><i class="fas fa-envelope me-2"></i> ica@info.edu</p>
                </div>
                <div class="col-md-4">
                    <h5>Follow Us</h5>
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <hr class="mt-4 bg-light">
            <div class="text-center pt-2">
                <p class="mb-0">&copy; 2023 Inspire Coaching Academy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".apply-btn").forEach(button => {
                button.addEventListener("click", function() {
                    const jobTitle = this.getAttribute("data-title") || "General Application";
                    document.getElementById("jobTitle").textContent = jobTitle;
                    document.getElementById("jobId").value = this.getAttribute("data-id") || "";
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
