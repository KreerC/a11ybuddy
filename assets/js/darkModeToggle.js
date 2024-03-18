var selectedColorMode = localStorage.getItem("colorMode");

if (selectedColorMode === null) {
  if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
    localStorage.setItem("colorMode", "dark");
    selectedColorMode = "dark";
  } else {
    localStorage.setItem("colorMode", "light");
    selectedColorMode = "light";
  }
}

document.documentElement.setAttribute("data-bs-theme", selectedColorMode);

function toggleDarkMode() {
  var newColorMode = selectedColorMode === "light" ? "dark" : "light";
  selectedColorMode = newColorMode;
  localStorage.setItem("colorMode", newColorMode);
  document.documentElement.setAttribute("data-bs-theme", newColorMode);
}
