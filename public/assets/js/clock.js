// script.js

function updateClock() {
    // Get the current date and time
    const now = new Date();

    // Extract hours, minutes, and seconds
    const hours = String(now.getHours()).padStart(2, "0");
    const minutes = String(now.getMinutes()).padStart(2, "0");
    const seconds = String(now.getSeconds()).padStart(2, "0");

    // Combine into a time string
    const currentTime = `${hours}:${minutes}:${seconds}`;

    // Display the time
    document.getElementById("clock").textContent = currentTime;
}

// Update the clock every second
setInterval(updateClock, 1000);

// Initialize the clock immediately
updateClock();
