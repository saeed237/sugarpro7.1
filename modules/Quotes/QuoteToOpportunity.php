<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

global $beanFiles;
Activity::disable();
$db = DBManagerFactory::getInstance();
global $app_strings, $app_list_strings;
if (!ACLController::checkAccess('Opportunities', 'edit', true)) {
    ACLController::displayNoAccess(true);
    sugar_cleanup(true);
}

function send_to_url($redirect_Url)
{
    echo "<script language=javascript>\n";
    echo "javascript:parent.SUGAR.App.router.navigate('$redirect_Url', {trigger: true});";
    echo "</script>\n";
}

// returns value of number of rows where the name already exists
function query_opportunity_subject_exists($subj)
{
    $db = DBManagerFactory::getInstance();

    $subject = $db->quoted($subj);
    $query = "select count(id) from opportunities where name = $subject and deleted = 0";
    return $db->getOne($query) > 0;
}

function generate_name_form(&$var)
{
    global $app_strings;
    $retval = "<br><br>
    <form method=POST action=index.php name=QuoteToOpportunity>
<table class=\"tabForm\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"50%\">
<tbody><tr><td>
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
    <tbody><tr>
        <td class=\"dataLabel\" nowrap=\"nowrap\">{$app_strings['LBL_OPPORTUNITY_NAME']}:&nbsp;&nbsp;<input size=\"20\" name=\"opportunity_subject\" class=\"dataField\" value=\"{$var["opportunity_subject"]}\" type=\"text\"></td>
        <td align=\"right\"><input name=\"action\" value=\"index\" type=\"hidden\" nowrap=\"nowrap\">
                <input type=\"hidden\" name=\"module\" value=\"Quotes\">
                <input type=\"hidden\" name=\"record\" value=\"{$var['record']}\">
                <input type=\"hidden\" name=\"team_id\" value=\"{$var['team_id']}\">
                <input type=\"hidden\" name=\"user_id\" value=\"{$var['user_id']}\">
                <input type=\"hidden\" name=\"user_name\" value=\"{$var['user_name']}\">
                <input type=\"hidden\" name=\"action\" value=\"QuoteToOpportunity\">
                <input type=\"hidden\" name=\"opportunity_name\" value=\"{$var['opportunity_name']}\">
                <input type=\"hidden\" name=\"opportunity_id\" value=\"{$var['opportunity_id']}\">
                <input type=\"hidden\" name=\"currency_id\" value=\"{$var['currency_id']}\">
                <input type=\"hidden\" name=\"amount\" value=\"{$var['amount']}\">
                <input type=\"hidden\" name=\"valid_until\" value=\"{$var['valid_until']}\">
        <input title=\"{$app_strings['LBL_SAVE_BUTTON_TITLE']}\" accesskey=\"{$app_strings['LBL_SAVE_BUTTON_KEY']}\" class=\"button\" name=\"button\" value=\"{$app_strings['LBL_SAVE_BUTTON_LABEL']}\" type=\"submit\"></form>
        </td>
        <td align=\"right\">
                <form method=POST action=index.php name=BackToQuote>
                <input type=\"hidden\" name=\"module\" value=\"Quotes\">
                <input type=\"hidden\" name=\"record\" value=\"{$var['record']}\">
                <input type=\"hidden\" name=\"action\" value=\"DetailView\">
                <input title=\"{$app_strings['LBL_CANCEL_BUTTON_TITLE']}\" accesskey=\"{$app_strings['LBL_CANCEL_BUTTON_KEY']}\" class=\"button\" name=\"button\" value=\"{$app_strings['LBL_CANCEL_BUTTON_LABEL']}\" type=\"submit\">
                </form>
          </td>
    </tr>
    </tbody></table>
</td></tr></tbody></table>";

    echo $retval;
}

/* @var $quote Quote */
$quote = BeanFactory::getBean('Quotes', $_REQUEST['record']);

if ($quote->getRelatedOpportunityCount() > 0) {
    global $app_strings;
    printf(
        "<span class=\"error\">%s</span>",
        $app_strings['ERR_QUOTE_CONVERTED']
    );
} elseif (empty($_REQUEST["opportunity_subject"])) {
    $LBLITUP = $app_strings['ERR_OPPORTUNITY_NAME_MISSING'];

    printf("<span class=\"error\">$LBLITUP</span>");
    generate_name_form($_REQUEST);
} elseif (query_opportunity_subject_exists($_REQUEST["opportunity_subject"]) > 0) {
    $LBLITUP = $app_strings['ERR_OPPORTUNITY_NAME_DUPE'];

    printf("<span class=\"error\">$LBLITUP</span>", $_REQUEST["opportunity_subject"]);
    generate_name_form($_REQUEST);
} else {

    /* @var $opp Opportunity */
    $opp = BeanFactory::getBean('Opportunities');
    $opp->id = create_guid();
    $opp->new_with_id = true;
    printf("%s<br><br>", $opp->id);
    $opp->assigned_user_id = $quote->assigned_user_id;
    $opp->date_closed = $quote->date_quote_expected_closed;
    $opp->name = $_REQUEST['opportunity_subject'];
    $opp->assigned_user_name = $quote->assigned_user_name;
    $opp->lead_source = isset($app_list_strings['lead_source_dom']['Self Generated']) ? 'Self Generated' : null; //'Self Generated';
    $opp->opportunity_type = isset($app_list_strings['opportunity_type_dom']['New Business']) ? $app_list_strings['opportunity_type_dom']['New Business'] : null; //'New Business';
    $opp->team_id = $quote->team_id;
    $opp->sales_stage = isset($app_list_strings['sales_stage_dom']['Proposal/Price Quote']) ? 'Proposal/Price Quote' : null; //'Proposal/Price Quote';
    $opp->probability = isset($app_list_strings['sales_probability_dom']['Proposal/Price Quote']) ? $app_list_strings['sales_probability_dom']['Proposal/Price Quote'] : null; //'Proposal/Price Quote';
    $opp->amount = $quote->total;
    $opp->quote_id = $quote->id;
    $opp->currency_id = $quote->currency_id;
    $opp->account_id = $quote->billing_account_id;
    $opp->save();

    // load the relationship up
    $opp->load_relationship('revenuelineitems');

    $products = $quote->get_linked_beans('products', 'Products');
    /* @var $product Product */
    foreach ($products as $product) {
        $rli = $product->convertToRevenueLineItem();
        $rli->date_closed = $quote->date_quote_expected_closed;
        $rli->sales_stage = isset($app_list_strings['sales_stage_dom']['Proposal/Price Quote']) ? 'Proposal/Price Quote' : null;
        $rli->probability = isset($rli->sales_stage) ? $app_list_strings['sales_probability_dom'][$rli->sales_stage] : 0;
        $rli->assigned_user_id = $quote->assigned_user_id;
        $rli->save();

        // save the RLI to the relationship
        $opp->revenuelineitems->add($rli);
    }

    //link quote contracts with the opportunity.
    $quote->load_relationship('contracts');
    $contracts = $quote->contracts->get();

    if (is_array($contracts)) {
        $opp->load_relationship('contracts');
        foreach ($contracts as $id) {
            $opp->contracts->add($id);
        }
    }

    // just run a save again just to make sure
    $opp->save();

    $redirect_Url = "Opportunities/" . $opp->id;
    send_to_url($redirect_Url);
}
