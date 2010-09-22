<?php

/*******************************************************************************
 * Sailthru API PHP5 Client for Musicnation - Blank
 *******************************************************************************
 *
 * A simple client library to remotely access the Sailthru REST API.
 *
 * NOTE: This custom library was downloaded by Practice from sailthru.com
 * on 09/22/2010. It contains the API key and shared-secret specific to Musicnation - Blank.
 * For your own security, this information should not be shared. If you choose
 * to redistribute this code, as permitted by the license, please remove this
 * private information.
 *
 *******************************************************************************
 *
 * Copyright (c) 2007 Sailthru, Inc.
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR
 * IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
 * OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
 * NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
 * THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 ******************************************************************************/

class Sailthru_Client {
    private $api_uri = 'http://api.sailthru.com';
    private $api_key = '8a10b15924a09e0957e249236974feb0'; // specific to Musicnation - Blank
    private $secret  = 'df31c7bcdcb734f485e960399e41cb61'; // specific to Musicnation - Blank
    private $version = '1.0';
    
    /**
     * Instantiate a new client; constructor optionally takes overrides for key/secret/uri.
     *
     * @param string $api_key
     * @param string $secret
     * @param string $api_uri
     * @return Sailthru_Client
     */
    public function __construct($api_key = false, $secret = false, $api_uri = false) {
        if ($api_uri) { $this->api_uri = $api_uri; }
        if ($api_key) { $this->api_key = $api_key; }
        if ($secret)  { $this->secret = $secret;   }
    }
    
    /**
     * Remotely send an email template to a single email address.
     *
     * If you pass the $schedule_time parameter, the send will be scheduled for a future time.
     * 
     * Options:
     *   replyto: override Reply-To header
     *   test: send as test email (subject line will be marked, will not count towards stats)
     *
     * @param string $template_name
     * @param string $email
     * @param array $vars
     * @param array $options
     * @param string $schedule_time
     * @return array
     */
    public function send($template_name, $email, $vars = array(), $options = array(), $schedule_time = null) {
        $post['template'] = $template_name;
        $post['email'] = $email;
        $post['vars'] = $vars;
        $post['options'] = $options;
        if ($schedule_time) {
            $post['schedule_time'] = $schedule_time;
        }
        $result = $this->apiPost('send', $post);
        return $result;
    }
    
    /**
     * Remotely send an email template to multiple email addresses.
     *
     * Use the evars parameter to set replacement vars for a particular email address.
     *
     * @param string $template_name
     * @param array $emails
     * @param array $vars
     * @param array $evars
     * @param array $options
     * @return array
     */
    public function multisend($template_name, $emails, $vars = array(), $evars = array(), $options = array()) {
        $post['template'] = $template_name;
        $post['email'] = is_array($emails) ? implode(',', $emails) : $emails;
        $post['vars'] = $vars;
        $post['evars'] = $evars;
        $post['options'] = $options;
        $result = $this->apiPost('send', $post);
        return $result;
    }
    
    /**
     * Get the status of a send.
     *
     * @param string $send_id
     * @return array
     */
    public function getSend($send_id) {
        return $this->apiGet('send', array('send_id' => $send_id));
    }
    
    /**
     * Cancel a send that was scheduled for a future time.
     *
     * @param string $send_id
     * @return array
     */
    public function cancelSend($send_id) {
        return $this->apiPost('send', array('send_id' => $send_id), 'DELETE');
    }
    
    /**
     * Return information about an email address, including replacement vars and lists.
     *
     * @param string $email
     * @return array
     */
    public function getEmail($email) {
        return $this->apiGet('email', array('email' => $email));
    }
    
    /**
     * Set replacement vars and/or list subscriptions for an email address.
     * 
     * $lists should be an assoc array mapping list name => 1 for subscribed, 0 for unsubscribed
     *
     * @param string $email
     * @param array $vars
     * @param array $lists
     * @param array $templates
     * @return array
     */
    public function setEmail($email, $vars = array(), $lists = array(), $templates = array()) {
        $data = array('email' => $email);
        if ($vars) {
            $data['vars'] = $vars;
        }
        if ($lists) {
            $data['lists'] = $lists;
        }
        if ($templates) {
            $data['templates'] = $templates;
        }
        return $this->apiPost('email', $data);
    }
    
