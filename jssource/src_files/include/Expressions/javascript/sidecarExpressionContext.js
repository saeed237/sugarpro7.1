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



(function() {

SUGAR.forms = SUGAR.forms || {};
SUGAR.forms.animation = SUGAR.forms.animation || {};

/**
 * An expression context is used to retrieve variables when evaluating expressions.
 * the default class only returns the empty string.
 */
var SE = SUGAR.expressions,
    SEC = SE.SidecarExpressionContext = function(view){
    this.view = view;

}
SUGAR.util.extend(SEC, SE.ExpressionContext, {
    getValue : function(varname)
    {
        var value = this.view.context.get("model").get(varname),
            def =   this.view.context.get("model").fields[varname],
            result;

        //Relate fields are only string on the client side, so return the variable name back.
        if(def.type == "link")
            value = varname;

        if (typeof(value) == "string")
        {
            value = value.replace(/\n/g, "");
            if ((/^(\s*)$/).exec(value) != null || value === "")
            {
                result = SEC.parser.toConstant('""');
            }
            // test if value is a number or boolean
            else if ( SE.isNumeric(value) ) {
                result = SEC.parser.toConstant(SE.unFormatNumber(value));
            }
            // assume string
            else {
                result =  SEC.parser.toConstant('"' + value + '"');
            }
        } else if (typeof(value) == "object" && value != null && value.getTime) {
            //This is probably a date object that we must convert to an expression
            var d = new SE.DateExpression("");
            d.evaluate = function(){return this.value};
            d.value = value;
            result =  d;
        } else if (typeof(value) == "number") {
            //Cast to a string before send to toConstant.
            result =  SEC.parser.toConstant("" + value);
        } else {
            result = SEC.parser.toConstant('""');
        }

        return result;

    },
    setValue : function(varname, value)
    {
        this.lockedFields = this.lockedFields || [];
        if (!this.lockedFields[varname])
        {
            this.lockedFields[varname] = true;
            var el = this.getElement(varname);
            if (el) {
                SUGAR.forms.FlashField($(el).parents('[data-fieldname="' + varname + '"]'), null, varname);
            }
            var ret = this.view.context.get("model").set(varname, value);
            this.lockedFields = [];
            return  ret;
        }
    },
    addListener : function(varname, callback, scope)
    {
        var model = this.view.context.get("model");
        model.off("change:" + varname, callback, scope);
        model.on("change:" + varname, callback, scope);
    },
    getElement : function(varname) {
        var field = this.view.getField(varname);
        if (field && field.el)
            return field.el;
    },
    addClass : function(varname, css_class, includeLabel){
        var def = this.view.getFieldMeta(varname),
            props = includeLabel ? ["css_class", "cell_css"] : ["css_class"],
            el = this.getElement(varname),
            parent = $(el).closest('div.record-cell');

        _.each(props, function(prop) {
            if (!def[prop]) {
                def[prop] = css_class;
            } else if (def[prop].indexOf(css_class) == -1){
                def[prop] += " " + css_class;
            }
        });
        this.view.setFieldMeta(varname, def);

        $(el).addClass(css_class);
        if (includeLabel && parent) {
            parent.addClass(css_class);
        }

    },
    removeClass : function(varname, css_class, includeLabel) {
        var def = this.view.getFieldMeta(varname),
            field = this.view.getField(varname),
            props = includeLabel ? ["css_class", "cell_css"] : ["css_class"],
            el = this.getElement(varname),
            parent = $(el).closest('div.record-cell');

        //Remove it from both the field objects def and the view metadata
        _.each([field.def, def], function(d) {
            _.each(props, function(prop) {
                if (d[prop] && d[prop].indexOf(css_class) != -1) {
                    d[prop] = $.trim((" " + d[prop] + " ").replace(new RegExp(' ' + css_class + ' '), ""));
                }
            });
        });
        this.view.setFieldMeta(varname, def);

        $(el).removeClass(css_class);
        if (includeLabel && parent) {
            parent.removeClass(css_class);
            parent.find("." + css_class).removeClass(css_class);

        }
    },
    setFieldDisabled : function(variable, disable) {
        var set = disable !== false, //default disable to true
            field = this.view.getField(variable);
        if (field) {
            field.setDisabled(set);
        }
    },
    getLink : function(variable) {
        var model = this.view.context.get("model");
        if (model && model.fields && model.fields[variable])
            return model.fields[variable];
    },

    showError : function(variable, error)
    {
    	//TODO
    },
    clearError : function(variable)
    {
    	//TODO
    },
    setStyle : function(variable, styles)
    {
    	//TODO
    },
    setRelatedFields : function(fields){
        var model = this.view.context.get("model");
        for (var link in fields)
        {
            var currValue = model.get(link),
                forceChangeEvent = !!currValue, //Force the change event if the model already had an object for the link
                value = currValue || {};
            _.each(fields[link], function(values, type) {
                value[type] = _.extend(value[type] || {}, values);
            });
        }
        model.set(link, value);
        if (forceChangeEvent)
            model.trigger("change:" + link);
    },
    getRelatedFieldValues : function(fields, module, record)
    {
        var self = this,
            api = App.api;
        if (fields.length > 0){
            module = module || this.view.context.get("module");
            record = record || this.view.context.get("model").get("id");
            for (var i = 0; i < fields.length; i++)
            {
                //Related fields require a current related id
                if (fields[i].type == "related")
                {
                    var linkDef = SUGAR.forms.AssignmentHandler.getLink(fields[i].link);
                    if (linkDef && linkDef.id_name && linkDef.module) {
                        var idField = document.getElementById(linkDef.id_name);
                        if (idField && idField.tagName == "INPUT")
                        {
                            fields[i].relId = SUGAR.forms.AssignmentHandler.getValue(linkDef.id_name, false, true);
                            fields[i].relModule = linkDef.module;
                        }
                    }
                }
            }
            var data = {id: record, action:"related"},
                params = {module: module, fields: JSON.stringify(fields)};
                api.call("read", api.buildURL("ExpressionEngine", "related", data, params), data, params, {
                    success: function(resp){
                        self.setRelatedFields(resp);
                        return resp;
                }});
        }
        return null;
    },
    getRelatedField : function(link, ftype, field){
        var linkDef = _.extend({}, this.getLink(link)),
            linkValues = this.view.model.get(link) || {},
            currId;

        //Do not attempt to load related values of a new record
        if (!this.view.model.get("id")) {
            return "";
        }

        if (ftype == "related"){
            return this._handleRelateExpression(link, field);
        }
        //Run server side ajax Call
        else {
            if (typeof(linkValues[ftype]) == "undefined" || typeof(linkValues[ftype][field]) == "undefined")
            {
                var params = {link: link, type: ftype};
                if (field)
                    params.relate = field;
                this.getRelatedFieldValues([params]);
            } else {
                return linkValues[ftype][field];
            }
        }

        if (typeof(linkValues[ftype]) == "undefined")
            return "";

        return linkValues[ftype];

    },
    _handleRelateExpression : function(link, field){
        var relContext = this.view.context.getChildContext({link:link});
        //Prepares instances of related model and collection.
        relContext.prepare();
        var col = relContext.get("collection"),
            fields = relContext.get('fields') || [],
            self = this,
            //First check if there is a relate field availible before loading a rel context.
            rField = _.find(this.view.model.fields, function(def){
                return (def.type && def.type == "relate" && def.id_name && def.link && def.link == link)
            });

        //Now check if a relate field for this link cahnged since we last loaded this value
        if (rField &&
            (this.view.model.get(rField.id_name) == "" ||
                (relContext.get("model") && relContext.get("model").get("id") != this.view.model.get(rField.id_name))
            )) {
            //Nuke the context info now since its no longer valid
            fields = [];
            relContext.set({fields:fields, model:null});
            //We are using a relate field but its empty for now, so abort.
            if (this.view.model.get(rField.id_name) == "")
                return "";
        }

        if (field && !_.contains(fields, field)) {
            fields.push(field);
            this._loadRelatedData(link, fields, relContext, rField);
        }
        else if (rField && relContext.get("model")) {
            return relContext.get("model").get(field);
        }
        else if (context.isDataFetched() && col.page > 0) {
            if (col.length > 0) {
                return  col.models[0].get(field);
            }
        } else {
            // This link is currently being loaded (with the field we need). Collection's don't fire a sync/fetch event,
            // so we need to use doWhen to known when the load is complete.
            // We will fire the link change event once the load is complete to re-fire the dependency with the correct data.
            SUGAR.App.utils.doWhen(function(){return col.page > 0}, function(){
                self.view.model.trigger("change:" + link);
            });
        }
        return "";
    },
    //Helper function to trigger the actual load call of related data
    _loadRelatedData : function(link, fields, relContext, rField) {
        var self = this;
        if (rField && this.view.model.get(rField.id_name)){
            //If we are using a relate field rather than a full link
            var modelId = this.view.model.get(rField.id_name),
                model =  relContext.get("model")
                     || SUGAR.App.data.createRelatedBean(this.view.model, this.view.model.get(rField.id_name), link);
            relContext.set({
                modelId:modelId,
                model : model
            });
        } else {
            //If we don't have a record id, we can't make a server call for anything so abort at this point
            if (_.isEmpty(this.view.model.get("id")))
                return "" ;
        }

        relContext.prepare();
        //Call set in case fields was not already on the context
        relContext.set({
            'fields' : fields,
            //Force skipFetch false if this context had the data we wanted, we wouldn't be here.
            skipFetch : false
        });
        if (relContext.isDataFetched()){
            relContext.resetLoadFlag();
        }

        //don't use the link api if we are forcing an id pulled from a field on the current model.
        if (rField) relContext.attributes.link = null;
        relContext.loadData({success:function(){
            // We will fire the link change event once the load is complete to re-fire the dependency with the correct data.
            self.view.model.trigger("change:" + link);
        }});
        if (rField) relContext.attributes.link = link;

    },
    fireOnLoad : function(dep) {
        //Disable fire on load for now as we no longer have edit vs detail views and
        //this is just costing us performance.
        //this.view.model.once("change", SUGAR.forms.Trigger.fire, dep.trigger);
    },
    getAppListStrings : function(list) {
        return SUGAR.App.lang.getAppListStrings(list);
    },
    parseDate: function(date, type) {
        return SUGAR.App.date.parse(date);
    }
});

/**
 * @STATIC
 * The Default expression parser.
 */
SEC.parser = new SUGAR.expressions.ExpressionParser();

/**
 * @STATIC
 * Parses expressions given a variable map.<br>
 */
SEC.evalVariableExpression = function(expression, view)
{
	return SEC.parser.evaluate(expression, new SEC(view));
}

/**
 * A dependency is an object representation of a variable being dependent
 * on other variables. For example A being the sum of B and C where A is
 * 'dependent' on B and C.
 */
SUGAR.forms.Dependency = function(trigger, actions, falseActions, testOnLoad, context)
{
    this.actions = actions;
	this.falseActions = falseActions;
	this.context = context;
    this.testOnLoad = testOnLoad;
    trigger.setContext(this.context);
    trigger.setDependency(this);
	this.trigger = trigger;
	if (testOnLoad) {
	    context.fireOnLoad(this);
	}

}

    /**
     *  Creates a Dependency from the given metadata.
     *
     * @static
     * @param meta {object} metadata that defines this dependency
     * @param context {ExpressionContext} to attach to this dependency
     * @return Dependency object created from metadata
     */
SUGAR.forms.Dependency.fromMeta = function(meta, context){
    var condition = meta.trigger || "true",
        triggerFields = meta.triggerFields || SEC.parser.getFieldsFromExpression(condition),
        actions = meta.actions || [],
        falseActions = meta.notActions || [],
        onLoad = meta.onload || false,
        actionObjects = [],
        falseActionObjects = [];

    //Without any trigger fields (or a condition with variables), we can't create a trigger
    if (_.isEmpty(triggerFields))
        return null;
    //No actions means no reason to create a dependency
    if (_.isEmpty(actions) && _.isEmpty(falseActions))
        return null;


    _.each(actions, function(actionDef)
    {
        if (!actionDef.action || !SUGAR.forms[actionDef.action + "Action"])
            return;
        actionObjects.push(new SUGAR.forms[actionDef.action + "Action"](actionDef.params));
    });
    _.each(falseActions, function(actionDef)
    {
        if (!actionDef.action || !SUGAR.forms[actionDef.action + "Action"])
            return;
        falseActionObjects.push(new SUGAR.forms[actionDef.action + "Action"](actionDef.params));
    });

    return new SUGAR.forms.Dependency(
        new SUGAR.forms.Trigger(triggerFields, condition, context),
        actionObjects, falseActionObjects, onLoad, context
    );
}


/**
 * Triggers this dependency to be re-evaluated again.
 */
SUGAR.forms.Dependency.prototype.fire = function(undo)
{
	try {
        var model = this.context.view.context.get("model");
        this.lastTriggeredActions = this.lastTriggeredActions || [];

		//Do not trigger dependencies on models that haven't changed and aren't set to fire on load.
        if (model.inSync && !this.testOnLoad) {
            return;
        }

        var actions = this.actions;
		if (undo && this.falseActions != null)
			actions = this.falseActions;

        //Clean up any render listeners for out of date actions when a dependency is triggered multiple times
        _.each(this.lastTriggeredActions, function(action) {
            this.context.view.off(null, null, action);
        }, this);

        if (actions instanceof SUGAR.forms.AbstractAction)
            actions = [actions];

        for (var i in actions) {
            var action = actions[i];
            if (typeof action.exec == "function") {
                action.setContext(this.context);
                action.exec();
                if (this.testOnLoad && action.afterRender) {
                    this.context.view.on('render', action.exec, action);
                }
            }
        }

        this.lastTriggeredActions = actions;

	} catch (e) {
		if (!SUGAR.isIE && console && console.log){
			console.log('ERROR: ' + e);
		}
		return;
	}
};

SUGAR.forms.Dependency.prototype.getRelatedFields = function() {
    var parser = SEC.parser,
        fields = parser.getRelatedFieldsFromFormula(this.trigger.condition);
    //parse will search a list of actions for formulas with relate fields
    var parse = function (actions) {
        if (actions instanceof SUGAR.forms.AbstractAction) {
            actions = [actions];
        }
        for (var i in actions) {
            var action = actions[i];
            //Iterate over all the properties of the action to see if they are formulas with relate fields
            if (typeof action.exec == "function") {
                for (var p in action) {
                    if (typeof action[p] == "string")
                        fields = $.merge(fields, parser.getRelatedFieldsFromFormula(action[p]));
                }
            }
        }
    }
    parse(this.actions);
    parse(this.falseActions);
    return fields;
}


    SUGAR.forms.AbstractAction = function (target) {
        this.target = target;
    };

    SUGAR.forms.AbstractAction.prototype.exec = function () {

    }

    SUGAR.forms.AbstractAction.prototype.setContext = function (context) {
        this.context = context;
    }

    SUGAR.forms.AbstractAction.prototype.evalExpression = function (exp, context) {
        context = context || this.context;
        return SEC.parser.evaluate(exp, context).evaluate();
    }

    /**
     * This object resembles a trigger where a change in any of the specified
     * variables triggers the dependencies to be re-evaluated again.
     */
    SUGAR.forms.Trigger = function (variables, condition, context) {
        this.variables = variables;
        this.condition = condition;
        this.context = context;
        this.dependency = { };
        this._attachListeners();
    }

    /**
     * Attaches a 'change' listener to all the fields that cause
     * the condition to be re-evaluated again.
     */
    SUGAR.forms.Trigger.prototype._attachListeners = function () {
        if (!(this.variables instanceof Array)) {
            this.variables = [this.variables];
        }

        for (var i = 0; i < this.variables.length; i++) {
            this.context.addListener(this.variables[i], SUGAR.forms.Trigger.fire, this, true);
        }
    }

    /**
     * Attaches a 'change' listener to all the fields that cause
     * the condition to be re-evaluated again.
     */
    SUGAR.forms.Trigger.prototype.setDependency = function (dep) {
        this.dependency = dep;
    }

    SUGAR.forms.Trigger.prototype.setContext = function (context) {
        this.context = context;
    }

    /**
     * @STATIC
     * This is the function that is called when a 'change' event
     * is triggered. If the condition is true, then it triggers
     * all the dependencies.
     */
    SUGAR.forms.Trigger.fire = function () {
        // eval the condition
        var eval, val;
        try {
            eval = SEC.parser.evaluate(this.condition, this.context);
        } catch (e) {
            if (!SUGAR.isIE && console && console.log) {
                console.log('ERROR:' + e + "; in Condition: " + this.condition);
            }
        }

        // evaluate the result
        if (typeof(eval) != 'undefined')
            val = eval.evaluate();

        // if the condition is met
        if (val == SUGAR.expressions.Expression.TRUE) {
            // single dependency
            if (this.dependency instanceof SUGAR.forms.Dependency) {
                this.dependency.fire(false);
                return;
            }
        } else if (val == SUGAR.expressions.Expression.FALSE) {
            // single dependency
            if (this.dependency instanceof SUGAR.forms.Dependency) {
                this.dependency.fire(true);
                return;
            }
        }
    }

    SUGAR.forms.flashInProgress = {};
    /**
     * @STATIC
     * Animates a field when by changing it's background color to
     * a shade of light red and back.
     */
    SUGAR.forms.FlashField = function (field, to_color, key) {
        if (typeof(field) == 'undefined' || (!key && !field.id))
            return;
        key = key || field.id;
        if (SUGAR.forms.flashInProgress[key])
            return;

        SUGAR.forms.flashInProgress[key] = true;

        to_color = to_color || '#FF8F8F';
        // store the original background color but default to white
        var original = field.style && field.style.backgroundColor ? field.style.backgroundColor : '#FFFFFF' ;


        $(field).animate({
            backgroundColor : to_color
        }, 200, function(){
            $(field).animate({
                backgroundColor : original
            }, 200, function(){
                delete SUGAR.forms.flashInProgress[key];
            });
        });
    };

    //Register SugarLogic as a plugin to sidecar.
    if (SUGAR.App && SUGAR.App.plugins) {
        SUGAR.App.plugins.register('SugarLogic', 'view', {
            onAttach: function() {
                this.on("init", function(){
                    this.deps = [];
                    var slContext = new SUGAR.expressions.SidecarExpressionContext(this),
                        meta = _.extend({}, this.meta, this.options.meta);

                    _.each(meta.dependencies, function(dep) {
                        var newDep = SUGAR.forms.Dependency.fromMeta(dep, slContext);
                        if (newDep) {
                            this.deps.push(newDep);
                            if (this.context.isCreate()) {
                                SUGAR.forms.Trigger.fire.apply(newDep.trigger);
                            }
                        }
                    }, this);
                });
           }
       });
    } else if (console.error) {
        console.error("unable to find the plugin manager");
    }


})();
