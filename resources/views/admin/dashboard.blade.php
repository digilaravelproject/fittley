@extends('layouts.admin')

@section('content')
<div class="fitness-dashboard">
    <!-- Top Header with Good Morning and User Info -->
    <div class="dashboard-top-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="greeting-section">
                    <h2 class="greeting-text">Good Morning</h2>
                    <h1 class="welcome-back">Welcome Back</h1>
                    <p class="user-name">{{ Auth::user()->name }}</p>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <div class="user-profile-card">
                    <div class="profile-avatar">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="profile-info">
                        <div class="profile-name">{{ Auth::user()->name }}</div>
                        <div class="profile-role">Administrator</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Grid -->
    <div class="row g-4">
        <!-- Left Column - Activity Section -->
        <div class="col-xl-4 col-lg-6">
            <div class="dashboard-card activity-card">
                <div class="card-header">
                    <h3 class="card-title">Activity</h3>
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Monthly
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Daily</a></li>
                            <li><a class="dropdown-item" href="#">Weekly</a></li>
                            <li><a class="dropdown-item" href="#">Monthly</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="activity-chart">
                        <div class="chart-bars">
                            <div class="bar" style="height: 60%"></div>
                            <div class="bar" style="height: 80%"></div>
                            <div class="bar" style="height: 40%"></div>
                            <div class="bar active" style="height: 100%"></div>
                            <div class="bar" style="height: 30%"></div>
                            <div class="bar" style="height: 70%"></div>
                            <div class="bar" style="height: 50%"></div>
                            <div class="bar" style="height: 20%"></div>
                        </div>
                        <div class="chart-labels">
                            <span>Jan</span>
                            <span>Feb</span>
                            <span>Mar</span>
                            <span>Apr</span>
                            <span>May</span>
                            <span>Jun</span>
                            <span>Jul</span>
                            <span>Aug</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Center Column - Overview Stats -->
        <div class="col-xl-4 col-lg-6">
            <div class="dashboard-card overview-card">
                <div class="card-header">
                    <h3 class="card-title">Overview</h3>
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Monthly
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Daily</a></li>
                            <li><a class="dropdown-item" href="#">Weekly</a></li>
                            <li><a class="dropdown-item" href="#">Monthly</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="overview-stats">
                        <div class="stat-circle">
                            <div class="circle-progress" data-percentage="84">
                                <svg>
                                    <circle cx="60" cy="60" r="50"></circle>
                                    <circle cx="60" cy="60" r="50" class="progress-circle"></circle>
                                </svg>
                                <div class="circle-content">
                                    <span class="percentage">84%</span>
                                    <span class="label">1,290 mi</span>
                                </div>
                            </div>
                        </div>
                        <div class="stats-list">
                            <div class="stat-item">
                                <div class="stat-icon calories">
                                    <i class="fas fa-fire"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-label">Calories burn</div>
                                    <div class="stat-value">23,02k <span class="trend">+43%</span></div>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon protein">
                                    <i class="fas fa-dumbbell"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-label">Protein</div>
                                    <div class="stat-value">11,24k <span class="trend">+21%</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Fitness Goal Cards -->
        <div class="col-xl-4 col-lg-12">
            <div class="fitness-goals">
                <div class="goal-card side-planks">
                    <div class="goal-content">
                        <h4>Side planks</h4>
                        <p>16 mins/day</p>
                    </div>
                    <div class="goal-image">
                        <i class="fas fa-running"></i>
                    </div>
                </div>
                <div class="goal-card rope-lifting">
                    <div class="goal-content">
                        <h4>Rope lifting</h4>
                        <p>16 mins/day</p>
                    </div>
                    <div class="goal-image">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="row g-4 mt-4">
        <!-- Trainer Section -->
        <div class="col-xl-4 col-lg-6">
            <div class="dashboard-card trainer-card">
                <div class="card-header">
                    <h3 class="card-title">Management</h3>
                    <a href="#" class="view-all">View all</a>
                </div>
                <div class="card-body">
                    <div class="trainer-list">
                        <div class="trainer-item">
                            <div class="trainer-avatar">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="trainer-info">
                                <h5>User Management</h5>
                                <p>{{ $stats['total_users'] ?? 0 }} total users</p>
                            </div>
                            <a href="{{ route('admin.users') }}" class="trainer-action">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="trainer-item">
                            <div class="trainer-avatar">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <div class="trainer-info">
                                <h5>Role Management</h5>
                                <p>{{ $stats['total_roles'] ?? 0 }} active roles</p>
                            </div>
                            <a href="{{ route('admin.roles') }}" class="trainer-action">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="trainer-item">
                            <div class="trainer-avatar">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="trainer-info">
                                <h5>Permissions</h5>
                                <p>{{ $stats['total_permissions'] ?? 0 }} permissions</p>
                            </div>
                            <a href="{{ route('admin.permissions') }}" class="trainer-action">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommend Activity -->
        <div class="col-xl-4 col-lg-6">
            <div class="dashboard-card activity-recommend">
                <div class="card-header">
                    <h3 class="card-title">Recommend activity</h3>
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Monthly
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Daily</a></li>
                            <li><a class="dropdown-item" href="#">Weekly</a></li>
                            <li><a class="dropdown-item" href="#">Monthly</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="activity-info">
                                <h5>Create New User</h5>
                                <p>Add users to the system</p>
                            </div>
                            <a href="{{ route('admin.users.create') }}" class="activity-btn">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="activity-info">
                                <h5>System Settings</h5>
                                <p>Configure system preferences</p>
                            </div>
                            <a href="#" class="activity-btn">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="activity-info">
                                <h5>Analytics</h5>
                                <p>View system analytics</p>
                            </div>
                            <a href="#" class="activity-btn">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Heart Rate / System Status -->
        <div class="col-xl-4 col-lg-12">
            <div class="dashboard-card heart-rate-card">
                <div class="card-header">
                    <h3 class="card-title">System Status</h3>
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Weekly
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Hourly</a></li>
                            <li><a class="dropdown-item" href="#">Daily</a></li>
                            <li><a class="dropdown-item" href="#">Weekly</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="heart-rate-chart">
                        <canvas id="heartRateChart" width="300" height="120"></canvas>
                        <div class="status-info">
                            <div class="status-values">
                                <span class="current">98%</span>
                                <span class="average">Uptime</span>
                            </div>
                            <div class="status-days">
                                <span>Sun</span>
                                <span>Mon</span>
                                <span class="active">Tue</span>
                                <span>Wed</span>
                                <span>Thu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row - Output and Recommended Food -->
    <div class="row g-4 mt-4">
        <!-- Output Section -->
        <div class="col-xl-4 col-lg-6">
            <div class="dashboard-card output-card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Monthly
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Daily</a></li>
                            <li><a class="dropdown-item" href="#">Weekly</a></li>
                            <li><a class="dropdown-item" href="#">Monthly</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="output-items">
                        <div class="output-item">
                            <div class="output-icon">
                                <i class="fas fa-hamburger"></i>
                            </div>
                            <div class="output-info">
                                <span class="output-label">User Registration</span>
                                <span class="output-value">{{ $stats['total_users'] ?? 0 }} users</span>
                            </div>
                            <div class="output-percentage">+20%</div>
                        </div>
                        <div class="output-item">
                            <div class="output-icon">
                                <i class="fas fa-weight"></i>
                            </div>
                            <div class="output-info">
                                <span class="output-label">Active Sessions</span>
                                <span class="output-value">1.2k sessions</span>
                            </div>
                            <div class="output-percentage">+15%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Food / System Info -->
        <div class="col-xl-8 col-lg-6">
            <div class="dashboard-card food-card">
                <div class="card-header">
                    <h3 class="card-title">System Information</h3>
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Monthly
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Daily</a></li>
                            <li><a class="dropdown-item" href="#">Weekly</a></li>
                            <li><a class="dropdown-item" href="#">Monthly</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="food-grid">
                        <div class="food-item">
                            <div class="food-image">
                                <i class="fab fa-laravel"></i>
                            </div>
                            <div class="food-info">
                                <h5>Laravel Framework</h5>
                                <p>{{ app()->version() }}</p>
                                <span class="food-details">Framework</span>
                            </div>
                        </div>
                        <div class="food-item">
                            <div class="food-image">
                                <i class="fab fa-php"></i>
                            </div>
                            <div class="food-info">
                                <h5>PHP Version</h5>
                                <p>{{ phpversion() }}</p>
                                <span class="food-details">Runtime</span>
                            </div>
                        </div>
                        <div class="food-item">
                            <div class="food-image">
                                <i class="fas fa-database"></i>
                            </div>
                            <div class="food-info">
                                <h5>Database</h5>
                                <p>MySQL Connected</p>
                                <span class="food-details">Storage</span>
                            </div>
                        </div>
                        <div class="food-item">
                            <div class="food-image">
                                <i class="fas fa-server"></i>
                            </div>
                            <div class="food-info">
                                <h5>Environment</h5>
                                <p>{{ ucfirst(app()->environment()) }}</p>
                                <span class="food-details">Mode</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Fitness Dashboard Styles */
