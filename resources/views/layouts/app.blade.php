<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Employee Leave Management System')</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background-color: #f5f7fb;
            color: #212529;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .navbar .nav-link {
            transition: color 0.2s ease;
        }

        .navbar .nav-link:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .content-area {
            min-height: 78vh;
        }

        .dashboard-card,
        .content-card {
            border: none;
            border-radius: 14px;
        }

        .table th {
            white-space: nowrap;
        }

        .form-label {
            font-weight: 600;
        }

        footer {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-xl navbar-dark bg-primary shadow-sm">
        <div class="container-fluid px-3 px-lg-4">

            <a class="navbar-brand" href="{{ route('dashboard') }}">
                Employee Leave Management
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNav"
                aria-controls="mainNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}"
                        >
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('web.departments.*') ? 'active' : '' }}"
                            href="{{ route('web.departments.index') }}"
                        >
                            Departments
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('web.employees.*') ? 'active' : '' }}"
                            href="{{ route('web.employees.index') }}"
                        >
                            Employees
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('web.leave-types.*') ? 'active' : '' }}"
                            href="{{ route('web.leave-types.index') }}"
                        >
                            Leave Types
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('web.leave-requests.*') ? 'active' : '' }}"
                            href="{{ route('web.leave-requests.index') }}"
                        >
                            Leave Requests
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('web.approvals.*') ? 'active' : '' }}"
                            href="{{ route('web.approvals.index') }}"
                        >
                            Approvals
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container-fluid px-3 px-lg-4 py-4 content-area">

        <!-- Success Message -->
        @if (session('success'))
            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >
                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            </div>
        @endif

        <!-- Error Message -->
        @if (session('error'))
            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >
                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>Please correct the following errors:</strong>

                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </main>

    <!-- Footer -->
    <footer class="bg-white border-top text-center text-secondary py-3">
        <div class="container">
            &copy; {{ date('Y') }} Employee Leave Management System
        </div>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>
</body>
</html>