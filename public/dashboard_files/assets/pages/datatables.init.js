/*
 Template Name: Stexo - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesdesign
 Website: www.themesdesign.in
 File: Datatable js
 */

$(document).ready(function () {
    // Basic DataTable with buttons
    $("#datatable").DataTable();

    // DataTable with buttons and filter inputs
    $("#datatable-buttons thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#datatable-buttons thead");

    var table = $("#datatable-buttons").DataTable({
        lengthChange: true,
        buttons: ["excel", "pdf"],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();

            // For each column
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );

                    // Check if it's not the first or last column
                    if (
                        colIdx !== 0 &&
                        colIdx !== api.columns()[0].length - 1
                    ) {
                        var title = $(cell).text();
                        $(cell).html(
                            '<input type="text" placeholder="' + title + '" />'
                        );

                        // On every keypress in this input
                        $(
                            "input",
                            $(".filters th").eq(
                                $(api.column(colIdx).header()).index()
                            )
                        )
                            .prop("disabled", false) // Enable input
                            .off("keyup change")
                            .on("change", function (e) {
                                // Get the search value
                                $(this).attr("title", $(this).val());
                                var regexr = "({search})"; //$(this).parents('th').find('select').val();

                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api.column(colIdx)
                                    .search(
                                        this.value != ""
                                            ? regexr.replace(
                                                  "{search}",
                                                  "(((" + this.value + ")))"
                                              )
                                            : "",
                                        this.value != "",
                                        this.value == ""
                                    )
                                    .draw();
                            })
                            .on("keyup", function (e) {
                                e.stopPropagation();

                                $(this).trigger("change");
                                $(this)
                                    .focus()[0]
                                    .setSelectionRange(
                                        cursorPosition,
                                        cursorPosition
                                    );
                            });
                    } else {
                        // Disable inputs for the first and last columns
                        $(cell).html('<input type="text" disabled />');
                    }
                });
        },
    });

    // Move buttons container to desired position
    table
        .buttons()
        .container()
        .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
});

$(document).ready(function () {
    $("#datatable2").DataTable({
        ordering: false,
        pageLength: 500,
    });
});
