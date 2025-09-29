let player;

function onYouTubeIframeAPIReady() {
    const iframeExists = document.getElementById("yt-hero-video");
    if (!iframeExists) return;

    player = new YT.Player("yt-hero-video", {
        events: {
            onReady: onPlayerReady,
        },
    });
}

function onPlayerReady(event) {
    // Play on load
    event.target.playVideo();

    // Resume video when user comes back to the tab
    document.addEventListener("visibilitychange", function () {
        if (document.visibilityState === "visible") {
            player.playVideo();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    // Hero video handling (YouTube iframe or HTML5 video)
    const heroVideo = document.querySelector(".hero-video");
    if (heroVideo) {
        if (heroVideo.tagName === "IFRAME") {
            // YouTube iframe handling
            console.log("YouTube hero video loaded");

            // Handle iframe errors
            heroVideo.addEventListener("error", function (e) {
                console.error("Hero YouTube video error:", e);
                // Hide iframe and show fallback background
                heroVideo.style.display = "none";
                document.querySelector(".hero-section").style.background =
                    'linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.7)), url("https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D") center/cover';
            });
        } else {
            // HTML5 video handling
            heroVideo.addEventListener("loadedmetadata", function () {
                // Try to play the video
                const playPromise = heroVideo.play();

                if (playPromise !== undefined) {
                    playPromise
                        .then(() => {
                            console.log("Hero video autoplay started");
                        })
                        .catch((error) => {
                            console.log("Hero video autoplay failed:", error);
                            // Fallback: show poster image or handle gracefully
                        });
                }
            });

            // Handle video errors
            heroVideo.addEventListener("error", function (e) {
                console.error("Hero video error:", e);
                // Hide video and show fallback background
                heroVideo.style.display = "none";
                document.querySelector(".hero-section").style.background =
                    'linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.7)), url("https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D") center/cover';
            });

            // Optimize for mobile
            if (window.innerWidth <= 768) {
                heroVideo.setAttribute("playsinline", "");
                heroVideo.setAttribute("webkit-playsinline", "");
            }
        }
    }

    // Slider functionality
    window.slideContent = function (sliderId, direction) {
        const slider = document.getElementById(sliderId);
        if (!slider) return;

        const isMobile = window.innerWidth <= 768;
        const cardWidth = isMobile
            ? window.innerWidth <= 480
                ? 160 + 8
                : 200 + 12
            : 280 + 16; // card width + gap
        const cardsToMove = isMobile ? 1 : 1; // Move one card at a time

        const currentTransform = slider.style.transform || "translateX(0px)";
        const currentX = parseInt(currentTransform.match(/-?\d+/)?.[0] || 0);

        const visibleCards = isMobile ? (window.innerWidth <= 480 ? 3 : 3) : 5; // 3 cards mobile, 5 desktop
        const maxSlide =
            -Math.max(0, slider.children.length - visibleCards) * cardWidth;

        let newX = currentX + direction * cardWidth * cardsToMove;

        if (newX > 0) newX = 0;
        if (newX < maxSlide) newX = maxSlide;

        slider.style.transform = `translateX(${newX}px)`;
    };

    // Touch support for mobile sliders
    let touchStartX = 0;
    let touchEndX = 0;
    let currentSlider = null;

    document.querySelectorAll(".content-slider").forEach((slider) => {
        const sliderContainer = slider.querySelector(".slider-container");

        if (sliderContainer) {
            sliderContainer.addEventListener("touchstart", function (e) {
                touchStartX = e.changedTouches[0].screenX;
                currentSlider = this;
            });

            sliderContainer.addEventListener("touchend", function (e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });
        }
    });

    function handleSwipe() {
        if (!currentSlider) return;

        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            const sliderId = currentSlider.id;
            if (diff > 0) {
                // Swipe left - next
                slideContent(sliderId, 1);
            } else {
                // Swipe right - previous
                slideContent(sliderId, -1);
            }
        }

        currentSlider = null;
    }

    // Card click functionality
    document.querySelectorAll(".content-card").forEach((card) => {
        card.addEventListener("click", function () {
            const href = this.getAttribute("onclick");
            if (href && href.includes("window.location.href")) {
                const url = href.match(/window\.location\.href='([^']+)'/);
                if (url && url[1] && url[1] !== "#") {
                    window.location.href = url[1];
                }
            }
        });
    });

    // Responsive slider controls
    function handleSliderControls() {
        const controls = document.querySelectorAll(".slider-controls");
        // Always show controls now, but make them smaller on mobile
        controls.forEach((control) => {
            control.style.display = "flex";
        });
    }

    window.addEventListener("resize", handleSliderControls);
    handleSliderControls();

    // Auto-scroll functionality (optional)
    let autoScrollIntervals = [];

    function startAutoScroll() {
        const sliders = document.querySelectorAll(".slider-container");
        sliders.forEach((slider, index) => {
            if (slider.id) {
                const interval = setInterval(() => {
                    if (!document.hidden) {
                        // Only auto-scroll if page is visible
                        slideContent(slider.id, 1);
                    }
                }, 5000 + index * 1000); // Stagger auto-scroll timing

                autoScrollIntervals.push(interval);
            }
        });
    }

    function stopAutoScroll() {
        autoScrollIntervals.forEach((interval) => clearInterval(interval));
        autoScrollIntervals = [];
    }

    // Start auto-scroll on desktop only
    if (window.innerWidth > 768) {
        startAutoScroll();
    }

    // Pause auto-scroll on hover
    document.querySelectorAll(".content-slider").forEach((slider) => {
        slider.addEventListener("mouseenter", stopAutoScroll);
        slider.addEventListener("mouseleave", () => {
            if (window.innerWidth > 768) {
                startAutoScroll();
            }
        });
    });

    let lastPlaybackTime = 0;

    document.addEventListener("visibilitychange", function () {
        if (!heroVideo) return;

        if (document.hidden) {
            stopAutoScroll();

            if (
                heroVideo.tagName === "IFRAME" &&
                typeof player !== "undefined"
            ) {
                try {
                    player.getCurrentTime &&
                        player.getCurrentTime().then((time) => {
                            lastPlaybackTime = time;
                            player.pauseVideo();
                        });
                } catch (e) {
                    console.warn("Could not get video time:", e);
                }
            } else if (heroVideo.tagName === "VIDEO") {
                lastPlaybackTime = heroVideo.currentTime;
                heroVideo.pause();
            }
        } else {
            if (window.innerWidth > 768) {
                startAutoScroll();
            }

            if (
                heroVideo.tagName === "IFRAME" &&
                typeof player !== "undefined"
            ) {
                try {
                    player.seekTo(lastPlaybackTime, true);
                    player.playVideo();
                } catch (e) {
                    console.warn("Could not seek video:", e);
                }
            } else if (heroVideo.tagName === "VIDEO") {
                heroVideo.currentTime = lastPlaybackTime;
                heroVideo.play();
            }
        }
    });
});
