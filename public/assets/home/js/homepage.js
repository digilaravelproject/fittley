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

// Debounce utility to prevent rapid clicks firing multiple scrolls
function debounce(func, delay) {
    let timer;
    return function (...args) {
        if (timer) clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
}

document.addEventListener("DOMContentLoaded", () => {
    // Setup hero video fallback and mobile inline video settings
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

    // Initialize sliders and arrows
    document.querySelectorAll(".content-slider").forEach((container) => {
        const slider = container.querySelector(".slider-container");
        const prevBtn = container.querySelector(".slider-prev");
        const nextBtn = container.querySelector(".slider-next");

        if (!slider || !prevBtn || !nextBtn) return;

        // Debounced click handlers for arrows
        const debouncedPrev = debounce(
            () => scrollSlider("prev", container),
            150
        );
        const debouncedNext = debounce(
            () => scrollSlider("next", container),
            150
        );

        prevBtn.addEventListener("click", debouncedPrev);
        nextBtn.addEventListener("click", debouncedNext);

        // Update arrows on manual scroll (e.g., touch scroll)
        slider.addEventListener("scroll", () =>
            updateSliderControls(container)
        );

        // Initial arrow visibility
        updateSliderControls(container);
    });

    // Update arrows on window resize
    window.addEventListener("resize", () => {
        document
            .querySelectorAll(".content-slider")
            .forEach(updateSliderControls);
    });
});

// Scroll the slider container left/right
function scrollSlider(direction, container) {
    const slider = container.querySelector(".slider-container");
    if (!slider) return;

    // Calculate scroll amount dynamically — scroll ~80% visible width or min 100px for small containers
    const visibleWidth = slider.clientWidth;
    const scrollAmount = Math.max(visibleWidth * 0.8, 100);

    // Scroll left or right smoothly
    slider.scrollBy({
        left: direction === "next" ? scrollAmount : -scrollAmount,
        behavior: "smooth",
    });

    // Update arrows after smooth scroll settles (adjust delay if needed)
    setTimeout(() => updateSliderControls(container), 350);
}

// Show/hide arrows based on scroll position & only on desktop
function updateSliderControls(container) {
    const slider = container.querySelector(".slider-container");
    const prevBtn = container.querySelector(".slider-prev");
    const nextBtn = container.querySelector(".slider-next");

    if (!slider || !prevBtn || !nextBtn) return;

    // Hide arrows on mobile
    if (window.innerWidth < 769) {
        prevBtn.style.display = "none";
        nextBtn.style.display = "none";
        return;
    }

    // Use Math.ceil/floor to avoid fractional errors
    const scrollLeft = Math.ceil(slider.scrollLeft);
    const maxScrollLeft = Math.floor(slider.scrollWidth - slider.clientWidth);

    // Show prev if scrolled right from start
    prevBtn.style.display = scrollLeft > 0 ? "flex" : "none";

    // Show next if not at end (allow a small 5px buffer for floating point)
    nextBtn.style.display = scrollLeft < maxScrollLeft - 5 ? "flex" : "none";
}
