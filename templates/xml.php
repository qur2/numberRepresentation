<?php
$doc = new DOMDocument();
$root = $doc->createElement('result', $result);
$root->setAttribute('success', $success ? 1 : 0);
$doc->appendChild($root);
echo $doc->saveXML();
