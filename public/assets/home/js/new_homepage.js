let player;
let lastPlaybackTime = 0;

// === YOUTUBE IFRAME API INIT ===
function onYouTubeIframeAPIReady() {
    const iframe = document.getElementById("yt-hero-video");
    if (!iframe) return;

    if (!player) {
        player = new YT.Player("yt-hero-video", {
            events: {
                onReady: onPlayerReady,
                onError: onPlayerError,
            },
        });
    }
}

function onPlayerReady(event) {
    try {
        event.target.playVideo();
    } catch (e) {
        console.warn("Autoplay failed:", e);
    }

    document.addEventListener("visibilitychange", () => {
        if (!player) return;

        try {
            if (document.visibilityState === "visible") {
                if (player.getPlayerState() !== YT.PlayerState.PLAYING) {
                    player.playVideo();
                }
            } else if (player.getPlayerState() === YT.PlayerState.PLAYING) {
                player.pauseVideo();
            }
        } catch (e) {
            console.warn("YouTube playback control error:", e);
        }
    });
}

function onPlayerError(event) {
    console.error("YouTube Player Error:", event.data);
    fallbackToDefaultBanner();
}

function fallbackToDefaultBanner() {
    const heroSection = document.querySelector(".hero-section");
    const heroVideo = document.querySelector(".hero-video");

    if (heroVideo) heroVideo.style.display = "none";

    if (heroSection) {
        heroSection.style.background = `linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.7)), url('/storage/fitlive/banners/default-banner.jpg') center/cover no-repeat`;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const sliders = document.querySelectorAll(".content-slider");

    sliders.forEach((container) => {
        const slider = container.querySelector(".slider-container");
        const prevBtn = container.querySelector(".slider-prev");
        const nextBtn = container.querySelector(".slider-next");

        if (!slider || !prevBtn || !nextBtn) return; // Exit if any elements are missing

        // 👇 Click Handlers
        prevBtn.addEventListener("click", () =>
            scrollSlider("prev", container)
        );
        nextBtn.addEventListener("click", () =>
            scrollSlider("next", container)
        );

        // 👇 Scroll Event to update arrow visibility
        slider.addEventListener("scroll", () =>
            updateSliderControls(container)
        );

        // 👇 Initial Setup
        updateSliderControls(container);
    });

    // 👇 On Resize, re-evaluate visibility
    window.addEventListener("resize", () => {
        document
            .querySelectorAll(".content-slider")
            .forEach(updateSliderControls);
    });
});

// 🔄 Scroll logic
function scrollSlider(direction, container) {
    const slider = container.querySelector(".slider-container");
    const card = slider.querySelector(".content-card");

    if (!card) return;

    const scrollAmount = card.offsetWidth + 10; // Adjust if your gap is different

    if (direction === "next") {
        slider.scrollBy({ left: scrollAmount, behavior: "smooth" });
    } else {
        slider.scrollBy({ left: -scrollAmount, behavior: "smooth" });
    }

    // ⏱ Update arrows after scroll completes
    setTimeout(() => updateSliderControls(container), 400);
}

// 🔍 Show/hide arrows dynamically
function updateSliderControls(container) {
    const slider = container.querySelector(".slider-container");
    const prevBtn = container.querySelector(".slider-prev");
    const nextBtn = container.querySelector(".slider-next");

    if (!slider || !prevBtn || !nextBtn) return;

    const scrollLeft = Math.ceil(slider.scrollLeft);
    const maxScrollLeft = Math.floor(slider.scrollWidth - slider.clientWidth);

    // 👇 Only show arrows on desktop
    if (window.innerWidth < 769) {
        prevBtn.style.display = "none";
        nextBtn.style.display = "none";
        return;
    }

    // 👇 Left arrow: only show if not at the beginning
    prevBtn.style.display = scrollLeft > 0 ? "flex" : "none";

    // 👇 Right arrow: only show if not at the end
    nextBtn.style.display = scrollLeft < maxScrollLeft - 5 ? "flex" : "none"; // -5 for buffer
}

