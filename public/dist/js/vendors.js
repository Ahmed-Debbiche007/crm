// Simple Datatable
let table1 = document.querySelectorAll(".table");
function tables() {
    $(".table").each(function () {
        var buttonCommon = {
            exportOptions: {
                format: {
                    body: function (data, row, column, node) {
                        console.log(column);
                        console.log(node);
                        console.log(data);

                        var containsHTML = /<\/?[a-z][\s\S]*>/i.test(data);
                        console.log($(node).hasClass("expot-data"));

                        return containsHTML ? "" : data;
                    },
                },
            },
        };
        const jquery_datatable = $(this);
        jquery_datatable.DataTable({
            order: [],
            responsive: true,
            dom: "Bfrtip",
            lengthMenu: [10, 25, 50, 75, 100],
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
            rowsGroup: [0, 1]
        });

        const setTableColor = () => {
            jquery_datatable
                .find(".dataTables_paginate .pagination")
                .addClass("pagination-primary");
        };

        setTableColor();
        jquery_datatable.on("draw.dt", setTableColor);
    });
}

tables();
