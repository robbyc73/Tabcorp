<?php
namespace SoftwareEngineerTest;

// Question 1a

$DB_HOST = 'localhost';
$DB_NAME = 'test';
$DB_USER = 'test';
$DB_PASS = 'test';

$DB = new \mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if($DB->connect_error) die('Connect Error ('.$DB->connect_errno.')'. $DB->connect_error);

$cSQL = "SELECT `customer`.`customer_id` AS `cid`, `customer`.`first_name`, `customer`.`last_name`, `customer_occupation`.`occupation_name` AS `occupation`
         FROM `customer`
         LEFT JOIN `customer_occupation` ON (`customer_occupation`.`customer_occupation_id` = `customer`.`customer_occupation_id`)";
         
if(isset($_GET['occupation_name']))  $cSQL .= " WHERE `customer_occupation`.`occupation_name`=?";

if($stmt = $DB->prepare($cSQL)) {

if(isset($_GET['occupation_name'])) $stmt->bind_param("s",$_GET['occupation_name']);

if(!$stmt->execute()) die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);

$res = $stmt->get_result();
?>

<h2>Customer List</h2>

<table>
	<?php if($res->num_rows == 0) { ?>
	<tr>
  <td>No customers found</td>
  </tr>
	<?php }
  else { ?>
	<tr>
		<th>Customer ID</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Occupation</th>
	</tr>
	
<?php
} 
  while ($rec = $res->fetch_assoc()) {
  if(is_null($rec['occupation'])) $rec['occupation'] = 'un-employed';
?>
	<tr>
	<td><?php echo $rec['cid']; ?></td>
	<td><?php echo $rec['first_name']; ?></td>
	<td><?php echo $rec['last_name']; ?></td>
	<td><?php echo $rec['occupation']; ?></td>
	</tr>
<?php } ?>
</table>
<?php
$stmt->close();
}
$DB->close();
?>
