@extends('layouts.public')

@section('title', 'FITTELLY - Fitness Platform')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/swiper@10/swiper-bundle.min.css">
<style>
    /* Override main content padding for homepage */
    .main-content {
        padding-top: 0;
    }

    :root {
        --primary-color: #f7a31a;
        --secondary-color: #1a1a1a;
        --text-light: #ffffff;
        --text-dark: #333333;
        --bg-dark: #0a0a0a;
        --bg-card: #1a1a1a;
        --bg-glass: rgba(26, 26, 26, 0.15);
        --border-glass: rgba(255, 255, 255, 0.1);
        --shadow-glow: rgba(247, 163, 26, 0.2);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, sans-serif;
        background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
        color: var(--text-light);
        overflow-x: hidden;
        min-height: 100vh;
    }

    /* Header Navigation - Frosted Glass Effect */
    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        background: var(--bg-glass);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--border-glass);
        padding: 1rem 0;
        transition: all 0.3s ease;
    }

    .header.scrolled {
        background: rgba(26, 26, 26, 0.25);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    }

    .nav-brand {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-color);
        text-decoration: none;
        text-shadow: 0 0 10px var(--shadow-glow);
    }

    .nav-menu {
        display: flex;
        align-items: center;
        gap: 2.5rem;
        list-style: none;
    }

    .nav-menu .nav-item a {
        color: var(--text-light);
        text-decoration: none;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-menu .nav-item a:hover {
        color: var(--primary-color);
        background: rgba(247, 163, 26, 0.1);
        backdrop-filter: blur(10px);
    }

    .nav-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .btn-outline-orange {
        background: transparent;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        padding: 0.6rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .btn-outline-orange:hover {
        background: var(--primary-color);
        color: #000;
        box-shadow: 0 0 20px var(--shadow-glow);
        transform: translateY(-2px);
    }

    /* Hero Section */
    .hero-section {
        height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        margin-top: 0;
        overflow: hidden;
        background: #0a0a0a;
    }

    .hero-section.has-video {
        background: none;
    }

    .hero-section.no-video {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.4)), 
                    url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3') center/cover;
    }

    .hero-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -2;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.6) 100%);
        z-index: -1;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(10, 10, 10, 0.8) 0%, rgba(26, 26, 26, 0.6) 100%);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        padding-left: 5%;
        max-width: 600px;
    }

    .hero-category {
        font-size: 4rem;
        font-weight: 800;
        margin-bottom: 1rem;
        background: linear-gradient(45deg, var(--primary-color), #fff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-meta {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
        color: #ccc;
    }

    .hero-description {
        font-size: 1.2rem;
        line-height: 1.6;
        margin-bottom: 3rem;
        max-width: 600px;
        color: #ddd;
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-play, .btn-trailer {
        padding: 1rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1.1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-play {
        background: var(--primary-color);
        color: #000;
        border: none;
    }

    .btn-play:hover {
        background: #e8941a;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(247, 163, 26, 0.3);
    }

    .btn-trailer {
        background: transparent;
        color: var(--text-light);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .btn-trailer:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.6);
        transform: translateY(-2px);
    }

    /* Content Sections */
    .content-section {
        padding: 0;
        background: transparent;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-light);
        margin: 0;
    }

    .section-nav {
        display: flex;
        gap: 1rem;
    }

    .nav-arrow {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: var(--text-light);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .nav-arrow:hover {
        background: var(--primary-color);
        color: #000;
        transform: scale(1.1);
    }

    /* Card Styles */
    .content-card {
        background: var(--bg-card);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
        cursor: pointer;
        position: relative;
    }

    .content-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
        border-color: var(--primary-color);
    }

    .card-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .content-card:hover .card-image {
        transform: scale(1.05);
    }

    .card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.8));
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .content-card:hover .card-overlay {
        opacity: 1;
    }

    .play-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #000;
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }

    .content-card:hover .play-icon {
        transform: scale(1);
    }

    .card-content {
        padding: 1.5rem;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-light);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .card-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: #999;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .card-description {
        color: #ccc;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .card-status {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-live {
        background: #ff4444;
        color: white;
        animation: pulse 2s infinite;
    }

    .status-upcoming {
        background: var(--primary-color);
        color: #000;
        box-shadow: 0 0 15px rgba(247, 163, 26, 0.4);
    }

    .status-scheduled {
        background: #4CAF50;
        color: white;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(255, 68, 68, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(255, 68, 68, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 68, 68, 0); }
    }

    /* Swiper Customization */
    .swiper {
        padding: 0 1rem;
    }

    .swiper-slide {
        height: auto;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: var(--primary-color);
        width: 50px;
        height: 50px;
        margin-top: -25px;
        background: rgba(0, 0, 0, 0.7);
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background: var(--primary-color);
        color: #000;
    }

    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 1.2rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-category {
            font-size: 2.5rem;
        }
        
        .hero-description {
            font-size: 1rem;
        }
        
        .hero-buttons {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .btn-play, .btn-trailer {
            width: 100%;
            justify-content: center;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div style="margin-left: -15px; margin-right: -15px;">
    <style>
        :root {
            --primary-color: #f7a31a;
            --secondary-color: #1a1a1a;
            --text-light: #ffffff;
            --text-dark: #333333;
            --bg-dark: #0a0a0a;
            --bg-card: #1a1a1a;
            --bg-glass: rgba(26, 26, 26, 0.15);
            --border-glass: rgba(255, 255, 255, 0.1);
            --shadow-glow: rgba(247, 163, 26, 0.2);
        }

        /* Hero Section */
        .hero-section {
            height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            margin-top: 0;
            overflow: hidden;
            background: #0a0a0a;
        }

        .hero-section.has-video {
            background: none;
        }

        .hero-section.no-video {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.4)), 
                        url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3') center/cover;
        }

        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.6) 100%);
            z-index: -1;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(10, 10, 10, 0.8) 0%, rgba(26, 26, 26, 0.6) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding-left: 5%;
            max-width: 600px;
        }

        .hero-category {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, var(--primary-color), #fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-meta {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            color: #ccc;
        }

        .hero-description {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 3rem;
            max-width: 600px;
            color: #ddd;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-play, .btn-trailer {
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-play {
            background: var(--primary-color);
            color: #000;
            border: none;
        }

        .btn-play:hover {
            background: #e8941a;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(247, 163, 26, 0.3);
        }

        .btn-trailer {
            background: transparent;
            color: var(--text-light);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-trailer:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateY(-2px);
        }

        /* Content Sections */
        .content-section {
            padding: 0;
            background: transparent;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-light);
            margin: 0;
        }

        .section-nav {
            display: flex;
            gap: 1rem;
        }

        .nav-arrow {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-light);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-arrow:hover {
            background: var(--primary-color);
            color: #000;
            transform: scale(1.1);
        }

        /* Card Styles */
        .content-card {
            background: var(--bg-card);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            cursor: pointer;
            position: relative;
        }

        .content-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
            border-color: var(--primary-color);
        }

        .card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .content-card:hover .card-image {
            transform: scale(1.05);
        }

        .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.8));
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content-card:hover .card-overlay {
            opacity: 1;
        }

        .play-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #000;
            transform: scale(0.8);
            transition: transform 0.3s ease;
        }

        .content-card:hover .play-icon {
            transform: scale(1);
        }

        .card-content {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .card-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #999;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .card-description {
            color: #ccc;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .card-status {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-live {
            background: #ff4444;
            color: white;
            animation: pulse 2s infinite;
        }

        .status-upcoming {
            background: var(--primary-color);
            color: #000;
            box-shadow: 0 0 15px rgba(247, 163, 26, 0.4);
        }

        .status-scheduled {
            background: #4CAF50;
            color: white;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(255, 68, 68, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(255, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 68, 68, 0); }
        }

        /* Swiper Customization */
        .swiper {
            padding: 0 1rem;
        }

        .swiper-slide {
            height: auto;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: var(--primary-color);
            width: 50px;
            height: 50px;
            margin-top: -25px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: var(--primary-color);
            color: #000;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 1.2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-category {
                font-size: 2.5rem;
            }
            
            .hero-description {
                font-size: 1rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .btn-play, .btn-trailer {
                width: 100%;
                justify-content: center;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }
    </style>
</div>
@endsection 