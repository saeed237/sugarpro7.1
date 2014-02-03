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


SUGAR.inboundEmail = { };


Rot13 = {
    map: null,

    convert: function(a) {
        Rot13.init();

        var s = "";
        for (i=0; i < a.length; i++) {
            var b = a.charAt(i);
            s += ((b>='A' && b<='Z') || (b>='a' && b<='z') ? Rot13.map[b] : b);
        }
        return s;
    },

    init: function() {
        if (Rot13.map != null)
            return;

        var map = new Array();
        var s   = "abcdefghijklmnopqrstuvwxyz";

        for (i=0; i<s.length; i++)
            map[s.charAt(i)] = s.charAt((i+13)%26);
        for (i=0; i<s.length; i++)
            map[s.charAt(i).toUpperCase()] = s.charAt((i+13)%26).toUpperCase();

        Rot13.map = map;
    },

    write: function(a) {
        return Rot13.convert(a);
    }
}


function getEncryptedPassword(login, password, mailbox) {
	var words = new Array(login, password, mailbox);
	for(i=0; i<3; i++) {
		word = words[i];
		if(word.indexOf('&') > 0) {
			fragment1 = word.substr(0, word.indexOf('&'));
			fragment2 = word.substr(word.indexOf('&') + 1, word.length);

			newWord = fragment1 + '::amp::' + fragment2;
			words[i] = newWord;
			word = newWord; // setting it locally to pass on to next IF
			fragment1 = '';
			fragment2 = '';
		}
		if(word.indexOf('+') > 0) {
			fragment1 = word.substr(0, word.indexOf('+'));
			fragment2 = word.substr(word.indexOf('+') + 1, word.length);

			newWord = fragment1 + '::plus::' + fragment2;
			words[i] = newWord;
			word = newWord; // setting it locally to pass on to next IF
			fragment1 = '';
			fragment2 = '';
		}
		if(word.indexOf('%') > 0) {
			fragment1 = word.substr(0, word.indexOf('%'));
			fragment2 = word.substr(word.indexOf('%') + 1, word.length);

			newWord = fragment1 + '::percent::' + fragment2;
			words[i] = newWord;
			word = newWord; // setting it locally to pass on to next IF
			fragment1 = '';
			fragment2 = '';
		}
	} // for

	return words;
} // fn

function close_ie_test_popup() {
    SUGAR.inboundEmail.ie_test_popup_dialog.hide();
}

function ie_test_open_popup_with_submit(module_name, action, pageTarget, width, height, mail_server, protocol, port, login, password, mailbox, ssl, personal, formName, ie_id)
{
	if (!formName) formName = "testSettingsView";
	var words = getEncryptedPassword(login, password, mailbox);
	var isPersonal = (personal) ? 'true' : 'false';

	if (!isDataValid(formName, true)) {
		return;
	}

    if(typeof(ie_id) == 'undefined' || ie_id == '')
    	ie_id = (typeof document.getElementById(formName).ie_id != 'undefined') ? document.getElementById(formName).ie_id.value : '';

	// launch the popup
	URL = 'index.php?'
		+ 'module=' + module_name
		+ '&to_pdf=1'
		+ '&action=' + action
		+ '&target=' + pageTarget
		+ '&target1=' + pageTarget
		+ '&server_url=' + mail_server
		+ '&email_user=' + words[0]
		+ '&protocol=' + protocol
		+ '&port=' + port
		+ '&email_password=' + encodeURIComponent(words[1])
		+ '&mailbox=' + words[2]
		+ '&ssl=' + ssl
		+ '&ie_id=' + ie_id
		+ '&personal=' + isPersonal;

	var SI = SUGAR.inboundEmail;
	if (!SI.testDlg) {
		SI.testDlg = new YAHOO.widget.SimpleDialog("testSettingsDiv", {
	        width: width + "px",
	        draggable: true,
	        dragOnly: true,
	        close: true,
	        constraintoviewport: true,
			modal: true,
			loadingText: SUGAR.language.get("app_strings", "LBL_EMAIL_LOADING")
	    });
		SI.testDlg._updateContent = function (o) {
	        var w = this.cfg.config.width.value + "px";
	        this.setBody(o.responseText);
	        if (this.evalJS)
	          SUGAR.util.evalScript(o.responseText);
	        if (!SUGAR.isIE)
	            this.body.style.width = w

            SUGAR.inboundEmail.ie_test_popup_dialog = this;
            window.setTimeout(function(){close_ie_test_popup()},3000);
	    }
	}
	var title = SUGAR.language.get('Emails', 'LBL_TEST_SETTINGS');
	if (typeof(title) == "undefined" || title == "undefined")
	   title = SUGAR.language.get('InboundEmail', 'LBL_TEST_SETTINGS');
	SI.testDlg.setHeader(title);
	SI.testDlg.setBody(SUGAR.language.get("app_strings", "LBL_EMAIL_LOADING"));

    SI.testDlg.render(document.body);
	var Connect = YAHOO.util.Connect;
	if (Connect.url) URL = Connect.url + "&" +  url;
    Connect.asyncRequest("GET", URL, {success:SI.testDlg._updateContent, failure:SI.testDlg.hide, scope:SI.testDlg});
    SI.testDlg.show();

}

