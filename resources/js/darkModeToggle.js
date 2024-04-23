var state = localStorage.getItem("darkMode");

if (state === null) {
    if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
        state = "true";
    } else {
        state = "false";
    }
}

if (state === "true") {
    document.body.setAttribute("data-bs-theme", "dark");
}

if (state === "false") {
    document.body.setAttribute("data-bs-theme", "light");
}

function toggleDarkMode() {
    var state = localStorage.getItem("darkMode");

    if (state === "true") {
        state = "false";
        document.body.setAttribute("data-bs-theme", "light");
    } else if (state === "false") {
        state = "true";
        document.body.setAttribute("data-bs-theme", "dark");
    } else {
        if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
            state = "false";
            document.body.setAttribute("data-bs-theme", "light");
        } else {
            state = "true";
            document.body.setAttribute("data-bs-theme", "dark");
        }
    }

    localStorage.setItem("darkMode", state);
}

document
    .getElementById("darkModeToggle")
    .addEventListener("click", toggleDarkMode);
