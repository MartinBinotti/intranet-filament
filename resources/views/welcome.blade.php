<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Intranet') }} - Portal de Acceso</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&family=orbitron:400,700,900" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #00f0ff;
            --secondary-color: #7b2ff7;
            --accent-color: #ff006e;
            --success-color: #00ff9f;
            --warning-color: #ffd700;
            --bg-dark: #0a0e1a;
            --bg-darker: #050810;
            --text-light: #e0e6ed;
            --text-muted: #8892a6;
            --border-color: rgba(0, 240, 255, 0.2);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-darker);
            color: var(--text-light);
            overflow-x: hidden;
            cursor: none;
            /* Cursor personalizado */
        }

        /* Custom Cursor */
        #custom-cursor {
            position: fixed;
            width: 20px;
            height: 20px;
            border: 2px solid var(--primary-color);
            border-radius: 50%;
            pointer-events: none;
            z-index: 10000;
            transition: transform 0.15s ease;
            box-shadow: 0 0 20px var(--primary-color);
        }

        #custom-cursor::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 4px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 50%;
        }

        /* Particle System */
        .particle {
            position: fixed;
            width: 4px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            opacity: 0;
            box-shadow: 0 0 10px var(--primary-color);
        }

        /* Status Widget */
        .status-widget {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 100;
            background: rgba(10, 14, 26, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            min-width: 250px;
            animation: fadeInDown 1s ease-out 0.5s both;
        }

        .widget-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .widget-row:last-child {
            margin-bottom: 0;
        }

        .widget-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
        }

        .widget-value {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.875rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: var(--success-color);
            border-radius: 50%;
            margin-left: 0.5rem;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.2);
            }
        }

        /* Logo Container */
        .logo-container {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 100;
            animation: fadeInDown 1s ease-out;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            /* Indicar interactividad */
        }

        .logo-container:hover .logo-scorpion {
            filter: drop-shadow(0 0 8px var(--accent-color));
            transform: scale(1.1);
        }

        /* Scorpion Design */
        .logo-scorpion {
            width: 60px;
            height: 60px;
            filter: drop-shadow(0 0 3px var(--primary-color));
            transition: all 0.3s ease;
            animation: floatScorpion 6s ease-in-out infinite;
        }

        .scorpion-body,
        .scorpion-legs path,
        .scorpion-tail-segment,
        .scorpion-pincer {
            fill: none;
            stroke: var(--primary-color);
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
            transition: stroke 0.3s ease;
        }

        .scorpion-stinger {
            fill: var(--primary-color);
            stroke: none;
            transition: fill 0.3s ease;
        }

        /* Hover Interaction */
        .logo-container:hover .scorpion-body,
        .logo-container:hover .scorpion-legs path,
        .logo-container:hover .scorpion-tail-segment,
        .logo-container:hover .scorpion-pincer {
            stroke: var(--accent-color);
        }

        .logo-container:hover .scorpion-stinger {
            fill: var(--accent-color);
        }

        .logo-container:hover .scorpion-tail-group {
            animation: attackSting 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) infinite alternate;
        }

        .logo-container:hover .venom-drop {
            animation: dripVenom 1s infinite;
        }

        /* Animations */
        @keyframes floatScorpion {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-3px) rotate(2deg);
            }
        }

        @keyframes attackSting {
            0% {
                transform: rotate(0deg) scale(1);
            }

            100% {
                transform: rotate(-5deg) scale(1.05);
            }
        }

        @keyframes dripVenom {
            0% {
                opacity: 0;
                transform: translateY(0);
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translateY(10px);
            }
        }

        .scorpion-tail-group {
            transform-origin: 60px 70px;
            /* Pivote ajustado para la cola */
            transition: transform 0.3s ease;
        }

        .logo-text {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.75rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 2px;
            text-transform: uppercase;
            position: relative;
            transition: all 0.3s ease;
        }

        .logo-container:hover .logo-text {
            text-shadow: 0 0 10px rgba(255, 0, 110, 0.3);
            /* Accent glow */
        }

        .logo-text::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), transparent);
            animation: glowPulse 2s ease-in-out infinite;
            transition: background 0.3s ease;
        }

        .logo-container:hover .logo-text::after {
            background: linear-gradient(90deg, var(--accent-color), transparent);
        }

        /* Main Container */
        .container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Left Side - Futuristic Background */
        .left-section {
            flex: 1;
            position: relative;
            background: linear-gradient(135deg, #0a0e1a 0%, #1a1f35 50%, #0f1629 100%);
            overflow: hidden;
        }

        /* Animated Grid Background */
        .grid-background {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(0, 240, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 240, 255, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(50px, 50px);
            }
        }

        /* Geometric Shapes */
        .geometric-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .shape {
            position: absolute;
            border: 1px solid rgba(0, 240, 255, 0.3);
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            width: 200px;
            height: 200px;
            top: 20%;
            left: 15%;
            border-radius: 50%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 150px;
            height: 150px;
            top: 60%;
            left: 60%;
            transform: rotate(45deg);
            animation-delay: 1s;
        }

        .shape-3 {
            width: 100px;
            height: 100px;
            top: 40%;
            left: 70%;
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
            border: 2px solid rgba(123, 47, 247, 0.4);
            animation-delay: 2s;
        }

        .shape-4 {
            width: 180px;
            height: 180px;
            top: 70%;
            left: 20%;
            border-radius: 30%;
            border: 1px solid rgba(255, 0, 110, 0.3);
            animation-delay: 1.5s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        /* Glowing Lines */
        .glow-lines {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .line {
            position: absolute;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
            height: 1px;
            animation: lineGlow 3s ease-in-out infinite;
        }

        .line-1 {
            width: 300px;
            top: 30%;
            left: -300px;
            animation-delay: 0s;
        }

        .line-2 {
            width: 400px;
            top: 60%;
            left: -400px;
            animation-delay: 1.5s;
            background: linear-gradient(90deg, transparent, var(--secondary-color), transparent);
        }

        .line-3 {
            width: 250px;
            top: 80%;
            left: -250px;
            animation-delay: 3s;
        }

        @keyframes lineGlow {
            0% {
                left: -100%;
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                left: 100%;
                opacity: 0;
            }
        }

        /* Central Feature - 3D Cube */
        .feature-3d {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            perspective: 1000px;
        }

        .cube {
            width: 150px;
            height: 150px;
            position: relative;
            transform-style: preserve-3d;
            animation: rotateCube 20s linear infinite;
        }

        .cube-face {
            position: absolute;
            width: 150px;
            height: 150px;
            border: 1px solid rgba(0, 240, 255, 0.4);
            background: rgba(0, 240, 255, 0.02);
            backdrop-filter: blur(10px);
        }

        .cube-face.front {
            transform: translateZ(75px);
        }

        .cube-face.back {
            transform: rotateY(180deg) translateZ(75px);
        }

        .cube-face.right {
            transform: rotateY(90deg) translateZ(75px);
        }

        .cube-face.left {
            transform: rotateY(-90deg) translateZ(75px);
        }

        .cube-face.top {
            transform: rotateX(90deg) translateZ(75px);
        }

        .cube-face.bottom {
            transform: rotateX(-90deg) translateZ(75px);
        }

        @keyframes rotateCube {
            0% {
                transform: rotateX(0deg) rotateY(0deg);
            }

            100% {
                transform: rotateX(360deg) rotateY(360deg);
            }
        }

        /* Right Side - Login Form */
        .right-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-dark);
            position: relative;
        }

        .right-section::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom,
                    transparent,
                    var(--primary-color),
                    var(--secondary-color),
                    var(--primary-color),
                    transparent);
            animation: borderGlow 3s ease-in-out infinite;
        }

        @keyframes borderGlow {

            0%,
            100% {
                opacity: 0.3;
            }

            50% {
                opacity: 1;
            }
        }

        /* Scan Animation Overlay */
        .scan-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(5, 8, 16, 0.95);
            z-index: 10001;
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .scan-overlay.active {
            display: flex;
            animation: fadeIn 0.3s ease-out;
        }

        .scan-grid {
            width: 300px;
            height: 300px;
            position: relative;
            border: 2px solid var(--primary-color);
            box-shadow: 0 0 30px var(--primary-color);
        }

        .scan-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: var(--primary-color);
            box-shadow: 0 0 20px var(--primary-color);
            animation: scan 2s linear infinite;
        }

        @keyframes scan {
            0% {
                top: 0;
            }

            100% {
                top: 100%;
            }
        }

        .scan-text {
            margin-top: 2rem;
            font-family: 'Orbitron', sans-serif;
            color: var(--primary-color);
            font-size: 1.5rem;
            animation: textPulse 1s ease-in-out infinite;
        }

        @keyframes textPulse {

            0%,
            100% {
                opacity: 0.5;
            }

            50% {
                opacity: 1;
            }
        }

        /* Login Container */
        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 3rem;
            animation: fadeInUp 1s ease-out;
        }

        .login-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .login-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-title:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, var(--accent-color), #ff4d4d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 10px var(--accent-color));
        }

        .login-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 300;
        }

        /* Form Styles */
        .login-form {
            margin-top: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.25rem;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-light);
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            position: relative;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 20px rgba(0, 240, 255, 0.1);
        }

        .form-input::placeholder {
            color: var(--text-muted);
            opacity: 0.5;
        }

        /* Typing Scanner Effect */
        .input-scanner {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2px;
            width: 0;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            transition: width 0.3s ease;
            box-shadow: 0 0 10px var(--primary-color);
        }

        .form-input:focus~.input-scanner {
            width: 100%;
        }

        /* Password Strength Indicator */
        .password-strength {
            margin-top: 0.5rem;
            display: flex;
            gap: 0.25rem;
            height: 4px;
        }

        .strength-bar {
            flex: 1;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .strength-bar.active {
            background: var(--primary-color);
            box-shadow: 0 0 10px var(--primary-color);
        }

        .strength-bar.active.weak {
            background: var(--accent-color);
            box-shadow: 0 0 10px var(--accent-color);
        }

        .strength-bar.active.medium {
            background: var(--warning-color);
            box-shadow: 0 0 10px var(--warning-color);
        }

        .strength-bar.active.strong {
            background: var(--success-color);
            box-shadow: 0 0 10px var(--success-color);
        }

        .strength-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
            text-align: right;
        }

        .form-checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .form-checkbox {
            width: 18px;
            height: 18px;
            margin-right: 0.75rem;
            accent-color: var(--primary-color);
            cursor: pointer;
        }

        .form-checkbox-label {
            font-size: 0.875rem;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 8px;
            color: var(--bg-darker);
            font-family: 'Orbitron', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 240, 255, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Quick Access Cards */
        .quick-access {
            margin-top: 2.5rem;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .access-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: var(--text-light);
        }

        .access-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--primary-color);
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 240, 255, 0.2);
        }

        .card-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .card-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card-subtitle {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        /* Additional Links */
        .form-footer {
            margin-top: 2rem;
            text-align: center;
        }

        .link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }

        .link:hover::after {
            width: 100%;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes glowPulse {

            0%,
            100% {
                box-shadow: 0 0 5px var(--primary-color);
            }

            50% {
                box-shadow: 0 0 20px var(--primary-color);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
            }

            .left-section {
                min-height: 40vh;
            }

            .logo-container {
                top: 1rem;
                left: 1rem;
            }

            .status-widget {
                top: 1rem;
                right: 1rem;
                min-width: 200px;
                padding: 0.75rem 1rem;
            }

            .logo-text {
                font-size: 1.5rem;
            }

            .login-container {
                padding: 2rem;
            }

            .quick-access {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .login-container {
                padding: 1.5rem;
            }

            .login-title {
                font-size: 2rem;
            }

            .left-section {
                min-height: 30vh;
            }

            .status-widget {
                font-size: 0.75rem;
                min-width: 180px;
            }
        }
    </style>
</head>

<body>
    <!-- Custom Cursor -->
    <div id="custom-cursor"></div>

    <!-- Scan Overlay -->
    <div class="scan-overlay" id="scanOverlay">
        <div class="scan-grid">
            <div class="scan-line"></div>
        </div>
        <div class="scan-text">BIOMETRIC SCAN IN PROGRESS...</div>
    </div>

    <!-- Status Widget -->
    <div class="status-widget">
        <div class="widget-row">
            <span class="widget-label">Status</span>
            <span class="widget-value">
                Online
                <span class="status-indicator"></span>
            </span>
        </div>
        <div class="widget-row">
            <span class="widget-label">Time</span>
            <span class="widget-value" id="current-time">--:--</span>
        </div>
        <div class="widget-row">
            <span class="widget-label">Users</span>
            <span class="widget-value" id="user-count">24</span>
        </div>
    </div>

    <!-- Logo -->
    <div class="logo-container">
        <!-- Tech Scorpion SVG -->
        <svg class="logo-scorpion" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="scorpionGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:var(--primary-color);stop-opacity:1" />
                    <stop offset="100%" style="stop-color:var(--secondary-color);stop-opacity:1" />
                </linearGradient>
                <filter id="glow">
                    <feGaussianBlur stdDeviation="2.5" result="coloredBlur" />
                    <feMerge>
                        <feMergeNode in="coloredBlur" />
                        <feMergeNode in="SourceGraphic" />
                    </feMerge>
                </filter>
            </defs>

            <g class="scorpion-group" filter="url(#glow)">
                <!-- Body Segments -->
                <path class="scorpion-body" d="M50 45 L55 50 L50 65 L45 50 Z" />
                <path class="scorpion-body" d="M50 45 L58 40 L60 30" /> <!-- Right Pincer Arm -->
                <path class="scorpion-body" d="M50 45 L42 40 L40 30" /> <!-- Left Pincer Arm -->

                <!-- Pincers -->
                <path class="scorpion-pincer left" d="M40 30 Q 35 20 45 25 M40 30 Q 30 25 35 15" />
                <path class="scorpion-pincer right" d="M60 30 Q 65 20 55 25 M60 30 Q 70 25 65 15" />

                <!-- Legs Right -->
                <g class="scorpion-legs right">
                    <path d="M55 52 L65 50 L70 55" />
                    <path d="M54 56 L68 58 L72 65" />
                    <path d="M52 60 L65 65 L68 72" />
                    <path d="M50 63 L60 70 L62 78" />
                </g>

                <!-- Legs Left -->
                <g class="scorpion-legs left">
                    <path d="M45 52 L35 50 L30 55" />
                    <path d="M46 56 L32 58 L28 65" />
                    <path d="M48 60 L35 65 L32 72" />
                    <path d="M50 63 L40 70 L38 78" />
                </g>

                <!-- Tail -->
                <g class="scorpion-tail-group">
                    <path class="scorpion-tail-segment" d="M50 65 Q 50 75 50 80" />
                    <path class="scorpion-tail-segment" d="M50 80 Q 55 90 65 85" />
                    <path class="scorpion-tail-segment" d="M65 85 Q 75 80 70 65" />
                    <path class="scorpion-tail-segment" d="M70 65 Q 65 55 55 60" />

                    <!-- Stinger -->
                    <path class="scorpion-stinger" d="M55 60 L 48 65 L 56 64" fill="var(--primary-color)" />
                    <circle class="venom-drop" cx="48" cy="65" r="1.5" fill="var(--accent-color)" opacity="0" />
                </g>
            </g>
        </svg>
        <div class="logo-text">{{ config('app.name', 'INTRANET') }}</div>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Left Section - Futuristic Background -->
        <div class="left-section">
            <!-- Animated Grid -->
            <div class="grid-background"></div>

            <!-- Geometric Shapes -->
            <div class="geometric-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
                <div class="shape shape-4"></div>
            </div>

            <!-- Glowing Lines -->
            <div class="glow-lines">
                <div class="line line-1"></div>
                <div class="line line-2"></div>
                <div class="line line-3"></div>
            </div>

            <!-- 3D Cube Feature -->
            <div class="feature-3d">
                <div class="cube">
                    <div class="cube-face front"></div>
                    <div class="cube-face back"></div>
                    <div class="cube-face right"></div>
                    <div class="cube-face left"></div>
                    <div class="cube-face top"></div>
                    <div class="cube-face bottom"></div>
                </div>
            </div>
        </div>

        <!-- Right Section - Login Form -->
        <div class="right-section">
            <div class="login-container">
                <div class="login-header">
                    <a href="{{ url('/dashboard') }}" class="login-title" style="text-decoration: none; display: inline-block; cursor: pointer; transition: transform 0.3s ease;">Acceso</a>
                    <p class="login-subtitle">Portal de Empleados - Sistema de Gestión Interna</p>
                </div>

                @if (Route::has('login'))
                @auth
                <!-- If already authenticated, show dashboard link -->
                <div style="text-align: center;">
                    <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Ya has iniciado sesión</p>
                    <a href="{{ url('/dashboard') }}" class="btn-submit" style="display: inline-block; text-decoration: none; padding: 1rem 3rem; width: auto;">
                        Ir al Dashboard
                    </a>
                </div>
                @else
                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="login-form" id="loginForm">
                    @csrf

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            placeholder="usuario@empresa.com"
                            value="{{ old('email') }}"
                            required
                            autofocus>
                        <div class="input-scanner"></div>
                        @error('email')
                        <span style="color: var(--accent-color); font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="••••••••"
                            required>
                        <div class="input-scanner"></div>
                        <!-- Password Strength Indicator -->
                        <div class="password-strength">
                            <div class="strength-bar" data-strength="1"></div>
                            <div class="strength-bar" data-strength="2"></div>
                            <div class="strength-bar" data-strength="3"></div>
                            <div class="strength-bar" data-strength="4"></div>
                        </div>
                        <div class="strength-text" id="strengthText"></div>
                        @error('password')
                        <span style="color: var(--accent-color); font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-checkbox-group">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            class="form-checkbox">
                        <label for="remember" class="form-checkbox-label">Mantener sesión iniciada</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        Iniciar Sesión
                    </button>
                </form>

                <!-- Additional Links -->
                <div class="form-footer">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link">¿Olvidaste tu contraseña?</a>
                    @endif
                </div>
                @endauth
                @endif

                <!-- Quick Access Cards - Always visible -->
                <div class="quick-access">
                    <a href="{{ url('/dashboard') }}" class="access-card">
                        <div class="card-icon">📊</div>
                        <div class="card-title">Dashboard</div>
                        <div class="card-subtitle">Panel Principal</div>
                    </a>
                    <a href="{{ url('/dashboard/users') }}" class="access-card">
                        <div class="card-icon">👥</div>
                        <div class="card-title">Usuarios</div>
                        <div class="card-subtitle">Gestión</div>
                    </a>
                    <a href="#" class="access-card">
                        <div class="card-icon">📁</div>
                        <div class="card-title">Documentos</div>
                        <div class="card-subtitle">Archivos</div>
                    </a>
                    <a href="#" class="access-card">
                        <div class="card-icon">💼</div>
                        <div class="card-title">Proyectos</div>
                        <div class="card-subtitle">En curso</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Custom Cursor
        const cursor = document.getElementById('custom-cursor');
        let mouseX = 0,
            mouseY = 0;
        let cursorX = 0,
            cursorY = 0;

        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
        });

        function animateCursor() {
            cursorX += (mouseX - cursorX) * 0.3;
            cursorY += (mouseY - cursorY) * 0.3;
            cursor.style.left = cursorX + 'px';
            cursor.style.top = cursorY + 'px';
            requestAnimationFrame(animateCursor);
        }
        animateCursor();

        // Interactive Particles
        let particles = [];
        const particleCount = 50;

        function createParticle(x, y) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = x + 'px';
            particle.style.top = y + 'px';
            document.body.appendChild(particle);

            const angle = Math.random() * Math.PI * 2;
            const velocity = Math.random() * 2 + 1;
            const life = Math.random() * 30 + 20;

            particles.push({
                element: particle,
                x: x,
                y: y,
                vx: Math.cos(angle) * velocity,
                vy: Math.sin(angle) * velocity,
                life: life,
                maxLife: life
            });
        }

        document.addEventListener('mmousemove', (e) => {
            if (Math.random() > 0.95) {
                createParticle(e.clientX, e.clientY);
            }
        });

        function updateParticles() {
            particles = particles.filter(p => {
                p.x += p.vx;
                p.y += p.vy;
                p.life--;

                const opacity = p.life / p.maxLife;
                p.element.style.left = p.x + 'px';
                p.element.style.top = p.y + 'px';
                p.element.style.opacity = opacity;

                if (p.life <= 0) {
                    p.element.remove();
                    return false;
                }
                return true;
            });
        }

        setInterval(updateParticles, 1000 / 60);

        // Clock Widget
        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('current-time').textContent = `${hours}:${minutes}`;
        }
        updateTime();
        setInterval(updateTime, 1000);

        // User Count Animation
        let targetCount = 24;
        let currentCount = 0;

        function animateCount() {
            if (currentCount < targetCount) {
                currentCount++;
                document.getElementById('user-count').textContent = currentCount;
                setTimeout(animateCount, 50);
            }
        }
        animateCount();

        // Password Strength Indicator
        const passwordInput = document.getElementById('password');
        const strengthText = document.getElementById('strengthText');
        const strengthBars = document.querySelectorAll('.strength-bar');

        if (passwordInput) {
            passwordInput.addEventListener('input', (e) => {
                const password = e.target.value;
                const strength = calculatePasswordStrength(password);

                strengthBars.forEach((bar, index) => {
                    bar.classList.remove('active', 'weak', 'medium', 'strong');
                    if (index < strength.level) {
                        bar.classList.add('active', strength.class);
                    }
                });

                strengthText.textContent = strength.text;
            });
        }

        function calculatePasswordStrength(password) {
            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.length >= 10) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/\d/.test(password) && /[^a-zA-Z\d]/.test(password)) strength++;

            const levels = [{
                    level: 0,
                    class: '',
                    text: ''
                },
                {
                    level: 1,
                    class: 'weak',
                    text: 'Débil'
                },
                {
                    level: 2,
                    class: 'weak',
                    text: 'Regular'
                },
                {
                    level: 3,
                    class: 'medium',
                    text: 'Buena'
                },
                {
                    level: 4,
                    class: 'strong',
                    text: 'Excelente'
                }
            ];

            return levels[strength];
        }

        // Biometric Scan Animation
        const loginForm = document.getElementById('loginForm');
        const scanOverlay = document.getElementById('scanOverlay');

        if (loginForm) {
            loginForm.addEventListener('submit', (e) => {
                e.preventDefault();
                scanOverlay.classList.add('active');

                setTimeout(() => {
                    scanOverlay.classList.remove('active');
                    loginForm.submit();
                }, 2000);
            });
        }

        // Hover effects for cursor
        const interactiveElements = document.querySelectorAll('a, button, input, .access-card');
        interactiveElements.forEach(el => {
            el.addEventListener('mouseenter', () => {
                cursor.style.transform = 'scale(1.5)';
                cursor.style.borderColor = 'var(--secondary-color)';
            });
            el.addEventListener('mouseleave', () => {
                cursor.style.transform = 'scale(1)';
                cursor.style.borderColor = 'var(--primary-color)';
            });
        });
    </script>
</body>

</html>