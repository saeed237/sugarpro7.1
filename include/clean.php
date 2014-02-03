<?php
/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
 ********************************************************************************/


require_once 'vendor/HTMLPurifier/HTMLPurifier.standalone.php';

/**
 * cid: scheme implementation
 */
class HTMLPurifier_URIScheme_cid extends HTMLPurifier_URIScheme
{
    public $browsable = true;
    public $may_omit_host = true;

    public function doValidate(&$uri, $config, $context) {
        $uri->userinfo = null;
        $uri->port     = null;
        $uri->host     = null;
        $uri->query    = null;
        $uri->fragment = null;
        return true;
    }

}

class HTMLPurifier_Filter_Xmp extends HTMLPurifier_Filter
{

    public $name = 'Xmp';

    public function preFilter($html, $config, $context)
    {
        return preg_replace("#<(/)?xmp>#i", "<\\1pre>", $html);
    }
}

class SugarCleaner
{
    /**
     * Singleton instance
     * @var SugarCleaner
     */
    static public $instance;

    /**
     * HTMLPurifier instance
     * @var HTMLPurifier
     */
    protected $purifier;

    function __construct()
    {
        global $sugar_config;
        $config = HTMLPurifier_Config::createDefault();

        if(!is_dir(sugar_cached("htmlclean"))) {
            create_cache_directory("htmlclean/");
        }
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
        $config->set('Core.Encoding', 'UTF-8');
        $hidden_tags = array('script' => true, 'style' => true, 'title' => true, 'head' => true);
        $config->set('Core.HiddenElements', $hidden_tags);
        $config->set('Cache.SerializerPath', sugar_cached("htmlclean"));
        $config->set('URI.Base', $sugar_config['site_url']);
        $config->set('CSS.Proprietary', true);
        $config->set('HTML.TidyLevel', 'light');
        $config->set('HTML.ForbiddenElements', array('body' => true, 'html' => true));
        $config->set('AutoFormat.RemoveEmpty', false);
        $config->set('Cache.SerializerPermissions', 0775);
        // for style
        //$config->set('Filter.ExtractStyleBlocks', true);
        $config->set('Filter.ExtractStyleBlocks.TidyImpl', false); // can't use csstidy, GPL
        if(!empty($GLOBALS['sugar_config']['html_allow_objects'])) {
            // for object
            $config->set('HTML.SafeObject', true);
            // for embed
            $config->set('HTML.SafeEmbed', true);
        }
        $config->set('Output.FlashCompat', true);
        // for iframe and xmp
        $config->set('Filter.Custom',  array(new HTMLPurifier_Filter_Xmp()));
        // for link
        $config->set('HTML.DefinitionID', 'Sugar HTML Def');
        $config->set('HTML.DefinitionRev', 2);
        $config->set('Cache.SerializerPath', sugar_cached('htmlclean/'));
        // IDs are namespaced
        $config->set('Attr.EnableID', true);
        $config->set('Attr.IDPrefix', 'sugar_text_');

        if ($def = $config->maybeGetRawHTMLDefinition()) {
            $form = $def->addElement(
      			'link',   // name
      			'Flow',  // content set
      			'Empty', // allowed children
      			'Core', // attribute collection
                 array( // attributes
            		'href*' => 'URI',
            		'rel' => 'Enum#stylesheet', // only stylesheets supported here
            		'type' => 'Enum#text/css' // only CSS supported here
    			)
            );
            $iframe = $def->addElement(
      			'iframe',   // name
      			'Flow',  // content set
      			'Optional: #PCDATA | Flow | Block', // allowed children
      			'Core', // attribute collection
                 array( // attributes
            		'src*' => 'URI',
                    'frameborder' => 'Enum#0,1',
                    'marginwidth' =>  'Pixels',
                    'marginheight' =>  'Pixels',
                    'scrolling' => 'Enum#|yes,no,auto',
                 	'align' => 'Enum#top,middle,bottom,left,right,center',
                    'height' => 'Length',
                    'width' => 'Length',
                 )
            );
            $iframe->excludes=array('iframe');
        }
        $uri = $config->getDefinition('URI');
        $uri->addFilter(new SugarURIFilter(), $config);
        HTMLPurifier_URISchemeRegistry::instance()->register('cid', new HTMLPurifier_URIScheme_cid());

        $this->purifier = new HTMLPurifier($config);
    }

