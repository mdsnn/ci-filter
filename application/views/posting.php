<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>CI FILTER</title>
  <style>
    /* 28/9/24 MS: Basic styling for the body */
    body {
      font-family: Arial, sans-serif;
    }

    table th,
    table td {
      padding: 12px;
    }

    table th {
      cursor: pointer;
    }

    table tr:hover {
      background-color: #f2f2f2;
    }

    .search-box {
      margin-bottom: 20px;
    }

    input[type="text"] {
      padding: 5px;
      width: auto;
      border-radius: 3px;
      border-color: blue !important;
    }

    input[type="text"]:focus {
      border-color: blue !important;
      box-shadow: 0 0 5px rgba(0, 0, 255, 0.5) !important;
      outline: none;
    }


    .list-group {
      padding-left: 0;
      margin-top: 60px;
      list-style: none;
    }


    .list-group-item a {
      color: #007bff;
      text-decoration: none;
    }


    .list-group-item a:hover {
      text-decoration: underline;
    }


    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12 mt-5">

        <h1 class="text-center">CodeIgniter FILTER POST YEAR WISE</h1>
        <hr>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">

        <ul class="list-group">
          <?php if (isset($years)) {
            foreach ($years as $value) { ?>
              <li class="list-group-item">

                <a href="<?= base_url(); ?>posts/<?= $value->year; ?>"><?= $value->year; ?></a>
              </li>
          <?php }
          } ?>
        </ul>
      </div>
      <div class="col-md-9">
        <!-- 28/9/24 MS: Search box for filtering table rows -->
        <div class="d-flex justify-content-end align-items-center search-box mb-3 ">
          <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for all fields..">
        </div>

        <!-- 28/9/24 MS: Table displaying student records -->
        <table class="table table-striped" id="sortableTable">
          <thead class="thead-dark">
            <tr>

              <th data-type="text">
                <div style="display:flex; justify-content: space-between; align-items: center;"><span>ID</span> <i class="fas fa-sort"></i></div>
              </th>
              <th data-type="text">
                <div style="display:flex; justify-content: space-between; align-items: center;"><span>Name</span> <i class="fas fa-sort"></i></div>
              </th>
              <th data-type="text">
                <div style="display:flex; justify-content: space-between; align-items: center;"><span>Standard</span> <i class="fas fa-sort"></i></div>
              </th>
              <th data-type="number">
                <div style="display:flex; justify-content: space-between; align-items: center;"><span>Percentage</span> <i class="fas fa-sort"></i></div>
              </th>
              <th data-type="date">
                <div style="display:flex; justify-content: space-between; align-items: center;"><span>Result</span> <i class="fas fa-sort"></i></div>
              </th>
              <th data-type="number">
                <div style="display:flex; justify-content: space-between; align-items: center;"><span>Date</span> <i class="fas fa-sort"></i></div>
              </th>
            </tr>
          </thead>
          <tbody>
            <!-- 28/9/24 MS: Dynamic table rows generated from PHP variable -->
            <?php if (isset($posts)) {
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
            } ?>
          </tbody>
        </table>

        <!-- 28/9/24 MS: Pagination controls -->
        <div class="pagination">
          <ul class="pagination">
            <li class="page-item">
              <a class="page-link" id="prevPage" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
            <li class="page-item"><a id="pageNumbers" class="page-link" href="#">1</a></li>
            <li class="page-item">
              <a id="nextPage" class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      // 28/9/24 MS: Click event for sorting table columns
      $('th').on('click', function() {
        var column = $(this).index();
        var table = $('#sortableTable');
        var rows = table.find('tbody tr').toArray();
        var type = $(this).data('type');
        var direction = $(this).data('direction') === 'asc' ? 'desc' : 'asc';

        // 28/9/24 MS: Sorting logic for different data types
        rows.sort(function(a, b) {
          var cellA = $(a).find('td').eq(column).text();
          var cellB = $(b).find('td').eq(column).text();

          // 28/9/24 MS: Type conversion for sorting
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

          return (cellA < cellB ? (direction === 'asc' ? -1 : 1) : (cellA > cellB ? (direction === 'asc' ? 1 : -1) : 0));
        });

        // 28/9/24 MS: Re-append sorted rows to the table
        $.each(rows, function(index, row) {
          table.children('tbody').append(row);
        });

        // 28/9/24 MS: Reset sorting icons for all headers
        $('th i').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');

        // 28/9/24 MS: Update the icon for the current header
        $(this).data('direction', direction);
        if (direction === 'asc') {
          $(this).find('i').removeClass('fa-sort').addClass('fa-sort-up');
        } else {
          $(this).find('i').removeClass('fa-sort').addClass('fa-sort-down');
        }
      });

      // 28/9/24 MS: Search function to filter table rows based on input
      $('#searchInput').on('keyup', function() {
        var filter = $(this).val().toLowerCase();
        $('#sortableTable tbody tr').each(function() {
          var row = $(this);
          var showRow = false;
          row.find('td').each(function() {
            var cellText = $(this).text().toLowerCase();

            if (cellText.indexOf(filter) > -1) {
              showRow = true;
              return false;
            }
          });
          row.toggle(showRow);
        });
      });

      // 28/9/24 MS: Pagination functionality
      var rowsPerPage = 5;
      var currentPage = 1;
      var rows = $('#sortableTable tbody tr');
      var totalRows = rows.length;
      var totalPages = Math.ceil(totalRows / rowsPerPage);

      // 28/9/24 MS: Function to update table display based on the current page
      function updateTable() {
        rows.hide();
        var start = (currentPage - 1) * rowsPerPage;
        var end = start + rowsPerPage;
        rows.slice(start, end).show();
        $('#pageNumbers').text(currentPage + " / " + totalPages);
      }

      // 28/9/24 MS: Event handler for previous page button
      $('#prevPage').on('click', function() {
        if (currentPage > 1) {
          currentPage--;
          updateTable();
        }
      });

      // 28/9/24 MS: Event handler for next page button
      $('#nextPage').on('click', function() {
        if (currentPage < totalPages) {
          currentPage++;
          updateTable();
        }
      });

      updateTable();
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>