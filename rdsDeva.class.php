<?php
/**
 * Classe qui gère les interactions avec le codeur RDS SmartGen Mini de chez Deva
 * @author: Fabien Schenkels <f@bien.be>
 */

class RdsDeva
{
    
    private $_host;
    private $_login;
    private $_password;
    private $_url;
    private $_timeout = 4;
    
    private $_PI_RDS;
    private $_PTY_RDS;
    private $_PS;
    private $_PTYN;
    private $_TA;
    private $_TA_Timeout;
    private $_TP;
    private $_DI_MS;
    private $_DI_AH;
    private $_DI_COMP;
    private $_DI_S_PTY;
    private $_MS;
    private $_RT;
    private $_RT_AB;
    private $_DPS_ON;
    private $_PARSE;
    private $_DPS;
    private $_AF_List;
    private $_Site;
    private $_GSEQ;
    private $_CAPS;
    
    
    
    
    /**
     * 
     * Set
     */
    public function setHost($host) { $this->_host = $host; }
    public function setLogin($login) { $this->_login = $login; }
    public function setPassword($password) { $this->_password = $password; }
    public function setUrl($url) { $this->_url = $url; }
    public function setPI_RDS($PI_RDS) { $this->_PI_RDS = $PI_RDS; }
    public function setPTY_RDS($PTY_RDS) { $this->_PTY_RDS = $PTY_RDS; }
    public function setPS($PS) { $this->_PS = $PS; }
    public function setPTYN($PTYN) { $this->_PTYN = $PTYN; }
    public function setTA($TA) { $this->_TA = $TA; }
    public function setTA_Timeout($TA_Timeout) { $this->_TA_Timeout = $TA_Timeout; }
    public function setTP($TP) { $this->_TP = $TP; }
    public function setDI_MS($DI_MS) { $this->_DI_MS = $DI_MS; }
    public function setDI_AH($DI_AH) { $this->_DI_AH = $DI_AH; }
    public function setDI_COMP($DI_COMP) { $this->_DI_COMP = $DI_COMP; }
    public function setDI_S_PTY($DI_S_PTY) { $this->_DI_S_PTY = $DI_S_PTY; }
    public function setMS($MS) { $this->_MS = $MS; }
    public function setRT($RT) {
        
        $replaceFrom = array('Λ', 'Ø', 'ó', 'ø', 'Ç', 'é', 'è', 'ë');
        $replaceTo =   array('&', 'O', 'o', 'o', 'C', 'e', 'e', 'e');
        
        $RT = str_replace($replaceFrom, $replaceTo, $RT);
        
        $this->_RT = $RT;
        
    }
    public function setRT_AB($RT_AB) { $this->_RT_AB = $RT_AB; }
    public function setDPS_ON($DPS_ON) { $this->_DPS_ON = $DPS_ON; }
    public function setPARSE($PARSE) { $this->_PARSE = $PARSE; }
    public function setDPS($DPS) { $this->_DPS = $DPS; }
    public function setAF_List($AF_List) { $this->_AF_List = $AF_List; }
    public function setSite($Site) { $this->_Site = $Site; }
    public function setGSEQ($GSEQ) { $this->_GSEQ = $GSEQ; }
    public function setCAPS($CAPS) { $this->_CAPS = $CAPS; }

    
    
    /**
     * 
     * Get
     */
    public function host() { return $this->_host; }
    public function login() { return $this->_login; }
    public function password() { return $this->_password; }
    public function url() { return $this->_url; }
    public function PI_RDS() { return $this->_PI_RDS; }
    public function PTY_RDS() { return $this->_PTY_RDS; }
    public function PS() { return $this->_PS; }
    public function PTYN() { return $this->_PTYN; }
    public function TA() { return $this->_TA; }
    public function TA_Timeout() { return $this->_TA_Timeout; }
    public function TP() { return $this->_TP; }
    public function DI_MS() { return $this->_DI_MS; }
    public function DI_AH() { return $this->_DI_AH; }
    public function DI_COMP() { return $this->_DI_COMP; }
    public function DI_S_PTY() { return $this->_DI_S_PTY; }
    public function MS() { return $this->_MS; }
    public function RT() { return $this->_RT; }
    public function RT_AB() { return $this->_RT_AB; }
    public function DPS_ON() { return $this->_DPS_ON; }
    public function PARSE() { return $this->_PARSE; }
    public function DPS() { return $this->_DPS; }
    public function AF_List() { return $this->_AF_List; }
    public function Site() { return $this->_Site; }
    public function GSEQ() { return $this->_GSEQ; }
    public function CAPS() { return $this->_CAPS; }
    
    
    
    
    /**
    * Constructeur
    * @param $host string
    * @param $login string
    * @param $password string
    * @return void
    */
    public function __construct($host, $login, $password) {
        $this->setHost($host);
        $this->setLogin($login);
        $this->setPassword($password);
        
        $this->setUrl('http://'.$this->host().'/index.htm');
    }
    
    
    
