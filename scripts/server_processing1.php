<?php
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'v_status';

// Table's primary key
$primaryKey = 'NO';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`NO`', 'dt' => 0, 'field' => 'NO' ),
	array( 'db' => '`u`.`WP`',  'dt' => 1, 'field' => 'WP' ),
	array( 'db' => '`u`.`alamat`',   'dt' => 2, 'field' => 'alamat' ),
	array( 'db' => '`u`.`status`',     'dt' => 3, 'field' => 'status'),
	array( 'db' => '`u`.`last_transaksi`', 'dt' => 4, 'field' => 'last_transaksi', 'formatter' => function( $d, $row ) {
																	return date( 'jS M y', strtotime($d));
																}),
	array( 'db' => '`u`.`keterangan`',   'dt' => 5, 'field' => 'keterangan' )
);

// SQL server connection information
$sql_details = array(
        'user' => 'root',
        'pass' => 'simpoda@1234!',
        'db'   => 'batam_simpoda',
        'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM `v_status` AS `u`";
$extraWhere = "`u`.`status` = 'OK'";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);
	



