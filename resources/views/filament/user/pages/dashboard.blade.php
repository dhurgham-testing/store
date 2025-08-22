<x-filament-panels::page>
    <div class="dashboard-container">
        {{-- Floating Shapes Background --}}
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        {{-- Main Content --}}
        <div class="dashboard-content">
            {{-- Welcome Section --}}
            <div class="welcome-section">
                <h1 class="dashboard-title">Welcome to Abr Store</h1>
                <p class="dashboard-subtitle">Your Ultimate Shopping Destination</p>

                @if($user)
                    <p class="user-greeting">Hello, {{ $user->name }}! 👋</p>
                @endif
            </div>

            {{-- Stats Cards --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $stats['orders'] }}</h3>
                        <p class="stat-label">Total Orders</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">${{ number_format($stats['total_spent'], 2) }}</h3>
                        <p class="stat-label">Total Spent</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $stats['products'] }}</h3>
                        <p class="stat-label">Available Products</p>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="actions-section">
                <h2 class="section-title">Quick Actions</h2>
                <div class="actions-grid">
                    <a href="/user/products" class="action-card">
                        <div class="action-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="action-title">Browse Products</h3>
                        <p class="action-description">Discover our amazing collection</p>
                    </a>

                    <a href="/user/cart" class="action-card">
                        <div class="action-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                            </svg>
                        </div>
                        <h3 class="action-title">Shopping Cart</h3>
                        <p class="action-description">View your cart items</p>
                    </a>

                    <a href="/user/orders" class="action-card">
                        <div class="action-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="action-title">My Orders</h3>
                        <p class="action-description">Track your order history</p>
                    </a>
                </div>
            </div>

            {{-- Social Links --}}
            <div class="social-section">
                <h2 class="section-title">Connect With Us</h2>
                <div class="social-links">
                    <a href="https://t.me/hottmail" class="social-link" target="_blank">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
                        </svg>
                        <span>Telegram</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Dashboard Styling - Matching Welcome Page Design */
        .dashboard-container {
            position: relative;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            overflow-x: hidden;
            padding: 2rem;
        }

        .dashboard-content {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        /* Floating Shapes */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Welcome Section */
        .welcome-section {
            text-align: center;
            margin-bottom: 4rem;
        }

        .dashboard-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .dashboard-subtitle {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 1rem;
            opacity: 0.9;
            letter-spacing: 1px;
        }

        .user-greeting {
            font-size: 1.2rem;
            opacity: 0.8;
            margin-bottom: 2rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }

        .stat-icon {
            background: rgba(255, 255, 255, 0.2);
            padding: 1rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.8;
            margin: 0;
        }

        /* Actions Section */
        .actions-section {
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .action-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
            text-align: center;
        }

        .action-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .action-icon {
            background: rgba(255, 255, 255, 0.2);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .action-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0 0 0.5rem 0;
        }

        .action-description {
            font-size: 0.9rem;
            opacity: 0.8;
            margin: 0;
        }

        /* Social Section */
        .social-section {
            text-align: center;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            text-decoration: none;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem;
            }

            .dashboard-title {
                font-size: 2.5rem;
            }

            .dashboard-subtitle {
                font-size: 1.2rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .actions-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stat-card {
                padding: 1.5rem;
            }

            .action-card {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .dashboard-title {
                font-size: 2rem;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
            }

            .social-links {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</x-filament-panels::page>
