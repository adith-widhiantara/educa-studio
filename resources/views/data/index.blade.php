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
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Create Data</a>
                </div>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="inputName" class="form-label">Name</label>
                                    <select class="form-select" aria-label="Default select example" name="member" required>
                                        <option selected value="">Open this select menu</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->name }}">{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="inputInstitution" class="form-label">Institution</label>
                                    <select class="form-select" aria-label="Default select example" name="institution" required>
                                        <option selected>Open this select menu</option>
                                        @foreach($institutions as $institution)
                                            <option value="{{ $institution->name }}">{{ $institution->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="inputPoint" class="form-label">Point</label>
                                    <input type="number" class="form-control" id="inputPoint" name="point" value="{{ old('point') }}" min="0" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-8 offset-2 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center">Filter Point</h5>
                </div>
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
                            <a href="#/" class="btn btn-primary btn-sm" id="submit">Submit</a>
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

        // Create a Bootstrap modal with a unique ID
        let modal = $('<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">\
                    <div class="modal-dialog">\
                        <div class="modal-content">\
                            <div class="modal-header">\
                                <h5 class="modal-title" id="myModalLabel"></h5>\
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\
                            </div>\
                            <div class="modal-body">\
                                <form method="post" id="memberForm">\
                                <input type="hidden" name="_token" value="{{ @csrf_token() }}">\
                                <input type="hidden" name="_method" value="put">\
                                <input type="hidden" name="type" id="typeInput">\
                                <input type="hidden" name="last_name" id="lastNameInput">\
                                    <div class="mb-3">\
                                        <label for="memberName" class="form-label" id="nameLabel"></label>\
                                        <input type="text" class="form-control" id="nameInput" name="name" required>\
                                    </div>\
                                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>\
                                </form>\
                            </div>\
                        </div>\
                    </div>\
            </div>');

        // Append the modal to the body
        $('body').append(modal);

        // Event listener for member_name click
        table.on('click', 'a.member-link', function () {
            let rowData = table.DataTable().row($(this).closest('tr')).data();
            let memberName = rowData.member_name;

            $('#myModalLabel').html('Member Edit');
            $('#nameLabel').html('Member Name');
            $('#lastNameInput').val(memberName);
            $('#nameInput').val(memberName);
            $('#typeInput').val('member');
            $('#myModal').modal('show');
        });

        // Event listener for institution_name click
        table.on('click', 'a.institution-link', function () {
            let rowData = table.DataTable().row($(this).closest('tr')).data();
            let institutionName = rowData.institution_name;

            $('#myModalLabel').html('Institution Edit');
            $('#nameLabel').html('Institution Name');
            $('#lastNameInput').val(institutionName);
            $('#nameInput').val(institutionName);
            $('#typeInput').val('institution');
            $('#myModal').modal('show');
        });

        table.DataTable({
            processing: true,
            ajax: {
                url: url,
                dataSrc: 'data.points',
            },
            columns: [
                {
                    data: 'nomor',
                    searchable: false
                },
                {
                    data: 'member_name',
                    render: function (data) {
                        return '<a href="#/" class="member-link">' + data + '</a>';
                    }
                },
                {
                    data: 'institution_name',
                    render: function (data) {
                        return '<a href="#/" class="institution-link">' + data + '</a>';
                    }
                },
                {
                    data: 'total'
                },
            ]
        });
    });
</script>
</body>
</html>