    /**
     * Get cleaner instance
     * @return SugarCleaner
     */
    public static function getInstance()
    {
        if(is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Clean string from potential XSS problems
     * @param string $html
     * @param bool $encoded Was it entity-encoded?
     * @return string
     */
    static public function cleanHtml($html, $encoded = false)
    {
        if(empty($html)) return $html;

        if($encoded) {
            $html = from_html($html);
        }
        if(!preg_match('<[^-A-Za-z0-9 `~!@#$%^&*()_=+{}\[\];:\'",./\\?\r\n|\x80-\xFF]>', $html)) {
            /* if it only has "safe" chars, don't bother */
            $cleanhtml = $html;
        } else {
            $purifier = self::getInstance()->purifier;
            $cleanhtml = $purifier->purify($html);
//            $styles = $purifier->context->get('StyleBlocks');
//            if(count($styles) > 0) {
//                $cleanhtml = "<style>".join("</style><style>", $styles)."</style>".$cleanhtml;
//            }
        }
        if($encoded) {
            $cleanhtml = to_html($cleanhtml);
        }
        return $cleanhtml;
    }

    static public function stripTags($string, $encoded = true)
    {
        if($encoded) {
            $string = from_html($string);
        }
        $string = filter_var($string, FILTER_SANITIZE_STRIPPED, FILTER_FLAG_NO_ENCODE_QUOTES);
        return $encoded?to_html($string):$string;
    }
}

/**
 * URI filter for HTMLPurifier
 * Approves only resource URIs that are in the list of trusted domains
 * Until we have comprehensive CSRF protection, we need to sanitize URLs in emails, etc.
 * to avoid CSRF attacks.
 */
class SugarURIFilter extends HTMLPurifier_URIFilter
{
    public $name = 'SugarURIFilter';
//    public $post = true;
    protected $allowed = array();

    public function prepare($config)
    {
        global $sugar_config;
        if(!empty($sugar_config['security_trusted_domains']) && is_array($sugar_config['security_trusted_domains']))
        {
            $this->allowed = $sugar_config['security_trusted_domains'];
        }
        /* Allow this host?
        $def = $config->getDefinition('URI');
        if(!empty($def->base) && !empty($this->base->host)) {
            $this->allowed[] = $def->base->host;
        }
        */
    }

    public function filter(&$uri, $config, $context)
    {
        // skip non-resource URIs
        if (!$context->get('EmbeddedURI', true)) return true;

        //if(empty($this->allowed)) return false;

        if(!empty($uri->scheme) && strtolower($uri->scheme) != 'http' && strtolower($uri->scheme) != 'https') {
	        // do not touch non-HTTP URLs
	        return true;
	    }

    	// relative URLs permitted since email templates use it
		// if(empty($uri->host)) return false;
	    // allow URLs with no query
		if(empty($uri->query)) return true;

		// allow URLs for known good hosts
		foreach($this->allowed as $allow) {
            // must be equal to our domain or subdomain of our domain
            if($uri->host == $allow || substr($uri->host, -(strlen($allow)+1)) == ".$allow") {
                return true;
            }
        }

        // Here we try to block URLs that may be used for nasty XSRF stuff by
        // referring back to Sugar URLs
        // allow URLs that don't start with /? or /index.php?
		if(!empty($uri->path) && $uri->path != '/') {
		    $lpath = strtolower($uri->path);
		    if(substr($lpath, -10) != '/index.php' && $lpath != 'index.php') {
    			return true;
	    	}
		}

        $query_items = array();
		parse_str(from_html($uri->query), $query_items);
	    // weird query, probably harmless
		if(empty($query_items)) return true;
    	// suspiciously like SugarCRM query, reject
		if(!empty($query_items['module']) && !empty($query_items['action'])) return false;
    	// looks like non-download entry point - allow only specific entry points
		if(!empty($query_items['entryPoint']) && !in_array($query_items['entryPoint'], array('download', 'image', 'getImage'))) {
			return false;
		}

		return true;
    }
}
