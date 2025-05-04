/**
 * Theme Toggle Functionality
 * Handles switching between light and dark themes
 */
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('themeToggle');
    const lightIcon = document.getElementById('lightIcon');
    const darkIcon = document.getElementById('darkIcon');
    const htmlElement = document.documentElement;
    
    // Check for saved theme preference or use preferred color scheme
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    // Set initial theme
    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        htmlElement.setAttribute('data-bs-theme', 'dark');
        lightIcon.classList.add('d-none');
        darkIcon.classList.remove('d-none');
    } else {
        htmlElement.setAttribute('data-bs-theme', 'light');
        lightIcon.classList.remove('d-none');
        darkIcon.classList.add('d-none');
    }
    
    // Toggle theme on button click
    themeToggle.addEventListener('click', function() {
        const currentTheme = htmlElement.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        htmlElement.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        
        // Toggle icons
        lightIcon.classList.toggle('d-none');
        darkIcon.classList.toggle('d-none');
        
        // Add animation effect
        document.body.style.transition = 'background-color 0.3s ease, color 0.3s ease';
    });
});