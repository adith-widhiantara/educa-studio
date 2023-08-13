<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Senior PHP Developer Test - Educa Studio</title>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="https://www.educastudio.com/img/favicon.ico">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-8 offset-2 mb-3">
            <h1 class="text-center">Senior PHP Developer Test - Educa Studio</h1>
        </div>

        <div class="col-8 offset-2 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="inputMinimalPoint" class="form-label">Minimal Point</label>
                                <input type="number" class="form-control" id="inputMinimalPoint" min="0">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="inputMaximalPoint" class="form-label">Maximal Point</label>
                                <input type="number" class="form-control" id="inputMaximalPoint" min="0">
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="#/" class="btn btn-primary" id="submit">Submit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-8 offset-2 mb-3">
            <div class="card">
                <div class="card-body">
                    <table id="myTable" class="display">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Institution</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/bootstrap.js') }}"></script>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/datatables.js') }}"></script>

<script>
    $(document).ready(function () {
        // get host name
        let host = window.location.origin;
        let url = host + '/data/load';

        // get table
        let table = $('#myTable');

        // get minimal point and maximal point when click submit button
        $('#submit').click(function () {
            let minimalPoint = $('#inputMinimalPoint').val();
            let maximalPoint = $('#inputMaximalPoint').val();

            // get data from api
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    minimal_point: minimalPoint,
                    maximal_point: maximalPoint
                },
                success: function (response) {
                    // clear table
                    table.DataTable().clear().draw();

                    // add data to table
                    table.DataTable().rows.add(response.data.points).draw();
                }
            });
        });

        table.DataTable({
            processing: true,
            ajax: {
                url: url,
                dataSrc: 'data.points',
            },
            columns: [
                {data: 'nomor'},
                {data: 'member_name'},
                {data: 'institution_name'},
                {data: 'total'},
            ]
        });
    });
</script>
</body>
</html>