<?php

$vcard_info = array();

/*
 * You need to configure relations for your listing fields.
 * Please generate correct array you wish to have in your vCard:
 * don't change keys and configure values only for existing vCard fields
 *
 * Example: your directory has state and city fields, called 'state' & 'city'
 * so you only need to add two lines for your $fields_array
 *
 * 'hometown' => 'city',
 * 'homecounty' => 'state',
 *
 * Please post your comments at esyndicat.com website!
 *
 */
$fields_array = array(
	'firstname' => 'title',
	'homeemail' => 'email',
	'homeurl' => 'url',
	'notes' => 'description',
/*
	'surname' => 'surname',
	'nickname' => 'account_username',
	'birthday' => 'birthday',
	'company' => 'company',
	'jobtitle' => 'jobtitle',
	'workbuilding' => 'xxxxxxx',
	'workstreet' => 'xxxxxxxxxxxxxx',
	'worktown' => 'xxxxxx',
	'workcounty' => 'xxxxxxxxx',
	'workpostcode' => 'xxxx xxx',
	'workcountry' => 'xxxxxxxxxxxx',
	'worktelephone' => 'xxxxxx xxxxxx',
	'workemail' => 'xxxxxx@xxxxxx.xxx',
	'workurl' => 'http://www.xxxxxxxxx.xxx',
	'homebuilding' => 'xxxxxx',
	'homestreet' => 'xxxxxxxxx',
	'hometown' => 'xxxxxxxxx',
	'homecounty' => 'xxxxxxxxxxxx',
	'homepostcode' => 'xxxx xxx',
	'homecountry' => 'xxxxxxxxx',
	'hometelephone' => 'xxxxxx xxxxxx',
	'mobile' => 'xxxxxxxxx xxxxxx'
*/
);

$listing_id = isset($_GET['listing']) ? (int)$_GET['listing'] : 0;
// display 404 in case we get incorrect params
if (empty($listing_id))
{
	iaView::errorPage(iaView::ERROR_NOT_FOUND);
}

// define listing class
$eSyndiCat->factory("Listing");

// get listing information
$listing = $esynListing->getListingById($listing_id);

// display 404 in case we don't have any listing for this id
if (!$listing)
{
	iaView::errorPage(iaView::ERROR_NOT_FOUND);
}

// assign listing fields to match vCard standard
foreach($fields_array as $key=>$field)
{
	if (!empty($listing[$field]))
	{
		$vcard_info[$key] = $listing[$field];
	}
}

if ($vcard_info)
{
	// define vCard class
	$eSyndiCat->loadPluginClass("VCF", "mgvcard", "esyn", false);
	$esynVCF = new esynVCF($vcard_info);

	$esynVCF->show();
}