function isDataValid(formName, validateMonitoredFolder) {
	var formObject = document.getElementById(formName);
    var errors = new Array();
    var out = new String();

    if(trim(formObject.server_url.value) == "") {
        errors.push(SUGAR.language.get('app_strings', 'LBL_EMAIL_ERROR_SERVER'));
    }
    if(trim(formObject.email_user.value) == "") {
        errors.push(SUGAR.language.get('app_strings', 'LBL_EMAIL_ERROR_USER'));
    }
    if(formObject.protocol.protocol == "") {
        errors.push(SUGAR.language.get('app_strings', 'LBL_EMAIL_ERROR_PROTOCOL'));
    }
    if (formObject.protocol.value == 'imap' && validateMonitoredFolder) {
    	if (trim(formObject.mailbox.value) == "") {
    		errors.push(SUGAR.language.get('app_strings', 'LBL_EMAIL_ERROR_MONITORED_FOLDER'));
    	} // if
    }
    if(formObject.port.value == "") {
        errors.push(SUGAR.language.get('app_strings', 'LBL_EMAIL_ERROR_PORT'));
    }

    if(errors.length > 0) {
        out = SUGAR.language.get('app_strings', 'LBL_EMAIL_ERROR_DESC');
        for(i=0; i<errors.length; i++) {
            if(out != "") {
                out += "\n";
            }
            out += errors[i];
        }

        alert(out);
        return false;
    } else {
        return true;
    }

} // fn

function getFoldersListForInboundAccount(module_name, action, pageTarget, width, height, mail_server, protocol, port, login, password, mailbox, ssl, personal, searchFieldValue, formName) {
	if (!formName) formName = "testSettingsView";

	var words = getEncryptedPassword(login, password, mailbox);
	var isPersonal = (personal) ? 'true' : 'false';

	// launch the popup
	URL = 'index.php?'
        + 'module=' + module_name
        + '&to_pdf=1'
        + '&action=' + action
        + '&target=' + pageTarget
        + '&target1=' + pageTarget
        + '&server_url=' + mail_server
        + '&email_user=' + words[0]
        + '&protocol=' + protocol
        + '&port=' + port
        + '&email_password=' + encodeURIComponent(words[1])
        + '&mailbox=' + words[2]
        + '&ssl=' + ssl
        + '&personal=' + isPersonal
		+ '&searchField='+ searchFieldValue;

	var SI = SUGAR.inboundEmail;
    if (!SI.listDlg) {
        SI.listDlg = new YAHOO.widget.SimpleDialog("selectFoldersDiv", {
            width: width + "px",
            draggable: true,
            dragOnly: true,
            close: true,
            constraintoviewport: true,
            modal: true,
            loadingText: SUGAR.language.get("app_strings", "LBL_EMAIL_LOADING")
        });
        SI.listDlg._updateContent = function (o) {
            var w = this.cfg.config.width.value + "px";
            this.setBody(o.responseText);
            SUGAR.util.evalScript(o.responseText);
            if (!SUGAR.isIE)
                this.body.style.width = w
        }
    }
    SI.listDlg.setHeader(SUGAR.language.get("app_strings", "LBL_EMAIL_LOADING"));
    SI.listDlg.setBody('');

    SI.listDlg.render(document.body);
    var Connect = YAHOO.util.Connect;
    if (Connect.url) URL = Connect.url + "&" +  url;
    Connect.asyncRequest("GET", URL, {success:SI.listDlg._updateContent, failure:SI.listDlg.hide, scope:SI.listDlg});
    SI.listDlg.show();

} // fn

function setPortDefault() {
	var prot	= document.getElementById('protocol');
	var ssl		= document.getElementById('ssl');
	var port	= document.getElementById('port');
	var stdPorts= new Array("110", "143", "993", "995");
	var stdBool	= new Boolean(false);

	if(port.value == '') {
		stdBool.value = true;
	} else {
		for(i=0; i<stdPorts.length; i++) {
			if(stdPorts[i] == port.value) {
				stdBool.value = true;
			}
		}
	}

	if(stdBool.value == true) {
		if(prot.value == 'imap' && ssl.checked == false) { // IMAP
			port.value = "143";
		} else if(prot.value == 'imap' && ssl.checked == true) { // IMAP-SSL
			port.value = '993';
		} else if(prot.value == 'pop3' && ssl.checked == false) { // POP3
			port.value = '110';
		} else if(prot.value == 'pop3' && ssl.checked == true) { // POP3-SSL
			port.value = '995';
		}
	}
}

function toggle_monitored_folder(field) {

	var field1=document.getElementById('protocol');
	//var target=document.getElementById('pop3_warn');
	//var mark_read = document.getElementById('mark_read');
	var mailbox = document.getElementById('mailbox');
	//var inbox = document.getElementById('inbox');
	var label_inbox = document.getElementById('label_inbox');
	var subscribeFolderButton = document.getElementById('subscribeFolderButton');
	var trashFolderRow = document.getElementById('trashFolderRow');
	var trashFolderRow1 = document.getElementById('trashFolderRow1');
	var sentFolderRow = document.getElementById('sentFolderRow');

	if (field1.value == 'imap') {
		//target.style.display="none";
		mailbox.disabled=false;
        // This is not supported in IE
        try {
          mailbox.style.display = '';
		  trashFolderRow.style.display = '';
		  sentFolderRow.style.display = '';
		  trashFolderRow1.style.display = '';
		  //mailbox.type='text';
          subscribeFolderButton.style.display = '';
        } catch(e) {};
		//inbox.style.display='';
		label_inbox.style.display='';
	}
	else {
		//target.style.display="";
		mailbox.value = "INBOX";
        mailbox.disabled=false; // cannot disable, else the value is not passed
        // This is not supported in IE
        try {
		  mailbox.style.display = "none";
          trashFolderRow.style.display = "none";
		  sentFolderRow.style.display = "none";
		  trashFolderRow1.style.display = "none";
          subscribeFolderButton.style.display = "none";

		  //mailbox.type='hidden';
        } catch(e) {};

		//inbox.style.display = "";
		label_inbox.style.display = "none";
	}
}
