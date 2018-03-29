<?php
require('rdsDeva.class.php');

/*
 * Connecting to RDS encoder
 */
$RdsDeva = new RdsDeva('host:port', 'deva', '1234');

/*
 * Retrieve actual RDS datas
 */
$rds = $RdsDeva->get();

/*
 * Modify RDS datas
 */
$rds->setPS('Kiss FM');
$rds->setRT('ARTIST - Title');

/*
 * Send new RDS datas to Deva SmartGen Mini RDS encoder
 */
$rds->send();