.fitness-dashboard {
    padding: 1.5rem;
    background: var(--bg-primary);
    min-height: 100vh;
}

.dashboard-top-header {
    background: linear-gradient(135deg, var(--bg-card), var(--bg-tertiary));
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid var(--border-primary);
}

.greeting-section .greeting-text {
    color: var(--text-muted);
    font-size: 1rem;
    font-weight: 400;
    margin-bottom: 0.5rem;
}

.greeting-section .welcome-back {
    color: var(--text-primary);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.greeting-section .user-name {
    color: var(--primary-color);
    font-size: 1.1rem;
    font-weight: 600;
}

.user-profile-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(247, 163, 26, 0.1);
    padding: 1rem;
    border-radius: 16px;
    border: 1px solid rgba(247, 163, 26, 0.2);
}

.profile-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: var(--bg-primary);
}

.profile-name {
    color: var(--text-primary);
    font-weight: 600;
    font-size: 1rem;
}

.profile-role {
    color: var(--text-muted);
    font-size: 0.875rem;
}

.dashboard-card {
    background: linear-gradient(135deg, var(--bg-card), var(--bg-tertiary));
    border: 1px solid var(--border-primary);
    border-radius: 20px;
    padding: 0;
    box-shadow: var(--shadow-md);
    transition: var(--transition-normal);
    height: 100%;
}