    /**
     * Get information on a previously scheduled email blast
     *
     * @param integer $blast_id
     * @return array
     */
    public function getBlast($blast_id) {
        return $this->apiGet('blast', array('blast_id' => $blast_id));
    }
    
    /**
     * Schedule a mass mail blast
     *
     * @param string $name
     * @param string $list
     * @param string $schedule_time
     * @param string $from_name
     * @param string $from_email
     * @param string $subject
     * @param string $content_html
     * @param string $content_text
     * @param array $options
     * @return array
     */
    public function scheduleBlast($name, $list, $schedule_time, $from_name, $from_email, $subject, $content_html, $content_text, $options = array()) {
        $data['name'] = $name;
        $data['list'] = $list;
        $data['schedule_time'] = $schedule_time;
        $data['from_name'] = $from_name;
        $data['from_email'] = $from_email;
        $data['subject'] = $subject;
        $data['content_html'] = $content_html;
        $data['content_text'] = $content_text;
        $data = array_merge($data, $options);
        return $this->apiPost('blast', $data);
    }
    
    /**
     * Fetch email contacts from an address book at one of the major email providers (aol/gmail/hotmail/yahoo)
     * 
     * Use the third, optional parameter if you want to return the names of the contacts along with their emails
     *
     * @param string $email
     * @param string $password
     * @param boolean $include_names
     * @return array
     */
    public function importContacts($email, $password, $include_names = false) {
        $data = array(
            'email' => $email,
            'password' => $password,
        );
        if ($include_names) {
            $data['names'] = 1;
        }
        return $this->apiPost('contacts', $data);
    }
    
    /**
     * Get a template.
     *
     * @param string $template_name
     * @return array
     */
    function getTemplate($template_name) {
        return $this->apiGet('template', array('template' => $template_name));
    }
    
    /**
     * Save a template.
     *
     * @param string $template_name
     * @param array $template_fields
     * @return array
     */
    public function saveTemplate($template_name, $template_fields) {
        $data = $template_fields;
        $data['template'] = $template_name;
        $result = $this->apiPost('template', $data);
        return $result;
    }
    
    /**
     * Returns true if the incoming request is an authenticated verify post.
     *
     * @return boolean
     */
    public function receiveVerifyPost() {
        $params = $_POST;
        foreach (array('action', 'email', 'send_id', 'sig') as $k) {
            if (!isset($params[$k])) {
                return false;
            }
        }
        
        if ($params['action'] != 'verify') {
            return false;
        }
        $sig = $params['sig'];
        unset($params['sig']);
        if ($sig != self::getSignatureHash($params, $this->secret)) {
            return false;
        }
        $send = $this->getSend($params['send_id']);
        if (!isset($send['email'])) {
            return false;
        }
        if ($send['email'] != $params['email']) {
            return false;
        }
        return true;
    }
    
    public function receiveOptoutPost() {
        $params = $_POST;
        foreach (array('action', 'email', 'sig') as $k) {
            if (!isset($params[$k])) {
                return false;
            }
        }
        
        if ($params['action'] != 'optout') {
            return false;
        }
        $sig = $params['sig'];
        unset($params['sig']);
        if ($sig != self::getSignatureHash($params, $this->secret)) {
            return false;
        }
        return true;
    }
    
    public function setHorizonCookie($email, $domain = null, $duration = null, $secure = false) {
        $data = $this->apiGet('horizon', array('email' => $email, 'hid_only' => 1));
        if (!isset($data['hid'])) {
            return false;
        }
        if (!$domain) {
            $domain_parts = explode('.', $_SERVER['HTTP_HOST']);
            $domain = $domain_parts[sizeof($domain_parts)-2] . '.' . $domain_parts[sizeof($domain_parts)-1];
        }
        if ($duration === null) {
            $expire = time() + 31556926;
        } else if ($duration) {
            $expire = time() + $duration;
        } else {
            $expire = 0;
        }
        setcookie('sailthru_hid', $data['hid'], $expire, '/', $domain, $secure);
    }
    
