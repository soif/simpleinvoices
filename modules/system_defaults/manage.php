<?php

//stop the direct browsing to this file - let index.php handle which files get displayed
checkLogin();

#get the invoice id
$customer_id = $_GET['submit'];


#system defaults query
$print_defaults = "SELECT * FROM {$tb_prefix}defaults WHERE def_id = 1";
$result_print_defaults = mysql_query($print_defaults, $conn) or die(mysql_error());


while ($Array = mysql_fetch_array($result_print_defaults) ) {
                $def_idField = $Array['def_id'];
                $def_customerField = $Array['def_customer'];
                $def_billerField = $Array['def_biller'];
                $def_taxField = $Array['def_tax'];
                $def_inv_preferenceField = $Array['def_inv_preference'];
                $def_number_line_itemsField = $Array['def_number_line_items'];
                $def_inv_templateField = $Array['def_inv_template'];
                $def_payment_typeField = $Array['def_payment_type'];
};


//TODO: Combine all getNames/description in 1 querie...
$biller_name = "SELECT name from {$tb_prefix}biller where id = $def_billerField";
$result_biller_name = mysql_query($biller_name, $conn) or die(mysql_error());

while ($Array = mysql_fetch_array($result_biller_name) ) {
                $b_nameField = $Array['name'];
};


$customer_name = "select c_name from {$tb_prefix}customers where c_id = $def_customerField";
$result_customer_name = mysql_query($customer_name, $conn) or die(mysql_error());

while ($Array_customer = mysql_fetch_array($result_customer_name) ) {
                $c_nameField = $Array_customer['c_name'];
};

$tax_description = "select tax_description from {$tb_prefix}tax where tax_id = $def_taxField";
$result_tax_description = mysql_query($tax_description, $conn) or die(mysql_error());

while ($Array_tax = mysql_fetch_array($result_tax_description) ) {
                $tax_descriptionField = $Array_tax['tax_description'];
};

$inv_preferences = "select pref_description from {$tb_prefix}preferences where pref_id = $def_inv_preferenceField";
$result_inv_preferences = mysql_query($inv_preferences, $conn) or die(mysql_error());

while ($Array_inv_preferences = mysql_fetch_array($result_inv_preferences) ) {
                $inv_preferencesField = $Array_inv_preferences['pref_description'];
};
/*
$inv_num_line_items = "select def_number_line_items from {$tb_prefix}preferences where pref_id = $def_inv_preferenceField";
$result_inv_preferences = mysql_query($inv_preferences, $conn) or die(mysql_error());

while ($Array_inv_preferences = mysql_fetch_array($result_inv_preferences) ) {
                $def_number_line_itemsianv_preferencesField = $Array_inv_preferences['pref_description'];
};
*/

#Payment type section
$payment_type_description = "select pt_description from {$tb_prefix}payment_types where pt_id = $def_payment_typeField";
$result_payment_type_description = mysql_query($payment_type_description, $conn) or die(mysql_error());

while ($Array_pt = mysql_fetch_array($result_payment_type_description) ) {
                $payment_type_descriptionField = $Array_pt['pt_description'];
};


$display_block =  "
	
	<table align=center>
	<tr>
		<td class='details_screen'><a href='index.php?module=system_defaults&view=edit&submit=biller'>Edit</a></td><td class='details_screen'>Biller</td><td>$b_nameField</td>
	</tr>
	<tr>
		<td class='details_screen'><a href='index.php?module=system_defaults&view=edit&submit=customer'>Edit</a></td><td class='details_screen'>Customer</td><td>$c_nameField</td>
	</tr>
	<tr>
		<td class='details_screen'><a href='index.php?module=system_defaults&view=edit&submit=tax'>Edit</a></td><td class='details_screen'>Tax</td><td>$tax_descriptionField</td>
	</tr>
	<tr>
		<td class='details_screen'><a href='index.php?module=system_defaults&view=edit&submit=inv_preference'>Edit</a></td><td class='details_screen'>Invoice preference</td><td>$inv_preferencesField</td>
	</tr>
	<tr>
		<td class='details_screen'><a href='index.php?module=system_defaults&view=edit&submit=line_items'>Edit</a></td><td class='details_screen'>Default number of line items</td><td>$def_number_line_itemsField</td>
	</tr>
	<tr>
		<td class='details_screen'><a href='index.php?module=system_defaults&view=edit&submit=def_inv_template'>Edit</a></td><td class='details_screen'>Default invoice template</td><td>$def_inv_templateField</td>
	</tr>
	<tr>
		<td class='details_screen'><a href='index.php?module=system_defaults&view=edit&submit=def_payment_type'>Edit</a></td><td class='details_screen'>Default payment type</td><td>$payment_type_descriptionField</td>
	</tr>
        </table>

";


include('./config/config.php');

echo <<<EOD
<b>System defaults</b>
    <hr></hr>

$display_block
<!--
<a href="manage_system_defaults.php">Edit</a>

-->
EOD;
?>