.dashboard-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.card-header {
    padding: 1.5rem 1.5rem 0;
    display: flex;
    justify-content: between;
    align-items: center;
}

.card-title {
    color: var(--text-primary);
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}

.card-body {
    padding: 1.5rem;
}

.dropdown-toggle {
    color: var(--text-muted);
    font-size: 0.875rem;
    text-decoration: none;
    border: none;
    background: none;
}

.dropdown-toggle:hover {
    color: var(--primary-color);
}

/* Activity Chart */
.activity-chart {
    margin-top: 1rem;
}

.chart-bars {
    display: flex;
    align-items: end;
    gap: 0.5rem;
    height: 120px;
    margin-bottom: 1rem;
}

.bar {
    flex: 1;
    background: var(--border-primary);
    border-radius: 4px;
    min-height: 20px;
    transition: var(--transition-normal);
}

.bar.active {
    background: linear-gradient(180deg, var(--primary-color), var(--primary-light));
}

.chart-labels {
    display: flex;
    justify-content: space-between;
    font-size: 0.75rem;
    color: var(--text-muted);
}

/* Overview Stats */
.overview-stats {
    display: flex;
    gap: 2rem;
    align-items: center;
}

.stat-circle {
    position: relative;
    width: 120px;
    height: 120px;
}

.circle-progress svg {
    width: 120px;
    height: 120px;
    transform: rotate(-90deg);
}

.circle-progress circle {
    fill: none;
    stroke-width: 8;
}

.circle-progress circle:first-child {
    stroke: var(--border-primary);
}

.circle-progress .progress-circle {
    stroke: var(--primary-color);
    stroke-dasharray: 314;
    stroke-dashoffset: 50;
    stroke-linecap: round;
}

.circle-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.circle-content .percentage {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
}

.circle-content .label {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.stats-list {
    flex: 1;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.stat-icon.calories {
    background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
    color: white;
}

.stat-icon.protein {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: var(--bg-primary);
}

.stat-label {
    color: var(--text-muted);
    font-size: 0.875rem;
}

.stat-value {
    color: var(--text-primary);
    font-weight: 600;
}

.trend {
    color: var(--success);
    font-size: 0.75rem;
    margin-left: 0.5rem;
}

/* Fitness Goals */
.fitness-goals {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.goal-card {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: var(--bg-primary);
    min-height: 100px;
}

.goal-card.rope-lifting {
    background: linear-gradient(135deg, #00d084, #26e0a3);
}

.goal-content h4 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.goal-content p {
    font-size: 0.875rem;
    opacity: 0.8;
    margin: 0;
}

.goal-image {
    font-size: 2rem;
    opacity: 0.7;
}

/* Trainer/Management Section */
.trainer-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.trainer-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.02);
    border-radius: 12px;
    border: 1px solid var(--border-primary);
    transition: var(--transition-fast);
}

.trainer-item:hover {
    background: rgba(247, 163, 26, 0.05);
    border-color: rgba(247, 163, 26, 0.2);
}

.trainer-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bg-primary);
    font-size: 1rem;
}

.trainer-info {
    flex: 1;
}

