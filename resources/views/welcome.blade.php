<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Abr Store - Coming Soon</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            overflow-x: hidden;
        }

        .container {
            text-align: center;
            padding: 2rem;
            max-width: 1200px;
            width: 100%;
        }

        .logo {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .tagline {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 3rem;
            opacity: 0.9;
            letter-spacing: 1px;
        }

        .coming-soon {
            font-size: 4rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            animation: pulse 2s infinite;
        }

        .description {
            font-size: 1.2rem;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
            opacity: 0.8;
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .countdown-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1.5rem;
            min-width: 120px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .countdown-number {
            font-size: 2.5rem;
            font-weight: 700;
            display: block;
            margin-bottom: 0.5rem;
        }

        .countdown-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
        }



        .social-links {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }

        .social-link {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }

        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
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

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .logo {
                font-size: 2.5rem;
            }

            .coming-soon {
                font-size: 2.5rem;
                letter-spacing: 2px;
            }

            .tagline {
                font-size: 1.2rem;
            }

            .description {
                font-size: 1rem;
            }

            .countdown {
                gap: 1rem;
            }

            .countdown-item {
                min-width: 80px;
                padding: 1rem;
            }

            .countdown-number {
                font-size: 1.8rem;
            }

            .countdown-label {
                font-size: 0.8rem;
            }



            .container {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .logo {
                font-size: 2rem;
            }

            .coming-soon {
                font-size: 2rem;
                letter-spacing: 1px;
            }

            .countdown {
                gap: 0.5rem;
            }

            .countdown-item {
                min-width: 70px;
                padding: 0.8rem;
            }

            .countdown-number {
                font-size: 1.5rem;
            }

            .social-links {
                gap: 1rem;
            }

            .social-link {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="container">
        <h1 class="logo">Abr Store</h1>
        <p class="tagline">Your Ultimate Shopping Destination</p>
        
        <h2 class="coming-soon">Coming Soon</h2>
        
        <p class="description">
            We're working hard to bring you an amazing shopping experience. 
            Get ready for exclusive deals, premium products, and exceptional service.
        </p>

        <div class="countdown">
            <div class="countdown-item">
                <span class="countdown-number" id="days">00</span>
                <span class="countdown-label">Days</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number" id="hours">00</span>
                <span class="countdown-label">Hours</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number" id="minutes">00</span>
                <span class="countdown-label">Minutes</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number" id="seconds">00</span>
                <span class="countdown-label">Seconds</span>
            </div>
        </div>



        <div class="social-links">
            <a href="https://t.me/hottmail" class="social-link" target="_blank">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
                </svg>
            </a>
        </div>
    </div>

    <script>
        function updateCountdown() {
            const now = new Date().getTime();
            const launchDate = new Date('2025-08-31T00:00:00').getTime();
            const distance = launchDate - now;

            if (distance > 0) {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('days').textContent = days.toString().padStart(2, '0');
                document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
                document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
                document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
            } else {
                document.querySelector('.countdown').innerHTML = '<h2>We\'re Live! 🎉</h2>';
            }
        }

        setInterval(updateCountdown, 1000);
        updateCountdown();


    </script>
</body>
</html>
