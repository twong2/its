<?php
    include_once 'include/init.php'; //session started

    //this will be the link to this page
    $loginPage = getCASLoginPage();
    //this will be a link to the page you want to go to after this page is done
    if (!empty($_SESSION['tackback'])) {
        $startPage = $_SESSION['tackback'];
        unset($_SESSION['tackback']);
    } else {
     $startPage = getWebService();
        if (!empty($_REQUEST['section'])) {
            $startPage .= '?section=' . $_REQUEST['section'];
        } // END if (!empty($_REQUEST['section']))
    } // END if ($_SESSION['tackback'])

    //$ticket will be set depending on what method it is set by post or get
    if(isset($_REQUEST['ticket'])) {
            $ticket = $_REQUEST['ticket'];
    } // END if(isset($_REQUEST['ticket']))

    //just if ticket has a value then do these statements
    if (!empty($ticket)) {
    $data =
    '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
      <SOAP-ENV:Header/>
      <SOAP-ENV:Body>
        <samlp:Request xmlns:samlp="urn:oasis:names:tc:SAML:1.0:protocol" MajorVersion="1"
          MinorVersion="1" RequestID="' . $_SERVER['REMOTE_ADDR'] . '.' . time() . '"
          IssueInstant="' . date('Y-m-d\TG:i:s.uT') . '">
          <samlp:AssertionArtifact>
            ' . $ticket . '
          </samlp:AssertionArtifact>
        </samlp:Request>
      </SOAP-ENV:Body>
    </SOAP-ENV:Envelope>';

            //this is the address to the service that will make sure your ticket is valid
            $request = getCASServer() . "/cas/samlValidate?TARGET=$startPage";

            $ch = curl_init ();
            curl_setopt ($ch, CURLOPT_URL, $request);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, getVerifyPeer());
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, getVerifyHost());
            // make sure it return response
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml", "Content-length: " . strlen($data)));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $soapResponse = curl_exec( $ch );

            $doc = new DOMDocument();
            $doc->loadXML($soapResponse);
            $statusCodeNode = $doc->getElementsByTagName('StatusCode');
            $statusCode = $statusCodeNode->item(0)->getAttribute('Value');
            if ($statusCode == 'samlp:Success') {
                    $attributes = $doc->getElementsByTagName('Attribute');
                    foreach ($attributes as $node) {
                            $nodeValue = $node->getElementsByTagName('AttributeValue');
                            $_SESSION[$node->getAttribute('AttributeName')] = trim($nodeValue->item(0)->nodeValue);
                            for ($i = 1; $i < $nodeValue->length; $i++) {
                                    if (!empty($nodeValue->item($i)->nodeValue)) {
                                            $_SESSION[$node->getAttribute('AttributeName')] .= ',' . trim($nodeValue->item($i)->nodeValue);
                                    } // END if (!empty($nodeValue->item($i)->nodeValue))
                            } // END for ($i = 1; $i < 11; $i++)
                    } // END foreach ($attributes as $node)
                    $_SESSION['username'] = strtolower($_SESSION['uid']);
                    $_SESSION['uhuuid'] = strtolower($_SESSION['uhUuid']);
                    $_SESSION['name'] = $_SESSION['cn'];
                    $_SESSION['dept'] = $_SESSION['eduPersonAffiliation'];
            } else {
                    //if the ticket is not okay then it will kill the session
                    unset($_SESSION['username']);
                    unset($_SESSION['uid']);
                    unset($_SESSION['eduPersonAffiliation']);
                    unset($_SESSION['sn']);
                    unset($_SESSION['eduPersonOrgDN']);
                    unset($_SESSION['uhUuid']);
                    unset($_SESSION['cn']);
                    unset($_SESSION['uhOrgAffiliation']);
                    unset($_SESSION['givenName']);
                    $_SESSION = array();
                    session_destroy();
                    $startPage = getWebService() . '?section=noauth';
            } // END if ($statusCode == 'samlp:Success')
    } // END if (!empty($ticket))

    //then return you to start page
    header('Location: ' . $startPage);
    exit;
?>