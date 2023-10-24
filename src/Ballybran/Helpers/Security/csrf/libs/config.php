<?php
/**
 * Configuration file for CSRF Protector
 * Necessary configurations are (library would throw exception otherwise)
 * ---- failedAuthAction
 * ---- jsUrl
 * ---- tokenLength
 */
return array(
    "CSRFP_TOKEN" => MY_CSRFP_TOKEN ?? "",
	"failedAuthAction" => array(
		"GET" => GET_METHOD ?? 0,
		"POST" => POST_METHOD ?? 0),
	"errorRedirectionPage" => errorRedirectionPage ?? "",
	"customErrorMessage" => customErrorMessage ?? "",
	"jsUrl" =>  jsUrl ? URL.jsUrl : URL."public/js/csrfprotector.js",
	"tokenLength" => tokenLength ?? 10,
	"cookieConfig" => array(
		"path" => cookie_path ?? "",
		"domain" => cookie_domain ?? "",
		"secure" => cookie_secure ?? false,
		"expire" => cookie_expire ?? 30,
	),
	"disabledJavascriptMessage" => "This site attempts to protect users against <a href=\"https://www.owasp.org/index.php/Cross-Site_Request_Forgery_%28CSRF%29\">
	Cross-Site Request Forgeries </a> attacks. In order to do so, you must have JavaScript enabled in your web browser otherwise this site will fail to work correctly for you.
	 See details of your web browser for how to enable JavaScript.",
	"verifyGetFor" => array()
);