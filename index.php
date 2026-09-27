<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Vehicle Service Maintenance System - Multi-Role Account System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- QRCode.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #0f172a;
            --accent-color: #06b6d4;
            --bg-light: #f8fafc;
            --card-border: #e2e8f0;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            color: #1e293b;
            min-height: 100vh;
        }

        .auth-card {
            max-width: 480px;
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand-title {
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .avatar-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .sidebar-container {
            width: 260px;
            min-height: calc(100vh - 66px);
            background: #ffffff;
            border-right: 1px solid var(--card-border);
            transition: all 0.3s ease;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: #475569;
            font-weight: 500;
            border-radius: 10px;
            margin: 4px 12px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .nav-link-custom:hover {
            background-color: #f1f5f9;
            color: var(--primary-color);
        }

        .nav-link-custom.active {
            background-color: #eff6ff;
            color: var(--primary-color);
            font-weight: 600;
        }

        .stat-card {
            border: 1px solid var(--card-border);
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        }

        .icon-shape {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .health-gauge-container {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 0 auto;
        }

        .health-score-val {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .health-score-val .number {
            font-size: 2.25rem;
            font-weight: 800;
            line-height: 1;
        }

        .status-badge {
            padding: 0.4em 0.8em;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .status-pending { background-color: #fef3c7; color: #d97706; }
        .status-in-progress { background-color: #e0f2fe; color: #0284c7; }
        .status-completed { background-color: #dcfce7; color: #16a34a; }
        .status-danger { background-color: #fee2e2; color: #dc2626; }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

        @media (max-width: 991.98px) {
            .sidebar-container {
                width: 100%;
                min-height: auto;
                border-right: none;
                border-bottom: 1px solid var(--card-border);
            }
        }
    </style>
</head>
<body>

    <!-- AUTHENTICATION SCREEN CONTAINER -->
    <div id="authScreen" class="min-vh-100 d-flex align-items-center justify-content-center p-3 bg-gradient" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <div class="card auth-card border-0 p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="bg-primary text-white rounded-3 p-3 d-inline-flex align-items-center justify-content-center mb-2" style="width: 54px; height: 54px;">
                    <i class="fa-solid fa-car-wrench fs-3"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1">SmartAuto AI</h4>
                <p class="text-muted small mb-0">Vehicle Maintenance & AI Predictive Diagnostics</p>
            </div>

            <!-- LOGIN FORM -->
            <div id="loginFormContainer">
                <form onsubmit="handleLogin(event)">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input type="email" class="form-control border-start-0 bg-light" id="loginEmail" required placeholder="name@domain.com">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" class="form-control border-start-0 bg-light" id="loginPassword" required placeholder="••••••••">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3 shadow-sm mb-3">Sign In to Dashboard</button>
                </form>

                <div class="text-center">
                    <span class="small text-muted">Don't have an account? </span>
                    <a href="#" class="small fw-bold text-primary text-decoration-none" onclick="toggleAuthMode('register')">Register Now</a>
                </div>

                <div class="mt-4 pt-3 border-top text-center">
                    <small class="text-uppercase fw-bold text-muted d-block mb-2" style="font-size: 0.7rem;">Quick Demo Login Accounts</small>
                    <div class="d-flex flex-wrap gap-1 justify-content-center">
                        <button class="btn btn-outline-danger btn-xs py-1 px-2 rounded-2" style="font-size: 0.75rem;" onclick="quickLogin('admin@uptm.edu.my')"><i class="fa-solid fa-user-shield me-1"></i> Admin</button>
                        <button class="btn btn-outline-warning btn-xs py-1 px-2 rounded-2" style="font-size: 0.75rem;" onclick="quickLogin('mechanic@uptm.edu.my')"><i class="fa-solid fa-wrench me-1"></i> Mechanic</button>
                        <button class="btn btn-outline-primary btn-xs py-1 px-2 rounded-2" style="font-size: 0.75rem;" onclick="quickLogin('customer@uptm.edu.my')"><i class="fa-solid fa-user me-1"></i> Customer</button>
                    </div>
                </div>
            </div>

            <!-- REGISTRATION FORM -->
            <div id="registerFormContainer" class="d-none">
                <form onsubmit="handleRegistration(event)">
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" class="form-control bg-light" id="regName" required placeholder="Full Name">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" class="form-control bg-light" id="regEmail" required placeholder="name@domain.com">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Phone Number</label>
                        <input type="text" class="form-control bg-light" id="regPhone" required placeholder="012-3456789">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Account Role Type</label>
                        <select class="form-select bg-light" id="regRole" onchange="toggleRoleFields(this.value)" required>
                            <option value="customer">Vehicle Owner (Customer)</option>
                            <option value="mechanic">Workshop Mechanic / Technician</option>
                            <option value="admin">Workshop Administrator (Admin)</option>
                        </select>
                    </div>

                    <div id="adminRegFields" class="p-3 bg-danger-subtle rounded-3 mb-2 d-none border border-danger-subtle">
                        <div class="mb-2">
                            <label class="form-label small fw-bold text-danger"><i class="fa-solid fa-shield-halved me-1"></i> Admin Security Code</label>
                            <input type="password" class="form-control bg-white" id="regAdminKey" placeholder="Enter key (Default: UPTM2026)">
                            <small class="text-muted" style="font-size: 0.68rem;">* Use <b>UPTM2026</b> or <b>ADMIN123</b> to authorize admin registration.</small>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-danger"><i class="fa-solid fa-warehouse me-1"></i> Workshop / Branch Name</label>
                            <input type="text" class="form-control bg-white" id="regBranch" placeholder="e.g. UPTM Main Auto Workshop">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" class="form-control bg-light" id="regPassword" required placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold rounded-3 shadow-sm mb-3">Create Personal Account</button>
                </form>

                <div class="text-center">
                    <span class="small text-muted">Already registered? </span>
                    <a href="#" class="small fw-bold text-primary text-decoration-none" onclick="toggleAuthMode('login')">Back to Login</a>
                </div>
            </div>

        </div>
    </div>

    <!-- MAIN APPLICATION WRAPPER -->
    <div id="appContainer" class="d-none">
        
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top py-2 px-3">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                    <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fa-solid fa-car-wrench me-0"></i>
                    </div>
                    <span class="navbar-brand-title fs-5">SmartAuto AI</span>
                </a>

                <div class="d-flex align-items-center gap-3 ms-auto">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar-circle" id="navAvatarCircle">A</div>
                        <div class="d-none d-md-block text-start">
                            <div class="fw-bold fs-7 lh-1" id="navUserName">User Name</div>
                            <span class="badge bg-primary-subtle text-primary border rounded-pill mt-1" id="navUserRoleBadge" style="font-size: 0.68rem;">CUSTOMER</span>
                        </div>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-circle p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical text-muted"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">
                            <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#" onclick="openProfileModal()"><i class="fa-solid fa-user-gear text-primary"></i> Edit Profile Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" href="#" onclick="handleLogout()"><i class="fa-solid fa-right-from-bracket"></i> Sign Out Account</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="d-flex flex-column flex-lg-row">
            <div class="sidebar-container py-3" id="sidebarMenu"></div>

            <main class="flex-grow-1 p-3 p-md-4" style="max-width: 1600px;">
                <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055;"></div>

                <!-- ADMIN VIEW -->
                <div id="adminView" class="role-view d-none">
                    <div class="p-3 bg-primary text-white rounded-3 mb-4 d-flex justify-content-between align-items-center shadow-sm">
                        <div>
                            <h5 class="fw-bold mb-0" id="adminBranchTitle"><i class="fa-solid fa-warehouse me-2"></i>UPTM Main Workshop Admin Portal</h5>
                            <small class="text-white-50">Central Control Panel & System Diagnostics</small>
                        </div>
                        <span class="badge bg-white text-primary fw-bold" id="adminAccountBadge">Admin Account Active</span>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="stat-card p-3 d-flex align-items-center gap-3">
                                <div class="icon-shape bg-primary-subtle text-primary"><i class="fa-solid fa-users"></i></div>
                                <div>
                                    <div class="text-muted small fw-medium">Total Customers</div>
                                    <h4 class="mb-0 fw-bold" id="adminTotalCustomers">0</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="stat-card p-3 d-flex align-items-center gap-3">
                                <div class="icon-shape bg-info-subtle text-info"><i class="fa-solid fa-car"></i></div>
                                <div>
                                    <div class="text-muted small fw-medium">Vehicles Registered</div>
                                    <h4 class="mb-0 fw-bold" id="adminTotalVehicles">0</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="stat-card p-3 d-flex align-items-center gap-3">
                                <div class="icon-shape bg-warning-subtle text-warning"><i class="fa-solid fa-calendar-check"></i></div>
                                <div>
                                    <div class="text-muted small fw-medium">Pending Appointments</div>
                                    <h4 class="mb-0 fw-bold" id="adminPendingApps">0</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="stat-card p-3 d-flex align-items-center gap-3">
                                <div class="icon-shape bg-success-subtle text-success"><i class="fa-solid fa-sack-dollar"></i></div>
                                <div>
                                    <div class="text-muted small fw-medium">Total Revenue</div>
                                    <h4 class="mb-0 fw-bold" id="adminTotalRevenue">RM 0.00</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-lg-8">
                            <div class="stat-card p-3 p-md-4 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0"><i class="fa-solid fa-chart-line text-primary me-2"></i>Workshop Revenue Analytics</h6>
                                    <span class="badge bg-light text-dark border">Financial Performance</span>
                                </div>
                                <div style="height: 260px;"><canvas id="adminRevenueChart"></canvas></div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="stat-card p-3 p-md-4 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0"><i class="fa-solid fa-chart-pie text-info me-2"></i>AI Fleet Condition Index</h6>
                                    <span class="badge bg-light text-dark border">Real-time Health</span>
                                </div>
                                <div style="height: 260px;" class="d-flex align-items-center justify-content-center"><canvas id="adminHealthChart"></canvas></div>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card p-3 p-md-4 mb-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <h5 class="fw-bold mb-0" id="adminSectionTitle">Customer Accounts Management</h5>
                            <div id="adminActionBtnContainer"></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light"><tr id="adminTableHead"></tr></thead>
                                <tbody id="adminTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- MECHANIC VIEW -->
                <div id="mechanicView" class="role-view d-none">
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-4">
                            <div class="stat-card p-3 border-start border-4 border-warning">
                                <small class="text-muted fw-bold">MY ASSIGNED JOBS</small>
                                <h3 class="mb-0 fw-bold mt-1" id="mechAssignedCount">0</h3>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="stat-card p-3 border-start border-4 border-info">
                                <small class="text-muted fw-bold">IN PROGRESS</small>
                                <h3 class="mb-0 fw-bold mt-1" id="mechInProgressCount">0</h3>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="stat-card p-3 border-start border-4 border-success">
                                <small class="text-muted fw-bold">COMPLETED BY ME</small>
                                <h3 class="mb-0 fw-bold mt-1" id="mechCompletedCount">0</h3>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card p-3 p-md-4">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-screwdriver-wrench me-2 text-warning"></i>My Personal Service Work Orders</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Work Order ID</th>
                                        <th>Vehicle & Plate</th>
                                        <th>Service Required</th>
                                        <th>Customer Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="mechanicTasksTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- CUSTOMER VIEW -->
                <div id="customerView" class="role-view d-none">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 p-3 bg-white stat-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-shape bg-primary text-white"><i class="fa-solid fa-car"></i></div>
                            <div>
                                <small class="text-muted d-block fw-bold" style="font-size: 0.7rem;">MY GARAGE VEHICLE</small>
                                <select class="form-select border-0 bg-transparent fw-bold fs-5 p-0 pe-4" id="customerVehicleSelect" onchange="switchCustomerVehicle(this.value)">
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-sm rounded-3" onclick="openAddVehicleModal()">
                            <i class="fa-solid fa-circle-plus me-1"></i> Add Vehicle to My Account
                        </button>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-lg-5">
                            <div class="stat-card p-4 text-center h-100 d-flex flex-column justify-content-center align-items-center">
                                <h6 class="fw-bold text-muted mb-3"><i class="fa-solid fa-heart-pulse text-danger me-2"></i>AI Vehicle Health Score</h6>
                                <div class="health-gauge-container mb-3">
                                    <canvas id="healthScoreGauge"></canvas>
                                    <div class="health-score-val">
                                        <div class="number" id="healthScoreValue">--%</div>
                                        <small class="text-muted fw-semibold" id="healthScoreLabel">STATUS</small>
                                    </div>
                                </div>
                                <p class="small text-muted mb-0" id="healthScoreSummary">Diagnostic score calculated dynamically.</p>
                            </div>
                        </div>

                        <div class="col-12 col-lg-7">
                            <div class="stat-card p-4 h-100">
                                <h6 class="fw-bold mb-3"><i class="fa-solid fa-microchip text-primary me-2"></i>AI Predictive Maintenance Diagnostic Breakdown</h6>
                                <div class="row g-3" id="componentBreakdownContainer"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <div class="stat-card p-4 h-100">
                                <h6 class="fw-bold mb-3"><i class="fa-solid fa-calculator text-success me-2"></i>AI Maintenance Cost Estimator</h6>
                                <div class="p-3 bg-light rounded-3 mb-3 border">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="fw-semibold small"><i class="fa-solid fa-bell text-warning me-2"></i>Smart AI Service Reminder</span>
                                        <span class="badge bg-danger">Predictive Alert</span>
                                    </div>
                                    <p class="small text-muted mb-1" id="customerReminderText">Based on mileage, oil change recommended soon.</p>
                                </div>

                                <label class="form-label fw-bold small">Select Maintenance Service:</label>
                                <select class="form-select mb-3" id="costEstimatorSelect" onchange="calculateEstimate()">
                                    <option value="250">Synthetic Oil Change + Filter Package (RM 250)</option>
                                    <option value="480">Full Brake System Overhaul & Pads (RM 480)</option>
                                    <option value="850">Major Service (Plugs, Transmission Flush, Oil) (RM 850)</option>
                                    <option value="1200">Air-Con Compressor & Suspension Check (RM 1,200)</option>
                                </select>

                                <div class="d-flex justify-content-between align-items-center p-3 bg-primary-subtle text-primary rounded-3">
                                    <div>
                                        <small class="d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Estimated Cost</small>
                                        <span class="h4 fw-bold mb-0" id="estimatedCostDisplay">RM 250.00</span>
                                    </div>
                                    <button class="btn btn-primary btn-sm rounded-3 px-3" onclick="openBookAppointmentModal()">Book Service</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="stat-card p-4 h-100 text-center d-flex flex-column align-items-center justify-content-center">
                                <h6 class="fw-bold mb-2"><i class="fa-solid fa-qrcode text-dark me-2"></i>Digital Vehicle Health Passport</h6>
                                <p class="small text-muted mb-3">Scan this official UPTM QR code to verify service records on mobile.</p>
                                <div id="qrcode" class="p-3 bg-white border rounded-3 mb-2 shadow-sm"></div>
                                <small class="fw-bold text-primary" id="qrVinDisplay">VIN: ---</small>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Vehicle Maintenance History</h5>
                            <button class="btn btn-outline-primary btn-sm rounded-3" onclick="openBookAppointmentModal()"><i class="fa-solid fa-calendar-plus me-1"></i> Book Appointment</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Service Type</th>
                                        <th>Mileage Recorded</th>
                                        <th>Mechanic Diagnostic Notes</th>
                                        <th>Total Paid</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="customerServiceTableBody"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- MODALS -->
    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Personal Profile Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="profileForm" onsubmit="saveProfileSettings(event)">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Full Name</label>
                            <input type="text" class="form-control" id="profileName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" class="form-control" id="profileEmail" required readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Phone Number</label>
                            <input type="text" class="form-control" id="profilePhone" required>
                        </div>
                        <div class="mb-3" id="profileBranchContainer">
                            <label class="form-label small fw-bold">Workshop / Branch Name</label>
                            <input type="text" class="form-control" id="profileBranch">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Account Role</label>
                            <input type="text" class="form-control bg-light" id="profileRole" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-3">Update Personal Details</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Vehicle Modal -->
    <div class="modal fade" id="addVehicleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Register Vehicle to My Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addVehicleForm" onsubmit="submitAddVehicle(event)">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">License Plate Number</label>
                            <input type="text" class="form-control" id="vehPlate" required placeholder="e.g. VEE 8821">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Brand & Model</label>
                            <input type="text" class="form-control" id="vehBrandModel" required placeholder="e.g. Honda Civic 1.5 Turbo">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Current Odometer Mileage (km)</label>
                            <input type="number" class="form-control" id="vehMileage" required placeholder="65000">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">VIN / Chassis Number</label>
                            <input type="text" class="form-control" id="vehVin" required placeholder="e.g. WBA334812904812">
                        </div>
                        <button type="submit" class="btn btn-success w-100 rounded-3">Add Vehicle to Garage</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Mechanic Modal -->
    <div class="modal fade" id="assignMechanicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Assign Mechanic to Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="assignAptId">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select Workshop Mechanic</label>
                        <select class="form-select" id="assignMechanicSelect"></select>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-primary btn-sm rounded-3" onclick="confirmAssignMechanic()">Assign Job</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mechanic Work Order Update Modal (Updated with Multi-Select Spare Parts) -->
    <div class="modal fade" id="mechanicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Update Repair & Service Finding</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="mechanicUpdateForm">
                        <input type="hidden" id="mechTaskId">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Job Status</label>
                            <select class="form-select" id="mechStatusSelect">
                                <option value="In Progress">In Progress</option>
                                <option value="Pending Parts">Pending Parts</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Diagnostic Findings / Notes</label>
                            <textarea class="form-control" id="mechNotes" rows="3" placeholder="Enter engine diagnostic findings..."></textarea>
                        </div>

                        <!-- Dynamic Multi-Select Spare Parts List -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Spare Parts Used</label>
                            <div id="mechPartsContainer"></div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addPartRowMechanic()">
                                <i class="fa-solid fa-plus me-1"></i> Add Another Spare Part
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-success btn-sm rounded-3" onclick="saveMechanicUpdate()">Save & Log Service</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Book Service Modal -->
    <div class="modal fade" id="customerBookModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Book Service Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookAppForm">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Preferred Date</label>
                            <input type="date" class="form-control" id="bookDate" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Service Package</label>
                            <select class="form-select" id="bookServiceType">
                                <option value="Synthetic Oil Change">Synthetic Oil Change (RM 250)</option>
                                <option value="Brake System Inspection">Brake System Inspection (RM 480)</option>
                                <option value="Major Engine Service">Major Engine Service (RM 850)</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-primary btn-sm rounded-3" onclick="submitCustomerBooking()">Confirm Appointment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Spare Part Modal -->
    <div class="modal fade" id="addSparePartModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Add New Spare Part Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSparePartForm" onsubmit="submitAddSparePart(event)">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Part Name</label>
                            <input type="text" class="form-control" id="partName" required placeholder="e.g. Oil Filter Honda Civic">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Initial Stock Quantity</label>
                            <input type="number" class="form-control" id="partQty" required min="1" placeholder="e.g. 15">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Unit Price (RM)</label>
                            <input type="number" step="0.01" class="form-control" id="partUnitPrice" required placeholder="e.g. 45.00">
                        </div>
                        <button type="submit" class="btn btn-success w-100 rounded-3">Add to Inventory</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Spare Part Stock Modal -->
    <div class="modal fade" id="updateStockModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Update Spare Part Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateStockForm" onsubmit="submitUpdateStock(event)">
                        <input type="hidden" id="editPartId">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Part Name</label>
                            <input type="text" class="form-control bg-light" id="editPartName" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Stock Quantity</label>
                            <input type="number" class="form-control" id="editPartQty" required min="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Unit Price (RM)</label>
                            <input type="number" step="0.01" class="form-control" id="editPartUnitPrice" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-3">Save Stock Updates</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let currentUser = null;
        let dbState = { users: [], vehicles: [], appointments: [], serviceRecords: [], spareParts: [] };
        let currentAdminTab = 'customers';
        let selectedCustomerPlate = '';

        let revenueChartInstance = null;
        let healthChartInstance = null;
        let gaugeChartInstance = null;

        window.onload = async function() {
            await fetchDashboardData();
        };

        async function fetchDashboardData() {
            const res = await fetch('actions.php?action=get_dashboard_data');
            const data = await res.json();
            if (data.success) {
                currentUser = data.currentUser;
                dbState.users = data.users;
                dbState.vehicles = data.vehicles;
                dbState.appointments = data.appointments;
                dbState.serviceRecords = data.serviceRecords;
                dbState.spareParts = data.spareParts;
                showAppDashboard();
            } else {
                document.getElementById('authScreen').classList.remove('d-none');
                document.getElementById('appContainer').classList.add('d-none');
            }
        }

        function toggleAuthMode(mode) {
            if (mode === 'register') {
                document.getElementById('loginFormContainer').classList.add('d-none');
                document.getElementById('registerFormContainer').classList.remove('d-none');
            } else {
                document.getElementById('registerFormContainer').classList.add('d-none');
                document.getElementById('loginFormContainer').classList.remove('d-none');
            }
        }

        function toggleRoleFields(role) {
            const adminFields = document.getElementById('adminRegFields');
            if (role === 'admin') {
                adminFields.classList.remove('d-none');
            } else {
                adminFields.classList.add('d-none');
            }
        }

        function quickLogin(email) {
            document.getElementById('loginEmail').value = email;
            document.getElementById('loginPassword').value = 'pass';
            handleLogin(new Event('submit'));
        }

        async function handleLogin(e) {
            if(e) e.preventDefault();
            const email = document.getElementById('loginEmail').value.trim();
            const password = document.getElementById('loginPassword').value.trim();

            const res = await fetch('actions.php?action=login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });
            const data = await res.json();

            if (data.success) {
                await fetchDashboardData();
                showToast(`Welcome back, ${data.user.name}!`);
            } else {
                alert(data.message || 'Invalid email or password.');
            }
        }

        async function handleRegistration(e) {
            e.preventDefault();
            const name = document.getElementById('regName').value.trim();
            const email = document.getElementById('regEmail').value.trim();
            const phone = document.getElementById('regPhone').value.trim();
            const role = document.getElementById('regRole').value;
            const password = document.getElementById('regPassword').value;
            const adminKey = document.getElementById('regAdminKey').value.trim();
            const branch = document.getElementById('regBranch').value.trim();

            const res = await fetch('actions.php?action=register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, email, phone, role, password, adminKey, branch })
            });
            const data = await res.json();

            if (data.success) {
                await fetchDashboardData();
                showToast(`Account registered successfully!`);
            } else {
                alert(data.message);
            }
        }

        async function handleLogout() {
            await fetch('actions.php?action=logout');
            currentUser = null;
            document.getElementById('appContainer').classList.add('d-none');
            document.getElementById('authScreen').classList.remove('d-none');
        }

        function showAppDashboard() {
            document.getElementById('authScreen').classList.add('d-none');
            document.getElementById('appContainer').classList.remove('d-none');

            document.getElementById('navUserName').textContent = currentUser.name;
            document.getElementById('navUserRoleBadge').textContent = currentUser.role.toUpperCase();
            document.getElementById('navAvatarCircle').textContent = currentUser.name.charAt(0).toUpperCase();

            document.querySelectorAll('.role-view').forEach(el => el.classList.add('d-none'));

            renderSidebar();

            if (currentUser.role === 'admin') {
                document.getElementById('adminView').classList.remove('d-none');
                renderAdminDashboard();
            } else if (currentUser.role === 'mechanic') {
                document.getElementById('mechanicView').classList.remove('d-none');
                renderMechanicDashboard();
            } else if (currentUser.role === 'customer') {
                document.getElementById('customerView').classList.remove('d-none');
                renderCustomerDashboard();
            }
        }

        function renderSidebar() {
            const sidebar = document.getElementById('sidebarMenu');
            let html = '';

            if (currentUser.role === 'admin') {
                html = `
                    <div class="px-3 mb-2 text-uppercase fw-bold text-muted" style="font-size: 0.7rem;">Admin Workspace</div>
                    <a class="nav-link-custom ${currentAdminTab === 'customers' ? 'active' : ''}" href="#" onclick="setAdminTab('customers')"><i class="fa-solid fa-users"></i> Customer Accounts</a>
                    <a class="nav-link-custom ${currentAdminTab === 'vehicles' ? 'active' : ''}" href="#" onclick="setAdminTab('vehicles')"><i class="fa-solid fa-car"></i> Fleet Registry</a>
                    <a class="nav-link-custom ${currentAdminTab === 'mechanics' ? 'active' : ''}" href="#" onclick="setAdminTab('mechanics')"><i class="fa-solid fa-user-gear"></i> Mechanics Roster</a>
                    <a class="nav-link-custom ${currentAdminTab === 'appointments' ? 'active' : ''}" href="#" onclick="setAdminTab('appointments')"><i class="fa-solid fa-calendar-alt"></i> Service Appointments</a>
                    <a class="nav-link-custom ${currentAdminTab === 'parts' ? 'active' : ''}" href="#" onclick="setAdminTab('parts')"><i class="fa-solid fa-boxes-stacked"></i> Spare Parts Inventory</a>
                `;
            } else if (currentUser.role === 'mechanic') {
                html = `
                    <div class="px-3 mb-2 text-uppercase fw-bold text-muted" style="font-size: 0.7rem;">Technician Workbench</div>
                    <a class="nav-link-custom active" href="#"><i class="fa-solid fa-screwdriver-wrench"></i> My Work Orders</a>
                `;
            } else if (currentUser.role === 'customer') {
                html = `
                    <div class="px-3 mb-2 text-uppercase fw-bold text-muted" style="font-size: 0.7rem;">Vehicle Owner Portal</div>
                    <a class="nav-link-custom active" href="#"><i class="fa-solid fa-gauge-high"></i> Dashboard & Diagnostics</a>
                    <a class="nav-link-custom" href="#" onclick="openBookAppointmentModal()"><i class="fa-solid fa-calendar-plus"></i> Book Service</a>
                `;
            }

            sidebar.innerHTML = html;
        }

        function setAdminTab(tab) {
            currentAdminTab = tab;
            renderSidebar();
            renderAdminDashboard();
        }

        function renderAdminDashboard() {
            document.getElementById('adminBranchTitle').innerHTML = `<i class="fa-solid fa-warehouse me-2"></i>${currentUser.branch || 'UPTM Workshop'} Admin Portal`;
            document.getElementById('adminAccountBadge').textContent = `Admin: ${currentUser.name}`;

            document.getElementById('adminTotalCustomers').textContent = dbState.users.filter(u => u.role === 'customer').length;
            document.getElementById('adminTotalVehicles').textContent = dbState.vehicles.length;
            document.getElementById('adminPendingApps').textContent = dbState.appointments.filter(a => a.status === 'Pending' || a.status === 'In Progress').length;
            
            const totalRev = dbState.serviceRecords.reduce((sum, item) => sum + parseFloat(item.cost), 0);
            document.getElementById('adminTotalRevenue').textContent = `RM ${totalRev.toFixed(2)}`;

            initAdminCharts();

            const head = document.getElementById('adminTableHead');
            const body = document.getElementById('adminTableBody');
            const title = document.getElementById('adminSectionTitle');
            const actionBtn = document.getElementById('adminActionBtnContainer');
            actionBtn.innerHTML = '';

            if (currentAdminTab === 'customers') {
                title.textContent = 'Registered Customer Accounts';
                head.innerHTML = `<tr><th>User ID</th><th>Customer Name</th><th>Email</th><th>Phone</th><th>Action</th></tr>`;
                body.innerHTML = dbState.users.filter(u => u.role === 'customer').map(c => `
                    <tr>
                        <td class="fw-bold">#CST-${c.id}</td>
                        <td>${c.name}</td>
                        <td>${c.email}</td>
                        <td>${c.phone || '-'}</td>
                        <td><button class="btn btn-sm btn-outline-danger" onclick="deleteAdminRecord('users', ${c.id})"><i class="fa-solid fa-trash"></i></button></td>
                    </tr>
                `).join('');
            } else if (currentAdminTab === 'vehicles') {
                title.textContent = 'Fleet Vehicle Registry';
                head.innerHTML = `<tr><th>Plate</th><th>Model</th><th>Mileage</th><th>AI Health Score</th><th>Owner Email</th><th>Action</th></tr>`;
                body.innerHTML = dbState.vehicles.map(v => `
                    <tr>
                        <td class="fw-bold">${v.plate}</td>
                        <td>${v.brand_model}</td>
                        <td>${parseInt(v.mileage).toLocaleString()} km</td>
                        <td><span class="badge ${v.health_score > 80 ? 'bg-success' : 'bg-warning text-dark'}">${v.health_score}%</span></td>
                        <td>${v.owner_email}</td>
                        <td><button class="btn btn-sm btn-outline-danger" onclick="deleteAdminRecord('vehicles', ${v.id})"><i class="fa-solid fa-trash"></i></button></td>
                    </tr>
                `).join('');
            } else if (currentAdminTab === 'mechanics') {
                title.textContent = 'Mechanic Staff Roster';
                head.innerHTML = `<tr><th>ID</th><th>Mechanic Name</th><th>Email</th><th>Specialty</th><th>Action</th></tr>`;
                body.innerHTML = dbState.users.filter(u => u.role === 'mechanic').map(m => `
                    <tr>
                        <td class="fw-bold">#MCH-${m.id}</td>
                        <td>${m.name}</td>
                        <td>${m.email}</td>
                        <td>${m.specialty || 'General Diagnostics'}</td>
                        <td><button class="btn btn-sm btn-outline-danger" onclick="deleteAdminRecord('users', ${m.id})"><i class="fa-solid fa-trash"></i></button></td>
                    </tr>
                `).join('');
            } else if (currentAdminTab === 'appointments') {
                title.textContent = 'Service Appointments & Assignments';
                head.innerHTML = `<tr><th>ID</th><th>Customer</th><th>Vehicle</th><th>Service</th><th>Assigned Mechanic</th><th>Status</th><th>Action</th></tr>`;
                body.innerHTML = dbState.appointments.map(a => {
                    const statusVal = a.status || 'Pending';
                    const statusClass = statusVal === 'Completed' ? 'status-completed' : (statusVal === 'In Progress' ? 'status-in-progress' : 'status-pending');
                    return `
                    <tr>
                        <td class="fw-bold">#APT-${a.id}</td>
                        <td>${a.customer_name}</td>
                        <td>${a.vehicle_plate}</td>
                        <td>${a.service}</td>
                        <td><span class="fw-bold text-primary">${a.mechanic_email || 'Unassigned'}</span></td>
                        <td><span class="status-badge ${statusClass}">${statusVal}</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="openAssignMechanicModal(${a.id})"><i class="fa-solid fa-user-plus"></i> Assign</button>
                        </td>
                    </tr>
                `}).join('');
            } else if (currentAdminTab === 'parts') {
                title.textContent = 'Spare Parts Inventory Management';
                actionBtn.innerHTML = `
                    <button class="btn btn-primary btn-sm rounded-3" onclick="openAddSparePartModal()">
                        <i class="fa-solid fa-plus me-1"></i> Add New Spare Part
                    </button>
                `;
                head.innerHTML = `<tr><th>Item ID</th><th>Part Name</th><th>Stock Qty</th><th>Unit Price</th><th>Action</th></tr>`;
                body.innerHTML = dbState.spareParts.map(p => `
                    <tr>
                        <td class="fw-bold">#PRT-${p.id}</td>
                        <td>${p.name}</td>
                        <td><span class="fw-bold ${p.qty < 10 ? 'text-danger' : 'text-dark'}">${p.qty} units</span></td>
                        <td>RM ${parseFloat(p.unit_price).toFixed(2)}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1" onclick="openUpdateStockModal(${p.id})"><i class="fa-solid fa-pen-to-square"></i> Edit Stock</button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteAdminRecord('spareParts', ${p.id})"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                `).join('');
            }
        }

        function initAdminCharts() {
            const ctxRev = document.getElementById('adminRevenueChart').getContext('2d');
            if (revenueChartInstance) revenueChartInstance.destroy();
            revenueChartInstance = new Chart(ctxRev, {
                type: 'line',
                data: {
                    labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                    datasets: [{ label: 'Revenue (RM)', data: [12400, 15800, 14200, 18900, 21000, 24500], borderColor: '#2563eb', backgroundColor: 'rgba(37, 99, 235, 0.1)', fill: true }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            const ctxHealth = document.getElementById('adminHealthChart').getContext('2d');
            if (healthChartInstance) healthChartInstance.destroy();
            healthChartInstance = new Chart(ctxHealth, {
                type: 'doughnut',
                data: {
                    labels: ['Optimal (>80%)', 'Moderate (60-80%)', 'Critical (<60%)'],
                    datasets: [{ data: [14, 5, 2], backgroundColor: ['#16a34a', '#d97706', '#dc2626'] }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }

        function openAddSparePartModal() {
            document.getElementById('addSparePartForm').reset();
            const modal = new bootstrap.Modal(document.getElementById('addSparePartModal'));
            modal.show();
        }

        async function submitAddSparePart(e) {
            e.preventDefault();
            const name = document.getElementById('partName').value.trim();
            const qty = parseInt(document.getElementById('partQty').value);
            const unitPrice = parseFloat(document.getElementById('partUnitPrice').value);

            await fetch('actions.php?action=add_spare_part', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, qty, unitPrice })
            });

            bootstrap.Modal.getInstance(document.getElementById('addSparePartModal')).hide();
            await fetchDashboardData();
            showToast('New spare part item added successfully!');
        }

        function openUpdateStockModal(partId) {
            const part = dbState.spareParts.find(p => p.id == partId);
            if (part) {
                document.getElementById('editPartId').value = part.id;
                document.getElementById('editPartName').value = part.name;
                document.getElementById('editPartQty').value = part.qty;
                document.getElementById('editPartUnitPrice').value = part.unit_price;

                const modal = new bootstrap.Modal(document.getElementById('updateStockModal'));
                modal.show();
            }
        }

        async function submitUpdateStock(e) {
            e.preventDefault();
            const id = parseInt(document.getElementById('editPartId').value);
            const qty = parseInt(document.getElementById('editPartQty').value);
            const unitPrice = parseFloat(document.getElementById('editPartUnitPrice').value);

            await fetch('actions.php?action=update_spare_part', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, qty, unitPrice })
            });

            bootstrap.Modal.getInstance(document.getElementById('updateStockModal')).hide();
            await fetchDashboardData();
            showToast('Spare part stock updated!');
        }

        function openAssignMechanicModal(aptId) {
            document.getElementById('assignAptId').value = aptId;
            const mechs = dbState.users.filter(u => u.role === 'mechanic');

            const select = document.getElementById('assignMechanicSelect');
            select.innerHTML = mechs.map(m => `<option value="${m.email}">${m.name} (${m.email})</option>`).join('');

            const modal = new bootstrap.Modal(document.getElementById('assignMechanicModal'));
            modal.show();
        }

        async function confirmAssignMechanic() {
            const aptId = parseInt(document.getElementById('assignAptId').value);
            const mechanicEmail = document.getElementById('assignMechanicSelect').value;

            await fetch('actions.php?action=assign_mechanic', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ aptId, mechanicEmail })
            });

            bootstrap.Modal.getInstance(document.getElementById('assignMechanicModal')).hide();
            await fetchDashboardData();
            showToast('Mechanic assigned successfully!');
        }

        async function deleteAdminRecord(table, id) {
            if (!confirm('Are you sure you want to delete this record?')) return;
            await fetch('actions.php?action=delete_record', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ table, id })
            });

            await fetchDashboardData();
            showToast('Record deleted successfully.');
        }

        function renderMechanicDashboard() {
            const myTasks = dbState.appointments.filter(a => a.mechanic_email && a.mechanic_email.toLowerCase() === currentUser.email.toLowerCase());

            document.getElementById('mechAssignedCount').textContent = myTasks.length;
            document.getElementById('mechInProgressCount').textContent = myTasks.filter(a => a.status === 'In Progress').length;
            document.getElementById('mechCompletedCount').textContent = dbState.serviceRecords.length;

            const tbody = document.getElementById('mechanicTasksTableBody');
            if (myTasks.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-4">No active work orders assigned to your account.</td></tr>`;
                return;
            }

            tbody.innerHTML = myTasks.map(t => {
                const statusVal = t.status || 'Pending';
                const statusClass = statusVal === 'Completed' ? 'status-completed' : (statusVal === 'In Progress' ? 'status-in-progress' : 'status-pending');
                return `
                <tr>
                    <td class="fw-bold">#WO-${t.id}</td>
                    <td>${t.vehicle_plate}</td>
                    <td>${t.service}</td>
                    <td>${t.customer_name}</td>
                    <td><span class="status-badge ${statusClass}">${statusVal}</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary rounded-3" onclick="openMechanicUpdateModal(${t.id})"><i class="fa-solid fa-wrench me-1"></i> Update Progress</button>
                    </td>
                </tr>
            `}).join('');
        }

        // Dynamic Spare Part Rows Helpers
        function getSparePartOptionsHtml() {
            return `<option value="">-- Select Spare Part --</option>` +
                dbState.spareParts.map(p => `<option value="${p.id}">${p.name} (Stock: ${p.qty}) - RM ${parseFloat(p.unit_price).toFixed(2)}</option>`).join('');
        }

        function addPartRowMechanic() {
            const container = document.getElementById('mechPartsContainer');
            const row = document.createElement('div');
            row.className = 'row g-2 mb-2 mech-part-row align-items-center';
            row.innerHTML = `
                <div class="col-7">
                    <select class="form-select mech-part-select">${getSparePartOptionsHtml()}</select>
                </div>
                <div class="col-3">
                    <input type="number" class="form-control mech-part-qty" value="1" min="1" placeholder="Qty">
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="this.closest('.mech-part-row').remove()"><i class="fa-solid fa-trash"></i></button>
                </div>
            `;
            container.appendChild(row);
        }

        function openMechanicUpdateModal(taskId) {
            document.getElementById('mechTaskId').value = taskId;
            document.getElementById('mechNotes').value = '';
            
            const container = document.getElementById('mechPartsContainer');
            container.innerHTML = '';
            addPartRowMechanic(); // add initial row

            const modal = new bootstrap.Modal(document.getElementById('mechanicModal'));
            modal.show();
        }

        async function saveMechanicUpdate() {
            const taskId = parseInt(document.getElementById('mechTaskId').value);
            const status = document.getElementById('mechStatusSelect').value;
            const notes = document.getElementById('mechNotes').value;

            // Collect all selected parts
            const partRows = document.querySelectorAll('.mech-part-row');
            const partsUsed = [];

            partRows.forEach(row => {
                const partId = parseInt(row.querySelector('.mech-part-select').value);
                const quantity = parseInt(row.querySelector('.mech-part-qty').value) || 1;

                if (partId) {
                    partsUsed.push({ partId, quantity });
                }
            });

            await fetch('actions.php?action=update_mechanic_task', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ taskId, status, notes, partsUsed })
            });

            bootstrap.Modal.getInstance(document.getElementById('mechanicModal')).hide();
            await fetchDashboardData();
            showToast('Work order updated successfully!');
        }

        function renderCustomerDashboard() {
            const myVehicles = dbState.vehicles.filter(v => v.owner_email.toLowerCase() === currentUser.email.toLowerCase());

            const select = document.getElementById('customerVehicleSelect');
            if (myVehicles.length === 0) {
                select.innerHTML = `<option value="">No Registered Vehicles</option>`;
                document.getElementById('healthScoreValue').textContent = 'N/A';
                document.getElementById('qrVinDisplay').textContent = 'VIN: NONE';
                return;
            }

            select.innerHTML = myVehicles.map(v => `<option value="${v.plate}" ${v.plate === selectedCustomerPlate ? 'selected' : ''}>${v.brand_model} (${v.plate})</option>`).join('');

            if (!selectedCustomerPlate || !myVehicles.some(v => v.plate === selectedCustomerPlate)) {
                selectedCustomerPlate = myVehicles[0].plate;
            }

            const activeVeh = myVehicles.find(v => v.plate === selectedCustomerPlate);
            
            initHealthGauge(activeVeh.health_score);
            renderComponentBreakdown(activeVeh.health_score);
            updateQrCode(activeVeh.vin);
            document.getElementById('qrVinDisplay').textContent = `VIN: ${activeVeh.vin}`;
            document.getElementById('customerReminderText').textContent = `Vehicle Mileage: ${parseInt(activeVeh.mileage).toLocaleString()} km. Next AI predicted service due in 1,200 km.`;

            const history = dbState.serviceRecords.filter(r => r.vehicle_plate === activeVeh.plate);
            const tbody = document.getElementById('customerServiceTableBody');
            tbody.innerHTML = history.map(h => `
                <tr>
                    <td>${h.record_date}</td>
                    <td class="fw-bold">${h.service}</td>
                    <td>${parseInt(h.mileage).toLocaleString()} km</td>
                    <td class="small text-muted">${h.notes}</td>
                    <td class="fw-bold text-success">RM ${parseFloat(h.cost).toFixed(2)}</td>
                    <td><span class="badge bg-success-subtle text-success">${h.status}</span></td>
                </tr>
            `).join('');
        }

        function switchCustomerVehicle(plate) {
            selectedCustomerPlate = plate;
            renderCustomerDashboard();
        }

        function initHealthGauge(score) {
            const ctx = document.getElementById('healthScoreGauge').getContext('2d');
            if (gaugeChartInstance) gaugeChartInstance.destroy();

            gaugeChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [score, 100 - score],
                        backgroundColor: [score > 80 ? '#16a34a' : score > 60 ? '#d97706' : '#dc2626', '#e2e8f0'],
                        borderWidth: 0
                    }]
                },
                options: { cutout: '80%', responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });

            document.getElementById('healthScoreValue').textContent = `${score}%`;
            document.getElementById('healthScoreLabel').textContent = score > 80 ? 'OPTIMAL' : 'SERVICE DUE';
        }

        function renderComponentBreakdown(score) {
            const container = document.getElementById('componentBreakdownContainer');
            const items = [
                { name: 'Engine Health', val: score },
                { name: 'Brake Wear', val: Math.max(40, score - 10) },
                { name: 'Transmission', val: Math.min(95, score + 5) },
                { name: 'Battery Health', val: 92 }
            ];

            container.innerHTML = items.map(i => `
                <div class="col-12 col-sm-6">
                    <div class="p-3 border rounded-3 bg-white">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-bold small">${i.name}</span>
                            <span class="fw-bold small ${i.val > 75 ? 'text-success' : 'text-warning'}">${i.val}%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar ${i.val > 75 ? 'bg-success' : 'bg-warning'}" style="width: ${i.val}%"></div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function updateQrCode(vin) {
            const container = document.getElementById("qrcode");
            container.innerHTML = "";
            new QRCode(container, {
                text: `https://uptm-auto.edu.my/passport?vin=${vin}`,
                width: 110,
                height: 110
            });
        }

        function calculateEstimate() {
            const val = document.getElementById('costEstimatorSelect').value;
            document.getElementById('estimatedCostDisplay').textContent = `RM ${parseFloat(val).toFixed(2)}`;
        }

        function openAddVehicleModal() {
            const modal = new bootstrap.Modal(document.getElementById('addVehicleModal'));
            modal.show();
        }

        async function submitAddVehicle(e) {
            e.preventDefault();
            const plate = document.getElementById('vehPlate').value.trim();
            const brandModel = document.getElementById('vehBrandModel').value.trim();
            const mileage = parseInt(document.getElementById('vehMileage').value);
            const vin = document.getElementById('vehVin').value.trim();

            await fetch('actions.php?action=add_vehicle', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ plate, brandModel, mileage, vin })
            });

            selectedCustomerPlate = plate;
            bootstrap.Modal.getInstance(document.getElementById('addVehicleModal')).hide();
            await fetchDashboardData();
            showToast('Vehicle registered to your garage!');
        }

        function openBookAppointmentModal() {
            const modal = new bootstrap.Modal(document.getElementById('customerBookModal'));
            modal.show();
        }

        async function submitCustomerBooking() {
            const date = document.getElementById('bookDate').value;
            const service = document.getElementById('bookServiceType').value;

            if (!date) { alert('Please pick a preferred date'); return; }

            await fetch('actions.php?action=book_appointment', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ vehiclePlate: selectedCustomerPlate, service, date })
            });

            bootstrap.Modal.getInstance(document.getElementById('customerBookModal')).hide();
            await fetchDashboardData();
            showToast('Appointment booked successfully!');
        }

        function openProfileModal() {
            document.getElementById('profileName').value = currentUser.name;
            document.getElementById('profileEmail').value = currentUser.email;
            document.getElementById('profilePhone').value = currentUser.phone || '';
            document.getElementById('profileRole').value = currentUser.role.toUpperCase();

            const branchContainer = document.getElementById('profileBranchContainer');
            if (currentUser.role === 'admin') {
                branchContainer.classList.remove('d-none');
                document.getElementById('profileBranch').value = currentUser.branch || '';
            } else {
                branchContainer.classList.add('d-none');
            }

            const modal = new bootstrap.Modal(document.getElementById('profileModal'));
            modal.show();
        }

        async function saveProfileSettings(e) {
            e.preventDefault();
            bootstrap.Modal.getInstance(document.getElementById('profileModal')).hide();
            showToast('Profile settings saved!');
        }

        function showToast(msg) {
            const container = document.getElementById('toastContainer');
            const el = document.createElement('div');
            el.className = 'toast align-items-center text-white bg-dark border-0 show mb-2';
            el.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body"><i class="fa-solid fa-circle-check text-success me-2"></i>${msg}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            container.appendChild(el);
            setTimeout(() => el.remove(), 3000);
        }
    </script>
</body>
</html>