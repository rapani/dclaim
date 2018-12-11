<?php
//if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

    require '../datatables/datatables/examples/server_side/scripts/ssp.class.php';

    // nama table
    $table = 'rjtl';

    // Table's primary key
    $primaryKey = 'id';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database, while the `dt`
    // parameter represents the DataTables column identifier. In this case simple
    // indexes

    $columns = array(
        array( 'db' => 'nama_pasien',  'dt' => 'nama_pasien'),
        array( 'db' => 'no_sep',  'dt' => 'no_sep' ),
        array( 'db' => 'tgl_sep', 'dt' => 'tgl_sep'),
        array( 'db' => 'poli',  'dt' => 'poli'),
        array( 'db' => 'pdf_billing',   'dt' => 'pdf_billing',
        'formatter' => function($a) { return $a==1 ? "&radic;" : "-"; } ),
        array( 'db' => 'pdf_individual',     'dt' => 'pdf_individual',
        'formatter' => function($a) { return $a==1 ? "&radic;" : "-"; } ),
        array( 'db' => 'pdf_camscan',     'dt' => 'pdf_camscan' ,
        'formatter' => function($a) { return $a==1 ? "&radic;" : "-"; }),
        array(
            'db' => 'id',
            'dt' => 'aksi',
            'formatter' => function($d) {
                return '<a href="index.php?page=urajal&id=' . $d . '"><button type="button" class="btn btn-outline-primary btn-sm btn-block">Upload</button></a>';
            }),

        array(
            'db' => 'no_kar',
            'dt' => 'no_kar',
            'formatter' => function($d) {
                return '<a href="http://192.168.1.181/tool-pilar/pasien.php?nokar=' . $d . '" target="_blank">'.$d.'</a>';
            }),

        array(
            'db' => 'verif',
            'dt' => 'verif',
            'formatter' => function($a) {
                // $d==1 ? "&radic;" : "-";
                return $a==1 ? " <b class='text-primary'>&radic; </b>" : "<b class='text-danger'>x </b>";
            }
        )

    );

    //SQL server connection information
    $sql_details = array(
        'user' => 'root',
        'pass' => '',
        'db' => 'eclaim',
        'host' => 'localhost'
    );


    echo json_encode(
            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
    );
//} else {
 //   echo '<script>window.location="404.html"</script>';
//}
?>
