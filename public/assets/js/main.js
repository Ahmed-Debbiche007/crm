(() => {
    for (
        var e = document.querySelectorAll(".sidebar-item.has-sub"),
            t = function () {
                var t = e[r];
                e[r]
                    .querySelector(".sidebar-link")
                    .addEventListener("click", function (e) {
                        e.preventDefault();
                        var r = t.querySelector(".submenu");
                        r.classList.contains("active")
                            ? r.classList.remove("active")
                            : r.classList.add("active");
                    });
            },
            r = 0;
        r < e.length;
        r++
    )
        t();
    var a = document.querySelectorAll(".sidebar-toggler");
    for (r = 0; r < a.length; r++) {
        a[r].addEventListener("click", function () {
            var e = document.getElementById("sidebar");
            e.classList.contains("active")
                ? e.classList.remove("active")
                : e.classList.add("active");
        });
    }
    if ("function" == typeof PerfectScrollbar) {
        var c = document.querySelector(".sidebar-wrapper");
        new PerfectScrollbar(c);
    }
    (window.onload = function () {
        var e = window.innerWidth;
        e < 768 &&
            (console.log("widthnya ", e),
            document.getElementById("sidebar").classList.remove("active"));
    }),
        feather.replace();
})();


