let table1 = document.querySelectorAll(".table");

function tables() {
    $(".table").each(function () {
        const jquery_datatable = $(this);
        jquery_datatable.DataTable({
            responsive: {
                details: {
                    renderer: DataTable.Responsive.renderer.listHiddenNodes(),
                },
            },
            dom: "lBfrtip", // 'l' for length menu, 'B' for buttons
            lengthMenu: [
                [-1, 10, 25, 50, 75, 100], // Available options
                ["Tous", 10, 25, 50, 75, 100], // Labels
            ],
            buttons: [
                {
                    extend: "excel",
                    text: "Exporter Excel",
                    className: "btn btn-success",
                    exportOptions: {
                        columns: "thead th:not(.noExport)",
                    },
                },
            ],
            initComplete: function () {
                let table = this.api();

                table.columns().every(function () {
                    let column = this;
                    if (column.header().id === "summable") {
                        let sum = table
                            .column(column.index(), {
                                page: "current",
                                search: "applied",
                            })
                            .data()
                            .reduce(function (a, b) {
                                // Remove spaces and then parse
                                let num = parseFloat(b.replace(/\s/g, ""));
                                return a + (isNaN(num) ? 0 : num); // Check if num is NaN and handle accordingly
                            }, 0);

                        $(column.footer()).html(
                            sum
                                .toLocaleString("en-US", {
                                    minimumFractionDigits: 3,
                                    maximumFractionDigits: 3,
                                })
                                .replace(/,/g, " ")
                        );
                        $(column.footer()).style =
                            "color: red; background-color: white; font-weight: bold;";

                        table.on("draw", function () {
                            let sum = table
                                .column(column.index(), {
                                    page: "current",
                                    search: "applied",
                                })
                                .data()
                                .reduce(function (a, b) {
                                    // Remove spaces and then parse
                                    let num = parseFloat(b.replace(/\s/g, ""));
                                    return a + (isNaN(num) ? 0 : num); // Check if num is NaN and handle accordingly
                                }, 0);

                            $(column.footer()).html(
                                sum
                                    .toLocaleString("en-US", {
                                        minimumFractionDigits: 3,
                                        maximumFractionDigits: 3,
                                    })
                                    .replace(/,/g, " ")
                            );
                        });
                    }
                });
            },
        });

        const setTableColor = () => {
            jquery_datatable
                .find(".dataTables_paginate .pagination")
                .addClass("pagination-primary");
        };

        setTableColor();
        jquery_datatable.on("draw.dt", setTableColor);
        var columnIndex = jquery_datatable.find("#appartOrder").index();
        jquery_datatable.DataTable().order([columnIndex, "asc"]).draw();
    });
}

tables();

function formatPhoneNumber(phoneNumber) {
    // Remove any spaces from the phone number
    var cleanNumber = phoneNumber.replace(/\s/g, "");

    // Check if the phone number has any characters other than numbers and +
    var regex = /[^0-9+]/g;
    var nonNumericChars = cleanNumber.match(regex);

    if (nonNumericChars) {
        // Split the phone number into an array based on non-numeric characters
        var numberArray = cleanNumber.split(regex);
        // Format each part of the number individually
        var formattedNumberArray = numberArray.map(function (part) {
            // Check if the part starts with +216
            if (part.startsWith("216")) {
                return (
                    "+216 " +
                    part.substr(3).replace(/(\d{2})(\d{3})(\d{3})/, "$1 $2 $3")
                );
            } else if (part.length === 8) {
                return part.replace(/(\d{2})(\d{3})(\d{3})/, "$1 $2 $3");
            } else {
                return (
                    part.substr(0, 2) +
                    " " +
                    part.substr(2).replace(/(\d{3})(?=\d)/g, "$1 ")
                );
            }
        });
        // Join the formatted parts back together with the non-numeric characters
        return formattedNumberArray
            .map(function (part, index) {
                return part + " " + (nonNumericChars[index] || "") + " "; // Append the non-numeric character or an empty string if there's no character
            })
            .join(" ");
    } else {
        // Otherwise, format the phone number as before
        if (cleanNumber.startsWith("216")) {
            return (
                "+216 " +
                cleanNumber
                    .substr(3)
                    .replace(/(\d{2})(\d{3})(\d{3})/, "$1 $2 $3")
            );
        } else if (cleanNumber.length === 8) {
            return cleanNumber.replace(/(\d{2})(\d{3})(\d{3})/, "$1 $2 $3");
        } else {
            return (
                cleanNumber.substr(0, 2) +
                " " +
                cleanNumber.substr(2).replace(/(\d{3})(?=\d)/g, "$1 ")
            );
        }
    }
}

$(document).ready(function () {
    $(".phoneNumber").each(function () {
        var phoneNumber = $(this).text();
        var formattedNumber = formatPhoneNumber(phoneNumber);
        $(this).text(formattedNumber);
    });
});
