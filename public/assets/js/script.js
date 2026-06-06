/*
 * ================================================================
 *  WATERMARK / LICENSE NOTICE
 *  Email   : andi.upn@gmail.com
 *  Website : kuncimu.com
 *  Info    : This source code is created and only sold officially on the mentioned website
 *            or official online store on the mentioned website.
 *            Support development by purchasing from the original store. Thank you.
 * ================================================================
 */

/**
 * SCRIPT.JS - Simple JavaScript for CRUD Simple
 *
 * Super simple JavaScript for beginners
 * Only basic functions needed
 */

// Minimal JavaScript to support basic CRUD experience
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.focus();
        return;
    }

    const nameInput = document.querySelector('input[name="name"]');
    if (nameInput) {
        nameInput.focus();
    }
});
