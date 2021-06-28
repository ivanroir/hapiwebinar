<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TABLE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://hapiwebinar.tk/wwwroot/css/sweetalert2.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/datatables.min.css"/>
        
    <style type="text/css">
    
        div > a > img {
            display: none;
        }
        
        [data-tag=N] {
            color: #dc3545!important;
        }

        .divDate {
            background-color: #00793f !important;
        }

        .date {
            color: #fff;
            margin: 1rem;
        }

        body {
            overflow-x: hidden;
        }
    </style>

</head>
<body>
    <div class="row p-5">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                <h2> LOGIN </h2>
            </div>
            <div class="col-12">
                <h2>Legend</h2>
                <h4>0 - False</h4>
                <h4>1 - True</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table_id">
                    <thead>
                        <tr style="background-color: #00793f;">
                            <td scope="col">#</td>
                            <td scope="col" class="donotexport">ACTION</td>
                            <td scope="col">EMAIL</td>
                            <td scope="col">CODE</td>
                            <td scope="col">STATUS</td>
                            <td scope="col">FORGOT PASSWORD</td>
                            <td scope="col">RESET PASSWORD</td>
                            <td scope="col">ZOOM ENTERED</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        header("Access-Control-Allow-Origin: *");

                        $servername = "localhost";
                        $username = "u480472038_freseniuskabi";
                        $password = "Ivan.Roir090493";
                        $database = "u480472038_freseniuskabi";
                        
                        //$conn = mysqli_connect('localhost', 'root', '', 'freseniuskabi'); //dev
                        $conn = mysqli_connect($servername, $username, $password, $database);
    
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM users";
                        $result = $conn->query($sql);
                        $ctr = 1;

                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {

                                $disable_forgot = $row['forgot_password'] == 1 ? 'enabled' : 'disabled';
                                $disable_reset = $row['reset_password'] == 1 ? 'enabled' : 'disabled';

                                echo"
                                        <tr>                                         
                                            <th scope='row'>" . $ctr++ . "</th>
                                            <td>
                                                <button type='button' class='btn btn-primary' id='forgot' onclick='forgot(" . $row['id'] . ", `" . $row['email'] . "`, `" . $row['code'] . "`)' $disable_forgot>FORGOT</button>
                                                <button type='button' class='btn btn-primary' id='reset' onclick='reset(" . $row['id'] . ", `" . $row['email'] . "`)' $disable_reset>RESET</button>
                                            </td>
                                            <td>" . $row['email'] . "</td>
                                            <td>" . $row['code'] . "</td>
                                            <td>" . $row['status'] . "</td>
                                            <td>" . $row['forgot_password'] . "</td>
                                            <td>" . $row['reset_password'] . "</td>
                                            <td>" . $row['zoom_entered'] . "</td>
                                        </tr>
                                    ";
                            }
                        }
                        else {
                            echo "
                                <tr>
                                    <td>Empty</td>
                                </tr>
                            ";
                        }
                        $conn->close();

                        ?>
                    </tbody>
                </table>                    
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://hapiwebinar.tk/wwwroot/js/sweetalert2.all.min.js"></script>
    <script>
        var status = "";
        
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        var table = $(document).ready(function() {
            $('#table_id').DataTable( {
                dom: 'Bfrtip',
                paging: false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'NDAP-ANCON',
                        exportOptions: {
                            columns: ':not(.donotexport)'
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'NDAP-ANCON',
                        exportOptions: {
                            columns: ':not(.donotexport)'
                        }
                    }                    
                ]
            });
        });

        setInterval(function(){ 
            $("#table_id").load( "index.php #table_id" ); 
        }, 500);

        function forgot(id, email, code){             
            var subject = "Forgot Password";
            var body = "Your Password is " + code;
            
            $.ajax({
                url: "https://hapiwebinar.tk/table/user/update.php",
                type: "POST",
                data: {
                    id: id,
                    mode: 'forgot_password'
                },
                success: function (msg) {
                    if (msg == "1") {
                        $("#table_id" ).load( "index.php #table_id" );
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated'
                        })

                        $.ajax({
                            url: 'https://hapiwebinar.tk/send_email.php',
                            type: 'POST',
                            data: {
                                email: email,
                                subject: subject,
                                body: body
                            }, 
                            success: function(response) {
                                console.log("Success");
                            },
                            error: function(response){
                                console.log(response);
                            }
                        })
                    }
                    else {
                        status = msg;
                    }
                },
            });
        }

        function reset(id, email){
            var subject = "Reset Password";
            var body = "Your can login again";

            $.ajax({
                url: "https://hapiwebinar.tk/table/user/update.php",
                type: "POST",
                data: {
                    id: id,
                    mode: 'reset_password'
                },
                success: function (msg) {
                    if (msg == "1") {
                        $("#table_id" ).load( "index.php #table_id" );
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated'
                        })

                        $.ajax({
                            url: 'https://hapiwebinar.tk/send_email.php',
                            type: 'POST',
                            data: {
                                email: email,
                                subject: subject,
                                body: body
                            }, 
                            success: function(response) {
                                console.log("Success");
                            },
                            error: function(response){
                                console.log(response);
                            }
                        })

                    }
                    else {
                        status = msg;
                    }
                },
            });
        }

    </script>
</body>
</html>