    /**
     * Perform an API GET request, using the shared-secret auth hash.
     *
     * @param string $action
     * @param array $data
     * @return array
     */
    public function apiGet($action, $data) {
        $data['api_key'] = $this->api_key;
        $data['format'] = isset($data['format']) ? $data['format'] : 'php';
        $data['sig'] = self::getSignatureHash($data, $this->secret);
        $result = $this->httpRequest("$this->api_uri/$action", $data, 'GET');
        $unserialized = @unserialize($result);
        return $unserialized ? $unserialized : $result;
    }
    
    /**
     * Perform an API POST (or other) request, using the shared-secret auth hash.
     *
     * @param array $data
     * @return array
     */
    public function apiPost($action, $data, $method = 'POST') {
        $data['api_key'] = $this->api_key;
        $data['format'] = isset($data['format']) ? $data['format'] : 'php';
        $data['sig'] = self::getSignatureHash($data, $this->secret);
        $result = $this->httpRequest("$this->api_uri/$action", $data, $method);
        $unserialized = @unserialize($result);
        return $unserialized ? $unserialized : $result;
    }
    
    /**
     * Perform an HTTP request, checking for curl extension support 
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return string
     */
    public function httpRequest($url, $data, $method = 'POST') {
        if (function_exists('curl_init')) {
            return $this->httpRequestCurl($url, $data, $method);
        } else {
            return $this->httpRequestWithoutCurl($url, $data, $method);
        }
    }
    
    /**
     * Perform an HTTP request using the curl extension 
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return string
     */
    public function httpRequestCurl($url, $data, $method = 'POST') {
        $ch = curl_init();
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
        } else {
            $url .= '?' . http_build_query($data, '', '&');
            if ($method != 'GET') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        if (!$data) {
            throw new Sailthru_Client_Exception("Bad response received from $url");
        }
        return $data;
    }
    
    /**
     * Adapted from: http://netevil.org/blog/2006/nov/http-post-from-php-without-curl 
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return string
     */
    public function httpRequestWithoutCurl($url, $data, $method = 'POST') {
        $params = array('http' => array('method' => $method));
        if ($method == 'POST') {
            $params['http']['content'] = is_array($data) ? http_build_query($data, '', '&') : $data;
        } else {
            $url .= '?' . http_build_query($data, '', '&');
        }
        $params['http']['header'] = "User-Agent: Sailthru API PHP5 Client $this->version " . phpversion() . "\nContent-Type: application/x-www-form-urlencoded";
        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if (!$fp) {
            throw new Sailthru_Client_Exception("Unable to open stream: $url");
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            throw new Sailthru_Client_Exception("No response received from stream: $url");
        }
        return $response;
    }
    
    /**
     * Extracts the values of a set of parameters, recursing into nested assoc arrays.
     *
     * @param array $params
     * @param array $values
     */
    public static function extractParamValues($params, &$values) {
        foreach ($params as $k => $v) {
            if (is_array($v) || is_object($v)) {
                self::extractParamValues($v, $values);
            } else {
                $values[] = $v;
            }
        }
    }
    
    /**
     * Returns the unhashed signature string (secret + sorted list of param values) for an API call.
     * 
     * Note that the SORT_STRING option sorts case-insensitive.
     *
     * @param array $params
     * @param string $secret
     * @return string
     */
    public static function getSignatureString($params, $secret) {
        $values = array();
        self::extractParamValues($params, $values);
        sort($values, SORT_STRING);
        $string = $secret . implode('', $values);
        return $string;
    }
    
    /**
     * Returns an MD5 hash of the signature string for an API call.
     * 
     * This hash should be passed as the 'sig' value with any API request.
     *
     * @param array $params
     * @param string $secret
     * @return string
     */
    public static function getSignatureHash($params, $secret) {
        return md5(self::getSignatureString($params, $secret));
    }
    
    
}

class Sailthru_Client_Exception extends Exception {
    
}