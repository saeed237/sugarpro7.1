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

var wizard = function() {
    var wizard,
        step,
        wizardId,
        headerText,
        navMenu,
        defaults,
        o;

    defaults = {
        'width': 800,
        'startText'	:	"Start",
        'finishText':	"Done",
        'cancelText':	"Cancel",
        'backText':		"Back",
        'nextText':		"Next",
        'className': '',
        // str 'tabs', 'breadcrumbs'
        'navigationType': 'tabs',
        'header': function() {
            return '<div class="modal-header">' +
                ' <a class="close" data-dismiss="modal">×</a>' +
                '<h3>'+headerText+'</h3>' +
                '</div>';
        },
        'footer': function() {
            return '<div class="modal-footer">' +
                '<a href="#" class="btn btn-invisible btn-link pull-left cancel">'+ o.cancelText+'</a>' +
                '<a class="btn back" href="#">'+ o.backText+'</a>' +
                '<a class="btn btn-primary next" href="#">'+ o.nextText+'</a>' +
                '<a class="btn btn-primary finish" href="#">'+ o.finishText+'</a>' +
                '<a class="btn btn-primary start" href="#">'+ o.startText+'</a>' +
                '</div>';
        },
        'navigation': function() {
            var content = '<div class="navigation" style="display: none; width: '+ o.width+'px;"><ul class="nav ';
            if(o.navigationType == "breadcrumbs") {
                content += 'breadcrumb two';
                console.log(navMenu.length)
                var innerCrumbs = navMenu.length - 2;
                var breadCrumbWidth = ((o.width-(16+(16*innerCrumbs)))) /  navMenu.length;
            } else {
               content += 'nav-tabs';
            }
            content += '">';


            for (var i=0;i<navMenu.length;i++) {
                var screenId = i+2;
                content += '<li ';
                if(i==0) {
                    content += 'class="active"';
                }
                content += '><a href="" class="navigation'+screenId+'"';
                if(o.navigationType == "breadcrumbs") {
                    content += "style='width: "+breadCrumbWidth+"px'"
                }
                content += '><div>'+navMenu[i]+'</div></a></li>';
            }

            content += '</ul>' + '</div>';

            return content;
        }
    };

    function centerModal() {
        $(wizardId).css("left",$(window).width()/2 - $(wizardId).width()/2);
        $(wizardId).css("margin-top",-$(wizardId).height()/2);
    }

    return {
        init: function(params) {
            step = 1;
            wizardId = "#"+params.id;
            navMenu = params.navMenu;
            headerText = params.headerText;
            o = $.extend( defaults, params.defaults );


            if(params.onWizardStart)
                params.onWizardStart();
            //wire up buttons
            $(wizardId + ' .start').live("click", function(){
                step = 2;

                $(wizardId + " .screen1").css("display","none");
                $(wizardId + " .navigation").css("display","block");

                $(wizardId + " .back").css("display","none");
                $(wizardId + " .next").css("display","inline-block");
                $(wizardId + " .finish").css("display","none");
                $(wizardId + " .start").css("display","none");

                $(wizardId + " .screen2").css("display","block");
            });

            $(wizardId + " .finish").live("click", function(){
                $(wizardId).modal('hide');
            });

            $(wizardId + " .cancel").live("click",function(){
                $(wizardId).modal('hide');
            });

            $(wizardId + " .next, " + wizardId + " .back").live("click", function(){
                $(wizardId + " .screen" + step).css("display","none");
                $(wizardId + " .navigation"+step).parent().removeClass("active");
                step += ($(this).hasClass('next')) ? 1 : -1;
                $(wizardId + " .screen" + step).css("display","block");
                $(wizardId + " .navigation"+step).parent().addClass("active");
                centerModal();
                if (step == 2)
                {
                    $(wizardId + ' .back').css("display","none");
                    $(wizardId + ' .next').css("display","inline-block");
                    $(wizardId + ' .finish').css("display","none");
                } else if( step == $(wizardId + " .screen").length ) {
                    $(wizardId + ' .back').css("display","inline-block");
                    $(wizardId + ' .next').css("display","none");
                    $(wizardId + ' .finish').css("display","inline-block");
                } else {
                    $(wizardId + ' .back').css("display","inline-block");
                    $(wizardId + ' .next').css("display","inline-block");
                    $(wizardId + ' .finish').css("display","none");
                }
            });

            if($(wizardId).length !== 0) {
                $(wizardId).remove();
            }

            $('body').append('<div id="'+params.id+'" class="wizard modal '+o.className+'"></div>');
            wizard = $('#'+params.id).modal({backdrop: true});


            $.ajax({
                url: params.modalUrl,
                success: function(data){
                    $(wizardId)
                        .append(o.header())
                        .append('<div class="modal-body"></div>');

                    $(wizardId + ' .modal-body')
                        .append(o.navigation())
                        .append(data)
                        .append(o.footer());

                    $(wizardId).width(o.width);
                    //  $(tourIdSel+ " .modal-body").height(400);
                    $(wizardId + " .screen1").css("display","block");
                    var navSelector = wizardId + " .nav a";

                    centerModal();

                    $(window).resize(function() {
                        centerModal();
                    });


                    //wireup breadcrumb elements
                    $(navSelector).each(function(index){
                        $(this).click(function(e){
                            var breadcrumb = index+2;
                            e.preventDefault();
                            $(wizardId + " .screen" + breadcrumb).css("display","inline");
                            $(this).parent().addClass("active");
                            $(navSelector).each(function(otherIndex){
                                if(otherIndex != index) {
                                    $(this).parent().removeClass("active");
                                    $(wizardId + " .screen" + (otherIndex+2)).css("display","none");
                                }
                            });
                            step = breadcrumb;
                            var numScreens = $(".screen").length;
                            if (step == 2)
                            {
                                $(wizardId + ' .back').css("display","none");
                                $(wizardId + ' .next').css("display","inline-block");
                                $(wizardId + ' .finish').css("display","none");
                            } else if( step == numScreens ) {
                                $(wizardId + ' .back').css("display","inline-block");
                                $(wizardId + ' .next').css("display","none");
                                $(wizardId + ' .finish').css("display","inline");
                            } else {
                                $(wizardId + ' .back').css("display","inline-block");
                                $(wizardId + ' .next').css("display","inline-block");
                                $(wizardId + ' .finish').css("display","none");
                            }
                        });
                    });
                }
            });



        }
    };

}();