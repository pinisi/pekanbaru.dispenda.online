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
$table = 'merchant';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'id',   'dt' => 0, 'field' => 'id',
        'formatter' => function ($d, $row) {
            return '
            <button type="button" class="btn btn-outline btn-primary edit-button" data-toggle="modal" data-target="#customModal" data-button="edit" data-attr="'.$d.','.$row[1].','.$row[2].','.$row[3].'" data-id="'.$d.'" data-username="'.$row[0].'" data-level="'.$row[1].'"><i class="fa fa-edit"></i></button>&nbsp;
            <button type="button" class="btn btn-outline btn-warning delete-button" data-id="'.$d.'" data-name="'.$row[1].'"><i class="fa fa-trash"></i></button>&nbsp;
            ';
        }
     ),    
    array( 'db' => 'merchantname',  'dt' => 1 , 'field' => 'merchantname'),
    array( 'db' => 'npwp',  'dt' => 2 , 'field' => 'npwp'),
    array( 'db' => 'address',  'dt' => 3 , 'field' => 'address')
);
 
// SQL server connection information
$sql_details = array(
    'user' => 'batam',
    'pass' => 'batam2016',
    'db'   => 'taxdb',
    'host' => 'localhost'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
