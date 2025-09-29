import './bootstrap';

// Global Video Protection
document.addEventListener('DOMContentLoaded', function() {
    // Disable right-click context menu on all videos
    const videos = document.querySelectorAll('video');
    videos.forEach(video => {
        video.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });
        
        video.addEventListener('dragstart', function(e) {
            e.preventDefault();
            return false;
        });
        
        video.addEventListener('selectstart', function(e) {
            e.preventDefault();
            return false;
        });
    });
    
    // Disable keyboard shortcuts that could be used to download
    document.addEventListener('keydown', function(e) {
        // Disable Ctrl+S (Save)
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            return false;
        }
        
        // Disable F12 (Developer Tools) - Note: This can be bypassed but adds a layer
        if (e.key === 'F12') {
            e.preventDefault();
            return false;
        }
        
        // Disable Ctrl+Shift+I (Developer Tools)
        if (e.ctrlKey && e.shiftKey && e.key === 'I') {
            e.preventDefault();
            return false;
        }
        
        // Disable Ctrl+U (View Source)
        if (e.ctrlKey && e.key === 'u') {
            e.preventDefault();
            return false;
        }
    });
    
    // Disable right-click on the entire page when video is playing
    let videoPlaying = false;
    videos.forEach(video => {
        video.addEventListener('play', function() {
            videoPlaying = true;
        });
        
        video.addEventListener('pause', function() {
            videoPlaying = false;
        });
        
        video.addEventListener('ended', function() {
            videoPlaying = false;
        });
    });
    
    document.addEventListener('contextmenu', function(e) {
        if (videoPlaying) {
            e.preventDefault();
            return false;
        }
    });
});
