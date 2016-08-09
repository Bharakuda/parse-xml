<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Read existing XML
$_dom = new DOMDocument('1.0');
$_dom->loadXML(file_get_contents('./sales-order.xml'));

// Create a new XML
$dom = new DOMDocument('1.0');
$salesOrder = $dom->appendChild($dom->createElement('SalesOrder'));

// Build first level elements
$salesOrder->appendChild($dom->createElement('ChromeOrderReference', $_ChromeOrderReference));
$salesOrder->appendChild($dom->createElement('SoldToBusinessPartner', $_dom->getElementsByTagName('Sold-ToBusinessPartner')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('InvoiceToBusinessPartner', $_dom->getElementsByTagName('Invoice-ToBusinessPartner')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('ShipToBusinessPartner', $_dom->getElementsByTagName('Ship-ToBusinessPartner')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('PurchaseOrderDate', $_dom->getElementsByTagName('PurchaseOrderDate')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('ShipComplete', $_dom->getElementsByTagName('ShipComplete')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('Company', $_dom->getElementsByTagName('Company')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('OrderType', $_dom->getElementsByTagName('OrderType')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('NetPriceOverrideQualifier', $_dom->getElementsByTagName('NetPriceOverrideQualifier')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('ListPriceOverrideQualifier', $_dom->getElementsByTagName('ListPriceOverrideQualifier')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('Currency', $_dom->getElementsByTagName('Currency')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('OrderSource', $_dom->getElementsByTagName('OrderSource')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('PaymentMethod', $_dom->getElementsByTagName('PaymentMethod')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('referenceA', $_dom->getElementsByTagName('referenceA')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('PlannedDeliveryDate', $_dom->getElementsByTagName('PlannedDeliveryDate')[0]->nodeValue));
$salesOrder->appendChild($dom->createElement('OrderSubmissionDate', $_dom->getElementsByTagName('OrderSubmissionDate')[0]->nodeValue));

// Build shipping address elements
$ShipToAddress = $salesOrder->appendChild($dom->createElement('ShipToAddress'));
$_ShipToAddress = $_dom->getElementsByTagName('Ship-ToAddress')[0];

$shippingAddress = sprintf('%s, %s, %s, %s, %s',
    $_ShipToAddress->getElementsByTagName('AddressLine1')[0]->nodeValue,
    $_ShipToAddress->getElementsByTagName('AddressLine2')[0]->nodeValue,
    $_ShipToAddress->getElementsByTagName('City')[0]->nodeValue,
    $_ShipToAddress->getElementsByTagName('PostalCode')[0]->nodeValue,
    $_ShipToAddress->getElementsByTagName('Country')[0]->nodeValue
);

$ShipToAddress->appendChild($dom->createElement('Name1', $_ShipToAddress->getElementsByTagName('Name1')[0]->nodeValue));
$ShipToAddress->appendChild($dom->createElement('Name2', $_ShipToAddress->getElementsByTagName('Name2')[0]->nodeValue));
$ShipToAddress->appendChild($dom->createElement('Address', $shippingAddress));
$ShipToAddress->appendChild($dom->createElement('Phone', $_ShipToAddress->getElementsByTagName('Phone')[0]->nodeValue));
$ShipToAddress->appendChild($dom->createElement('EmailAddress', $_ShipToAddress->getElementsByTagName('EmailAddress')[0]->nodeValue));

// Build invoice address elements
$InvoiceToAddress = $salesOrder->appendChild($dom->createElement('InvoiceToAddress'));
$_InvoiceToAddress = $_dom->getElementsByTagName('Invoice-ToAddress')[0];

$invoiceAddress = sprintf('%s, %s, %s, %s, %s',
    $_InvoiceToAddress->getElementsByTagName('AddressLine1')[0]->nodeValue,
    $_InvoiceToAddress->getElementsByTagName('AddressLine2')[0]->nodeValue,
    $_InvoiceToAddress->getElementsByTagName('City')[0]->nodeValue,
    $_InvoiceToAddress->getElementsByTagName('PostalCode')[0]->nodeValue,
    $_InvoiceToAddress->getElementsByTagName('Country')[0]->nodeValue
);

$InvoiceToAddress->appendChild($dom->createElement('Name1', $_InvoiceToAddress->getElementsByTagName('Name1')[0]->nodeValue));
$InvoiceToAddress->appendChild($dom->createElement('Name2', $_InvoiceToAddress->getElementsByTagName('Name2')[0]->nodeValue));
$InvoiceToAddress->appendChild($dom->createElement('Address', $invoiceAddress));
$InvoiceToAddress->appendChild($dom->createElement('Phone', $_InvoiceToAddress->getElementsByTagName('Phone')[0]->nodeValue));
$InvoiceToAddress->appendChild($dom->createElement('EmailAddress', $_InvoiceToAddress->getElementsByTagName('EmailAddress')[0]->nodeValue));

// Build item list
$ItemsList = $salesOrder->appendChild($dom->createElement('ItemsList'));
$_ItemDetails = $_dom->getElementsByTagName('ItemDetail');

// Loop through each item in a list and re-save it into new XML
foreach ($_ItemDetails as $_ItemDetail) {

    $ItemDetail = $ItemsList->appendChild($dom->createElement('ItemDetail'));

    $ItemDetail->appendChild($dom->createElement('Item', $_ItemDetail->getElementsByTagName('Item')[0]->nodeValue));
    $ItemDetail->appendChild($dom->createElement('UnitOfMeasure', $_ItemDetail->getElementsByTagName('UnitOfMeasure')[0]->nodeValue));
    $ItemDetail->appendChild($dom->createElement('Quantity', $_ItemDetail->getElementsByTagName('Quantity')[0]->nodeValue));
    $ItemDetail->appendChild($dom->createElement('Item_Description', $_ItemDetail->getElementsByTagName('Item_Description')[0]->nodeValue));
    $ItemDetail->appendChild($dom->createElement('LineNumber', $_ItemDetail->getElementsByTagName('LineNumber')[0]->nodeValue));
    $ItemDetail->appendChild($dom->createElement('LineComment', $_ItemDetail->getElementsByTagName('LineComment')[0]->nodeValue));
    $ItemDetail->appendChild($dom->createElement('Net', $_ItemDetail->getElementsByTagName('Net')[0]->nodeValue));
    $ItemDetail->appendChild($dom->createElement('NetPriceOverrideQualifier', $_ItemDetail->getElementsByTagName('NetPriceOverrideQualifier')[0]->nodeValue));
    $ItemDetail->appendChild($dom->createElement('List', $_ItemDetail->getElementsByTagName('List')[0]->nodeValue));
    $ItemDetail->appendChild($dom->createElement('ListPriceOverrideQualifier', $_ItemDetail->getElementsByTagName('ListPriceOverrideQualifier')[0]->nodeValue));
}

// Format & save new XML
$dom->formatOutput = true;
$dom->save('test.xml');
