const sun = `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
stroke-linecap="round" stroke-linejoin="round">
<path stroke="none" d="M0 0h24v24H0z" fill="none" />
<path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
<path
    d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
</svg>`;

const moon = `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
stroke-linecap="round" stroke-linejoin="round">
<path stroke="none" d="M0 0h24v24H0z" fill="none" />
<path
    d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
</svg>`;

const toggle = document.getElementById("theme-toggle");

const body = document.getElementsByTagName("body")[0];
const currentTheme = localStorage.getItem("theme");
if (currentTheme === "dark") {
    if (toggle) {
        toggle.innerHTML = sun;
    }
    localStorage.setItem("theme", "dark");
    body.setAttribute("data-bs-theme", "dark");
} else {
    if (toggle) {
        toggle.innerHTML = moon;
    }
    localStorage.setItem("theme", "light");
    body.setAttribute("data-bs-theme", "");
}
if (toggle) {
    toggle.addEventListener("click", function () {
        const currentTheme = localStorage.getItem("theme");
        if (currentTheme === "dark") {
            if (toggle) {
                toggle.innerHTML = moon;
            }
            localStorage.setItem("theme", "light");
            body.setAttribute("data-bs-theme", "");
        } else {
            if (toggle) {
                toggle.innerHTML = sun;
            }
            localStorage.setItem("theme", "dark");
            body.setAttribute("data-bs-theme", "dark");
        }
    });
}

const show = document.getElementById("show");
if(show){
    show.addEventListener("click", () => {
        const pass = document.getElementById("pass");
        if (pass.type === "password") {
            pass.type = "text";
        } else {
            pass.type = "password";
        }
    });
}
