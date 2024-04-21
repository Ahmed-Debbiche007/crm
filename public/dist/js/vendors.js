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
          
            responsive: {
                details: {
                    renderer: DataTable.Responsive.renderer.listHiddenNodes(),
                },
            },
            dom: "lBfrtip", // 'l' for length menu, 'B' for buttons
            lengthMenu: [
                [10, 25, 50, 75, 100], // Available options
                [10, 25, 50, 75, 100], // Labels
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
            ]
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
