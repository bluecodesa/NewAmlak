$(document).ready(function () {
    $("#myTable").hide();
    document.getElementById("myInput").addEventListener("keyup", function () {
        // Get search input value
        var searchValue = this.value.toLowerCase();

        // Get table element
        var table = document.getElementById("myTable");

        // If search value is empty, hide the table and return
        if (searchValue === "") {
            table.style.display = "none";
            return;
        }

        // Loop through each row in table
        var rows = table.querySelectorAll("tr");
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];

            // Get name column text content
            var name = row.cells[1].textContent.toLowerCase();

            // Check if name contains search input value
            if (name.includes(searchValue)) {
                // Show row
                row.style.display = "";
            } else {
                // Hide row
                row.style.display = "none";
            }
        }

        // Show table if it was hidden
        if (table.style.display === "none") {
            table.style.display = "";
        }
    });

    $(function () {
        //button select all or cancel
        $("#select-all").click(function () {
            var all = $("input.select-all")[0];
            all.checked = !all.checked;
            var checked = all.checked;
            $("input.select-item").each(function (index, item) {
                item.checked = checked;
            });
        });

        //button select invert
        $("#select-invert").click(function () {
            $("input.select-item").each(function (index, item) {
                item.checked = !item.checked;
            });
            checkSelected();
        });

        //button get selected info
        $("#selected").click(function () {
            var items = [];
            $("input.select-item:checked:checked").each(function (index, item) {
                items[index] = item.value;
            });
            if (items.length < 1) {
                alert("no selected items!!!");
            } else {
                var values = items.join(",");
                console.log(values);
                var html = $("<div></div>");
                html.html("selected:" + values);
                html.appendTo("body");
            }
        });

        //column checkbox select all or cancel
        $("input.select-all").click(function () {
            var checked = this.checked;
            $("input.select-item").each(function (index, item) {
                item.checked = checked;
            });
        });

        //check selected items
        $("input.select-item").click(function () {
            var checked = this.checked;
            console.log(checked);
            checkSelected();
        });

        //check is all selected
        function checkSelected() {
            var all = $("input.select-all")[0];
            var total = $("input.select-item").length;
            var len = $("input.select-item:checked:checked").length;
            console.log("total:" + total);
            console.log("len:" + len);
            all.checked = len === total;
        }
    });
}); // اللوئح
