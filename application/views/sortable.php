<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jQuery Sortable Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c2c2c;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            text-align: left;
            background-color: #3c3c3c;
            border-radius: 8px;
        }

        table thead {
            background-color: #4d4d4d;
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #555;
        }

        table th {
            cursor: pointer;
        }

        table tr:hover {
            background-color: #555;
        }

        .search-box {
            margin-bottom: 20px;
        }

        input[type="text"]:focus {
            border-color: blue !important;
            box-shadow: 0 0 5px rgba(0, 0, 255, 0.5) !important;
            /* Optional for a blue glow effect */
            outline: none;
            /* Removes the default outline */
        }
    </style>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="search-box">
        <label for="searchInput">Search:</label>
        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names..">
    </div>

    <table id="sortableTable">
        <thead>
            <tr>
                <th data-type="text">ID</th>
                <th data-type="text">Name</th>
                <th data-type="text">Standard</th>
                <th data-type="number">Percentage</th>
                <th data-type="date">Result</th>
                <th data-type="number">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($posts)) {
                foreach ($posts as $value) { ?>

                    <tr>
                        <td><?= $value->id; ?></td>
                        <td><?= $value->name; ?></td>
                        <td><?= $value->standard; ?></td>
                        <td><?= $value->percentage; ?></td>
                        <td><?= $value->result; ?></td>
                        <td><?= $value->created_at; ?></td>
                    </tr>

            <?php }
            }
            ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            // jQuery sorting function
            $('th').on('click', function() {
                var column = $(this).index(); // Get column index
                var table = $('#sortableTable');
                var rows = table.find('tbody tr').toArray();
                var type = $(this).data('type'); // Get data type for sorting (text, number, date)
                var direction = $(this).data('direction') || 'asc'; // Get sorting direction

                rows.sort(function(a, b) {
                    var cellA = $(a).find('td').eq(column).text();
                    var cellB = $(b).find('td').eq(column).text();

                    if (type === 'number') {
                        cellA = parseFloat(cellA.replace(/[^0-9.-]+/g, "")) || 0;
                        cellB = parseFloat(cellB.replace(/[^0-9.-]+/g, "")) || 0;
                    } else if (type === 'date') {
                        cellA = new Date(cellA);
                        cellB = new Date(cellB);
                    } else {
                        cellA = cellA.toLowerCase();
                        cellB = cellB.toLowerCase();
                    }

                    if (direction === 'asc') {
                        return cellA > cellB ? 1 : -1;
                    } else {
                        return cellA < cellB ? 1 : -1;
                    }
                });

                $.each(rows, function(index, row) {
                    table.children('tbody').append(row); // Re-append sorted rows to the table
                });

                // Toggle the direction
                $(this).data('direction', direction === 'asc' ? 'desc' : 'asc');
            });
        });

        // Search Function
        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("sortableTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none"; // Hide all rows initially
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = ""; // Show row if search text matches
                            break;
                        }
                    }
                }
            }
        }
    </script>

</body>

</html>