    /**
    * Méthode permettant de récupérer les informations actuelles du codeur RDS
    * @return bool
    */
    public function get() {
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url(),
            CURLOPT_RETURNTRANSFER => True,
            CURLOPT_ENCODING => 'UTF-8',
            CURLOPT_MAXREDIRS => 0,
            CURLOPT_TIMEOUT => $this->_timeout,
            CURLOPT_USERPWD => $this->login().':'.$this->password()
        ));

        $response = curl_exec($curl);
        
        if(curl_errno($curl)) {
            return curl_error($curl);
        }

        curl_close($curl);

            if(preg_match_all('/id="_(.+)" name="_(.+)" value="(.+)"/', $response, $matches)) {

            $getRDS = array_combine($matches[2], $matches[3]);

            $this->setPI_RDS($getRDS['pi']);
            $this->setPTY_RDS($getRDS['pty']);
            $this->setPS($getRDS['ps']);
            $this->setPTYN($getRDS['ptyn']);
            $this->setTA($getRDS['ta']);
            $this->setTA_Timeout(''); // $getRDS['tatout']
            $this->setTP($getRDS['tp']);
            $this->setDI_MS($getRDS['dims']);
            $this->setDI_AH($getRDS['diah']);
            $this->setDI_COMP($getRDS['dico']);
            $this->setDI_S_PTY($getRDS['disp']);
            $this->setMS($getRDS['ms']);
            $this->setRT($getRDS['rt']);
            $this->setRT_AB('');
            $this->setDPS_ON($getRDS['dpson']);
            $this->setPARSE($getRDS['parse']);
            $this->setDPS($getRDS['dps']);
            $this->setAF_List($getRDS['af']);
            $this->setSite($getRDS['site']);
            $this->setGSEQ($getRDS['gseq']);
            $this->setCAPS(''); // $getRDS['caps']

            return True;
        }
        
    }
    
    
    
    /**
    * Méthode permettant de créer le POST qui sera envoyé au codeur RDS
    * @return array
    */
    public function createPost() {
        
        if(!$this->PI_RDS()) {
            return False;
        }
        
        $post = array(
            'PI_RDS' => $this->PI_RDS(),
            'PTY_RDS' => $this->PTY_RDS(),
            'PS' => $this->PS(),
            'PTYN' => $this->PTYN(),
            'TA' => $this->TA(),
            'TA_Timeout' => $this->TA_Timeout(),
            'TP' => $this->TP(),
            'DI_MS' => $this->DI_MS(),
            'DI_AH' => $this->DI_AH(),
            'DI_COMP' => $this->DI_COMP(),
            'DI_S_PTY' => $this->DI_S_PTY(),
            'MS' => $this->MS(),
            'RT' => $this->RT(),
            'RT_AB' => $this->RT_AB(),
            'DPS_ON' => $this->DPS_ON(),
            'PARSE' => $this->PARSE(),
            'DPS' => $this->DPS(),
            'AF_List' => $this->AF_List(),
            'Site' => $this->Site(),
            'GSEQ' => $this->GSEQ(),
            'CAPS' => $this->CAPS(),
            'SaveBtn' => 'Save'
        );
        
        return $post;
        
    }
    
    
    
    
    /**
    * Méthode permettant d'envoyer les données au codeur RDS
    * @return bool
    */
    public function send() {
        
        $post = $this->createPost();
        
        if(!$post) {
            return False;
        }
        
        $toPost = http_build_query($post);
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url(),
            CURLOPT_RETURNTRANSFER => True,
            CURLOPT_ENCODING => 'UTF-8',
            CURLOPT_MAXREDIRS => 0,
            CURLOPT_TIMEOUT => $this->_timeout,
            CURLOPT_USERPWD => $this->login().':'.$this->password(),
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $toPost,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        ));

        curl_exec($curl);
        
        if(curl_errno($curl)) {
            $return = curl_error($curl);
        }else{
            $return = True;
        }
        
        curl_close($curl);
        
        return $return;
        
    }
    
 
}
