<?php

/**
 * This class is used to deal with GitHub
 */
class GitHub_Tools {   
    
    /**
     * Fetched config from .git config
     *
     * @var array 
     */
    private $config = [];
    
    /**
     * Constructor
     * 
     * @param string $git_path
     */
    public function __construct($git_path = '.') {
        $this->config = parse_ini_file($git_path . '/.git/config', true);
                
        if (isset($this->config['remote origin']['url'])) {
            $o = strpos($this->config['remote origin']['url'], 'https://github.com/');
            $l = strlen('https://github.com/');
            if ($o === false) {
                $o = strpos($this->config['remote origin']['url'], '@github.com:');
                $l = strlen('@github.com:');
            }
            $m = strpos($this->config['remote origin']['url'], '/', $o + $l);
            $this->config['remote origin']['owner'] = substr($this->config['remote origin']['url'], $o + $l, $m - $o - $l);
            $i = strpos($this->config['remote origin']['url'], '.git', $m);
            $this->config['remote origin']['repo'] = substr($this->config['remote origin']['url'], $m + 1, $i - $m - 1);
        }        
    }
    
    /**
     * checks if it is a git repo
     * 
     * @return bool
     */
    public function isGitHubRepo() {
        return isset($this->config['remote origin']['url']) && 
               strpos($this->config['remote origin']['url'], 'github.com') !== false;
    }    
    
    public function makeApiUrl($url_template) {        
        $replace_what = array_map(function ($key) {
            return ':' . $key;
        }, array_keys($this->config['remote origin']));
        $replace_with = array_values($this->config['remote origin']);
        return 'https://api.github.com' . str_replace($replace_what, $replace_with, $url_template);
    }
    
    /**
     * creates ticket on github
     * 
     * @param string $login
     * @param string $pass
     * @param string $title
     * @param string $body
     * 
     * @return array
     */
    public function createTicket($login, $pass, $title, $body = '') {        
        global $config;
        $ch = curl_init();
        
        $headers = [];
        $params = [
            CURLOPT_URL => $this->makeApiUrl("/repos/:owner/:repo/issues"),
            CURLOPT_HEADERFUNCTION => function ($curl, $line) use (&$headers) {
                if (trim($line) !== '') {
                    $parts = explode(':', trim($line), 2);
                    $headers[$parts[0]] = isset($parts[1])?trim($parts[1]):null;
                }
                return strlen($line);
            },
            CURLOPT_POSTFIELDS => json_encode(compact('title', 'body')),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => $this->config['remote origin']['owner'],
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CONNECTTIMEOUT => 1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $login . ':' . $pass
        ];
        curl_setopt_array($ch, $params);            
        $server_output = curl_exec ($ch);        
        
        curl_close ($ch);
        
        return json_decode($server_output, true);
    }
    
}