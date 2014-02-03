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

function set_campaignlog_and_save_background(popup_reply_data)
{
    var form_name = popup_reply_data.form_name;
    var name_to_value_array = popup_reply_data.name_to_value_array;
    var passthru_data = popup_reply_data.passthru_data;
    // construct the POST request
    var query_array =  new Array();
    if (name_to_value_array != 'undefined') {
        for (var the_key in name_to_value_array)
        {
            if(the_key == 'toJSON')
            {
                /* just ignore */
            }
            else
            {
                query_array.push(the_key+'='+name_to_value_array[the_key]);
            }
        }
    }
    //construct the muulti select list
    var selection_list;
     if(popup_reply_data.selection_list)
    {
        selection_list  = popup_reply_data.selection_list;
    }
    else
    {
        selection_list  = popup_reply_data.name_to_value_array;
    }

    if (selection_list != 'undefined') {
        for (var the_key in selection_list)
        {
            query_array.push('subpanel_id[]='+selection_list[the_key])
        }
    }
    var module = get_module_name();
    var id = get_record_id();

    query_array.push('value=DetailView');
    query_array.push('module='+module);    //query_array.push('module='+module);
    query_array.push('http_method=get');
    query_array.push('return_module='+module);
    query_array.push('return_id='+id);
    query_array.push('record='+id);
    query_array.push('isDuplicate=false');
    query_array.push('return_type=addcampaignlog');
    query_array.push('action=Save2');
    query_array.push('inline=1');

    var refresh_page = escape(passthru_data['refresh_page']);
    for (prop in passthru_data) {
        if (prop=='link_field_name') {
            query_array.push('subpanel_field_name='+escape(passthru_data[prop]));
        } else {
            if (prop=='module_name') {
                query_array.push('subpanel_module_name='+escape(passthru_data[prop]));
            } else {
                query_array.push(prop+'='+escape(passthru_data[prop]));
            }
        }
    }

    var query_string = query_array.join('&');
    request_map[request_id] = passthru_data['child_field'];
    var returnstuff = http_fetch_sync('index.php',query_string);
    request_id++;
    got_data(returnstuff, true);
    if(refresh_page == 1){
        document.location.reload(true);
    }
}
