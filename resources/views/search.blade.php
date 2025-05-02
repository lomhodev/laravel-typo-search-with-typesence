<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body class="container">
    <h1>Product List</h1>
    <form id="search-form" class="d-flex mb-3 justify-center align-items-center">
        <input type="search" class="form-control w-25" id="query" name="query" value="{{ request('query') }}" placeholder="Enter product name">
        <button type="submit" class="btn btn-primary">Search</button>
        <button type="button" id="clear-btn" class="btn btn-secondary ms-2" style="display: none;">Clear</button>
    </form>
    <div class="mt-4">
        <h2>Search Results</h2>
        <div id="results">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody id="results-body">
                    <tr>
                        <td colspan="4" class="text-center">No products found.</td>
                    </tr>
                </tbody>
            </table>
            <nav id="pagination" class="mt-3"></nav>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            const $resultsBody = $('#results-body');
            const $clearBtn = $('#clear-btn');
            const $pagination = $('#pagination');

            loadData();

            // Show clear button if query exists
            if ($('#query').val()) {
                $clearBtn.show();
            }

            // Handle form submission via AJAX
            $('#search-form').on('submit', function (e) {
                e.preventDefault();
                const query = $('#query').val();
                loadData(query);
            });

            $('#query').on('keyup', function () {
                const query = $(this).val();
                loadData(query);
            });

            // Handle clear button click
            $clearBtn.on('click', function () {
                $('#query').val('');
                loadData();
            });

            // Handle pagination click
            $(document).on('click', '.page-link', function (e) {
                e.preventDefault();
                const url = $(this).attr('href');
                const query = $('#query').val();
                loadData(query, url);
            });

            function loadData(query = '', url = "{{ route('search') }}") {
            $.ajax({
                url: url,
                method: "GET",
                data: { query: query },
                success: function (response) {
                    let rowsHtml = '';
                    let data = response.products.data;
                    if (data.length > 0) {
                        data.forEach(product => {
                            rowsHtml += `<tr>
                                <td>${product.id}</td>
                                <td>${product.code}</td>
                                <td>${product.name}</td>
                                <td>${product.description || 'N/A'}</td>
                            </tr>`;
                        });
                    } else {
                        rowsHtml = '<tr><td colspan="4" class="text-center">No products found.</td></tr>';
                    }
                    $resultsBody.html(rowsHtml);

                    // Render pagination
                    renderPagination(response.products.links);

                    if (query) {
                        $clearBtn.show();
                    } else {
                        $clearBtn.hide();
                    }
                },
                error: function () {
                    $resultsBody.html('<tr><td colspan="4" class="text-center text-danger">An error occurred while fetching results.</td></tr>');
                }
            });
        }

        function renderPagination(links) {
            let paginationHtml = '<ul class="pagination justify-content-center">';
            links.forEach(link => {
                paginationHtml += `<li class="page-item ${link.active ? 'active' : ''} ${link.url ? '' : 'disabled'}">
                    <a class="page-link" href="${link.url || '#'}">${link.label}</a>
                </li>`;
            });
            paginationHtml += '</ul>';
            $('#pagination').html(paginationHtml);
        }
        });

       
    </script>
</body>
</html>