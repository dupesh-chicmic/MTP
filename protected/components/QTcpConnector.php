<?php
/**
 * Description of QTcpConnector
 *
 * @author olek
 */
class QTcpConnector {
    const ERR_NONE=0;
    const ERR_SOCKET_OPEN=-1;
    const ERR_SEND=-2;
    public $EOM;
    private $tcpBufferSize=8192;
    private $address;
    private $port;
    private $buffer;
    private $socket;
    private $timeout;
    
    public function QTcpConnector($address, $port=80, $eom="\n", $timeout=30) {
        $this->address=$address;
        $this->port=$port;
        $this->timeout=$timeout;
        $this->EOM=$eom;
    }
    
    private function openSocket() {        
        return $this->socket=fsockopen($this->address, $this->port, $errno, $errstr, $this->timeout);
    }
    
    public function sendMessage($msg) {
        if(!$this->socket) {
            if(!$this->openSocket())
            {
                return self::ERR_SOCKET_OPEN;
            }
        }
     
        $bytesSend=0;
        if(($bytesSend=fwrite($this->socket, $msg))===false) {
            return self::ERR_SEND;
        }
        
        return $bytesSend;
    }

    public function recvMessage() {
        $msg='';
        while (!feof($this->socket)) {
            $msg .= fread($this->socket, $this->tcpBufferSize);
        }
        
        return $msg;
    }
    
    public function end() {
        fclose($this->socket);
    }
}

?>
