<?php
//Turn on error reporting -- this is critical
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();
//If user is not logged in, reroute them to the login page
if(!isset($_SESSION['username'])) {
    header('location: guestbookLogin.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Page</title>
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <!--<link rel="stylesheet" href="./styles/databaseStyles.css">-->
</head>
<body>
    <div class="container">
        <h3>Guestbook Summary</h3>
        <?php
            require('/home2/ngadomsk/connect.php');

        $sql = "SELECT guest_id, firstName, lastName, timestamp, company, linkedIn, email, how_we_met
                FROM Guestbook
                ORDER BY timestamp DESC";

        $result = @mysqli_query($cnxn, $sql);
        ?>

        <table id="guestbook-table" class="display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>timeFilled</th>
                    <th>Company</th>
                    <th>LinkedIn</th>
                    <th>E-mail</th>
                    <th>How we met</th>
                </tr>
            </thead>
            <tbody>
            <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $timestamp = date('m-d-Y', strtotime($row['timestamp']));
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    $company = $row['company'];
                    $linkedIn = $row['linkedIn'];
                    $email = $row['email'];
                    $meet = $row['how_we_met'];

                    echo "<tr>
                    <td>$firstName $lastName</td>
                    <td>$timestamp</td>
                    <td>$company</td>
                    <td>$linkedIn</td>
                    <td>$email</td>
                    <td>$meet</td>
                    </tr>";
                }
            ?>
            </tbody>
        </table>

        <a href="guestbook.html">Add a new guest</a> <br>
        <a href="guestbookLogout.php">Logout</a>


    </div>

    <script src="//code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <!--<script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>-->
    <script>

        $('#guestbook-table').DataTable( {
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal( {
                        header: function ( row ) {
                            var data = row.data();
                            // return 'Details for '+data[0]+' '+data[1];
                            return 'Details for '+data[0];
                        }
                    } ),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                        tableClass: 'table'
                    } )
                }
            }
        } );
    </script>

</body>
</html>
