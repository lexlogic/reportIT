<?php

class Parser {

    public $nmapArray = array();

    public function nmapParse($url) {
        $printOpen = true;
        $printClosed = true;
        $printFiltered = true;
        $xmlObject = simplexml_load_file($url);

        foreach($xmlObject as $host => $value) {
            if ((string) $host == "host") {
                $nmap["ports"] = array();
                $address = (string) $value->address["addr"];
                $this->nmapArray[$address] = array();

                if(!empty($value->ports->port)) {
                    foreach ($value->ports->port as $port) {
                        if (  ( ((string) $port->state["state"] == "filtered")	and	($printFiltered)) or
                            ( ((string) $port->state["state"] == "closed")	and	($printClosed)) or
                            ( ((string) $port->state["state"] == "open")	and	($printOpen))
                        ) {
                            $this->nmapArray[$address][] = array(
                                (string)$port["portid"] => array(
                                    "Protocol" => (string)$port["protocol"],
                                    "State" => (string)$port->state["state"],
                                    "Reason" => (string)$port->state["reason"],
                                    "Name" => (string)$port->service["name"],
                                    "Product" => (string)$port->service["product"],
                                    "Version" => (string)$port->service["version"]
                                ));
                        }
                    }
                }
            }
        }
    }

    public function nmap(){
        return $this->nmapArray;
    }
}