.trainer-info h5 {
    color: var(--text-primary);
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.trainer-info p {
    color: var(--text-muted);
    font-size: 0.8rem;
    margin: 0;
}

.trainer-action {
    color: var(--text-muted);
    text-decoration: none;
    transition: var(--transition-fast);
}

.trainer-action:hover {
    color: var(--primary-color);
}

/* Activity Recommend */
.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.02);
    border-radius: 12px;
    border: 1px solid var(--border-primary);
    transition: var(--transition-fast);
}

.activity-item:hover {
    background: rgba(247, 163, 26, 0.05);
    border-color: rgba(247, 163, 26, 0.2);
}

.activity-icon {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bg-primary);
    font-size: 0.9rem;
}

.activity-info {
    flex: 1;
}

.activity-info h5 {
    color: var(--text-primary);
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.activity-info p {
    color: var(--text-muted);
    font-size: 0.75rem;
    margin: 0;
}

.activity-btn {
    width: 30px;
    height: 30px;
    background: rgba(247, 163, 26, 0.1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.8rem;
    transition: var(--transition-fast);
}

.activity-btn:hover {
    background: rgba(247, 163, 26, 0.2);
    color: var(--primary-color);
}

/* Heart Rate Chart */
.heart-rate-chart {
    position: relative;
}

#heartRateChart {
    width: 100%;
    height: 120px;
}

.status-info {
    margin-top: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.status-values .current {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
}

.status-values .average {
    color: var(--text-muted);
    font-size: 0.875rem;
}

.status-days {
    display: flex;
    gap: 0.5rem;
}

.status-days span {
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.status-days span.active {
    background: var(--primary-color);
    color: var(--bg-primary);
}

/* Output Section */
.output-items {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.output-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.02);
    border-radius: 12px;
    border: 1px solid var(--border-primary);
}

.output-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bg-primary);
    font-size: 1rem;
}

.output-info {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.output-label {
    color: var(--text-muted);
    font-size: 0.8rem;
}

.output-value {
    color: var(--text-primary);
    font-weight: 600;
    font-size: 0.9rem;
}

.output-percentage {
    color: var(--success);
    font-size: 0.8rem;
    font-weight: 600;
}

/* Food Grid */
.food-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.food-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.02);
    border-radius: 12px;
    border: 1px solid var(--border-primary);
    transition: var(--transition-fast);
}

.food-item:hover {
    background: rgba(247, 163, 26, 0.05);
    border-color: rgba(247, 163, 26, 0.2);
}

.food-image {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bg-primary);
    font-size: 1.1rem;
}

.food-info h5 {
    color: var(--text-primary);
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.food-info p {
    color: var(--text-secondary);
    font-size: 0.8rem;
    margin-bottom: 0.25rem;
}

.food-details {
    color: var(--text-muted);
    font-size: 0.75rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .fitness-dashboard {
        padding: 1rem;
    }
    
    .dashboard-top-header {
        padding: 1.5rem;
    }
    
    .greeting-section .welcome-back {
        font-size: 1.5rem;
    }
    
    .user-profile-card {
        margin-top: 1rem;
    }
    
    .overview-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .fitness-goals {
        margin-top: 1rem;
    }
    
    .food-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .overview-stats {
        text-align: center;
    }
    
    .stat-circle {
        margin: 0 auto;
    }
}
</style>

<script>
// Simple heart rate chart simulation
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('heartRateChart');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        const width = canvas.width;
        const height = canvas.height;
        
        // Clear canvas
        ctx.clearRect(0, 0, width, height);
        
        // Draw heart rate line
        ctx.strokeStyle = '#f7a31a';
        ctx.lineWidth = 2;
        ctx.beginPath();
        
        const points = [];
        for (let i = 0; i <= width; i += 10) {
            const y = height/2 + Math.sin(i * 0.02) * 20 + Math.random() * 10 - 5;
            points.push({x: i, y: y});
        }
        
        ctx.moveTo(points[0].x, points[0].y);
        for (let i = 1; i < points.length; i++) {
            ctx.lineTo(points[i].x, points[i].y);
        }
        ctx.stroke();
        
        // Add some peaks for heart rate effect
        ctx.strokeStyle = '#f7a31a';
        ctx.lineWidth = 3;
        for (let i = 50; i < width; i += 80) {
            ctx.beginPath();
            ctx.moveTo(i, height/2);
            ctx.lineTo(i + 5, height/2 - 30);
            ctx.lineTo(i + 10, height/2 + 30);
            ctx.lineTo(i + 15, height/2);
            ctx.stroke();
        }
    }
    
    // Update time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        const timeElement = document.getElementById('current-time');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }
    
    updateTime();
    setInterval(updateTime, 1000);
});
</script>
@endsection 