// === DOM READY ===
document.addEventListener("DOMContentLoaded", () => {
    const heroVideo = document.querySelector(".hero-video");

    if (heroVideo) {
        if (heroVideo.tagName === "IFRAME") {
            heroVideo.addEventListener("error", fallbackToDefaultBanner);
        } else if (heroVideo.tagName === "VIDEO") {
            heroVideo.addEventListener("loadedmetadata", async () => {
                try {
                    await heroVideo.play();
                } catch (error) {
                    console.warn("Video autoplay failed:", error);
                }
            });

            heroVideo.addEventListener("error", fallbackToDefaultBanner);

            if (window.innerWidth <= 768) {
                heroVideo.setAttribute("playsinline", "");
                heroVideo.setAttribute("webkit-playsinline", "");
            }
        }
    }

    // === SLIDER SETTINGS ===
    const SLIDER_SETTINGS = {
        cardWidth: () => {
            const isMobile = window.innerWidth <= 768;
            return isMobile ? (window.innerWidth <= 480 ? 168 : 212) : 296;
        },
        visibleCards: () => (window.innerWidth <= 768 ? 3 : 5),
    };

    // === SLIDE FUNCTION ===
    window.slideContent = function (sliderId, direction) {
        const slider = document.getElementById(sliderId);
        if (!slider) return;

        const cardWidth = SLIDER_SETTINGS.cardWidth();
        const visible = SLIDER_SETTINGS.visibleCards();
        const totalCards = slider.children.length;

        const currentTransform = slider.style.transform || "translateX(0px)";
        const currentX = parseInt(currentTransform.match(/-?\d+/)?.[0] || 0);

        const maxSlide = -Math.max(0, totalCards - visible) * cardWidth;
        let newX = currentX + direction * cardWidth;
        newX = Math.max(maxSlide, Math.min(0, newX));

        slider.style.transform = `translateX(${newX}px)`;
        updateSliderControls(sliderId, newX, maxSlide);
    };

    function updateSliderControls(sliderId, currentX = null, maxSlide = null) {
        const slider = document.getElementById(sliderId);
        if (!slider) return;

        const parent = slider.closest(".content-slider");
        const prevBtn = parent.querySelector(".slider-prev");
        const nextBtn = parent.querySelector(".slider-next");

        if (currentX === null) {
            const transform = slider.style.transform || "translateX(0px)";
            currentX = parseInt(transform.match(/-?\d+/)?.[0] || 0);
        }

        if (maxSlide === null) {
            const totalCards = slider.children.length;
            const visible = SLIDER_SETTINGS.visibleCards();
            const cardWidth = SLIDER_SETTINGS.cardWidth();
            maxSlide = -Math.max(0, totalCards - visible) * cardWidth;
        }

        // Only show controls if overflow exists (PC only)
        if (window.innerWidth > 768) {
            const totalCards = slider.children.length;
            const visible = SLIDER_SETTINGS.visibleCards();
            if (totalCards > visible) {
                prevBtn.style.display = "flex";
                nextBtn.style.display = "flex";
            } else {
                prevBtn.style.display = "none";
                nextBtn.style.display = "none";
            }
        }

        prevBtn.disabled = currentX >= 0;
        nextBtn.disabled = currentX <= maxSlide;
    }

    // === TOUCH SUPPORT ===
    let touchStartX = 0,
        touchEndX = 0,
        currentSlider = null;

    document.querySelectorAll(".slider-container").forEach((slider) => {
        slider.addEventListener("touchstart", (e) => {
            touchStartX = e.changedTouches[0].screenX;
            currentSlider = slider;
        });

        slider.addEventListener("touchend", (e) => {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) {
                slideContent(currentSlider.id, diff > 0 ? 1 : -1);
            }
            currentSlider = null;
        });
    });

    // === AUTO SCROLL ===
    let autoScrollIntervals = [];

    function startAutoScroll() {
        document.querySelectorAll(".slider-container").forEach((slider, i) => {
            if (!slider.id) return;
            const interval = setInterval(() => {
                if (!document.hidden) slideContent(slider.id, 1);
            }, 5000 + i * 1000);
            autoScrollIntervals.push(interval);
        });
    }

    function stopAutoScroll() {
        autoScrollIntervals.forEach(clearInterval);
        autoScrollIntervals = [];
    }

    document.querySelectorAll(".content-slider").forEach((slider) => {
        slider.addEventListener("mouseenter", stopAutoScroll);
        slider.addEventListener("mouseleave", () => {
            if (window.innerWidth > 768) startAutoScroll();
        });
    });

    function initSliders() {
        document.querySelectorAll(".slider-container").forEach((slider) => {
            updateSliderControls(slider.id);
            slider.style.transform = "translateX(0px)";
        });
    }

    window.addEventListener("resize", () => {
        initSliders();
        stopAutoScroll();
        if (window.innerWidth > 768) startAutoScroll();
    });

    initSliders();
    if (window.innerWidth > 768) startAutoScroll();

    // === CARD CLICK SUPPORT ===
    document.querySelectorAll(".content-card").forEach((card) => {
        card.addEventListener("click", function () {
            const href = this.getAttribute("onclick");
            if (href?.includes("window.location.href")) {
                const match = href.match(/window\.location\.href='([^']+)'/);
                if (match?.[1] && match[1] !== "#") {
                    window.location.href = match[1];
                }
            }
        });
    });

    // === HERO VIDEO CONTROL ON TAB CHANGE ===
    document.addEventListener("visibilitychange", () => {
        const heroVideo = document.querySelector(".hero-video");
        if (!heroVideo) return;

        if (document.hidden) {
            stopAutoScroll();
            if (
                heroVideo.tagName === "IFRAME" &&
                typeof player !== "undefined"
            ) {
                try {
                    player.getCurrentTime().then((time) => {
                        lastPlaybackTime = time;
                        player.pauseVideo();
                    });
                } catch (e) {
                    console.warn("Failed to pause YouTube:", e);
                }
            } else if (heroVideo.tagName === "VIDEO") {
                lastPlaybackTime = heroVideo.currentTime;
                heroVideo.pause();
            }
        } else {
            if (window.innerWidth > 768) startAutoScroll();
            if (
                heroVideo.tagName === "IFRAME" &&
                typeof player !== "undefined"
            ) {
                try {
                    player.seekTo(lastPlaybackTime, true);
                    player.playVideo();
                } catch (e) {
                    console.warn("Failed to resume YouTube:", e);
                }
            } else if (heroVideo.tagName === "VIDEO") {
                heroVideo.currentTime = lastPlaybackTime;
                heroVideo.play();
            }
        }
    });
});
