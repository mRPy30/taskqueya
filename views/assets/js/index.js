/**Toggle**/
function toggleMenu() {
    document.getElementById('authMenu').classList.toggle('show');
}

/**Calendar Dynamic**/
document.addEventListener("DOMContentLoaded", function () {
    const now = new Date();

    const day = String(now.getDate()).padStart(2, '0');
    const monthNames = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN",
                        "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
    const month = monthNames[now.getMonth()];
    const year = now.getFullYear();

    document.getElementById("calendar-day").textContent = day;
    document.getElementById("calendar-month").textContent = month;
    document.getElementById("calendar-year").textContent = year;
});