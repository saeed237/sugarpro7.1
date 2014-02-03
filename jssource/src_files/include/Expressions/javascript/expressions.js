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

/**
 * The current namespaces.
 */
if ( typeof(SUGAR) == 'undefined' ) SUGAR = {};
if ( typeof(SUGAR.util) == 'undefined' ) SUGAR.util = {};
if ( typeof(SUGAR.expressions) == 'undefined' ) SUGAR.expressions= {};

SUGAR.util.extend = SUGAR.util.extend || (SUGAR.App ? SUGAR.App.utils.extendFrom : null);

/**
 * Constructs an Expression object given the parameters.
 */
SUGAR.expressions.Expression = function(context) {
    this.context = context;
};


/**
 * Designates an infinite number of parameters.
 */
SUGAR.expressions.Expression.INFINITY = -1;

/**
 * The various types supported by Expression.
 */
SUGAR.expressions.Expression.STRING_TYPE   	= "string";
SUGAR.expressions.Expression.NUMERIC_TYPE  	= "number";
SUGAR.expressions.Expression.DATE_TYPE 	 	= "date";
SUGAR.expressions.Expression.TIME_TYPE 	 	= "time";
SUGAR.expressions.Expression.BOOLEAN_TYPE 	= "boolean";
SUGAR.expressions.Expression.ENUM_TYPE 	 	= "enum";
SUGAR.expressions.Expression.RELATE_TYPE	= "relate";
SUGAR.expressions.Expression.GENERIC_TYPE  	= "generic";

/**
 * The two boolean values.
 */
SUGAR.expressions.Expression.TRUE  = "true";
SUGAR.expressions.Expression.FALSE = "false";

SUGAR.expressions.NumericConstants = {
	pi: 3.14159265,
	e: 2.718281828459045
}


/**
 * Initializes the Expression object.
 */
SUGAR.expressions.Expression.prototype.init = function(params) {
	// check if the parameter is an array with only one value
	if ( params instanceof Array && params.length == 1 ) {
		this.params = params[0];
	}

	// if params is an array or just a constant
	else {
		this.params = params;
	}

	// validate the parameters
	this.validateParameters();
};

/**
 * Returns the parameter list for this Expression.
 */
SUGAR.expressions.Expression.prototype.getParameters = function() {
	return this.params;
};

/**
 * Validates the parameters and throws an Exception if invalid.
 */
SUGAR.expressions.Expression.prototype.validateParameters = function() {
	var params = this.getParameters();
	var count  = this.getParamCount();
	var types  = this.getParameterTypes();

	/* parameter and type validation */

	// make sure count is a number
	if ( typeof(count) != 'number' ) {
		throw (this.getClass() + ": Number of paramters required must be a number");
	}

	// make sure types is a array or a string
	if ( typeof(types) != 'string' && ! (types instanceof Array) ) {
		throw (this.getClass() + ": Parameter types must be valid and match the parameter count");
	}

	// make sure sizeof types is equal to parameter count
	if ( types instanceof Array && count != SUGAR.expressions.Expression.INFINITY && count != types.length ) {
		throw (this.getClass() + ": Parameter types must be valid and match the parameter count");
	}

	// make sure types is valid
	if ( typeof(types) == 'string' ) {
		if ( SUGAR.expressions.Expression.TYPE_MAP[types] == null ) {
			throw (this.getClass() + ": Invalid type requirement '" + types + "'");
		}
	} else {
		for ( var i = 0; i < types.length; i++ ) {
			if ( typeof( SUGAR.expressions.Expression.TYPE_MAP[types[i]]) == 'undefined' ) {
				throw (this.getClass() + ": Invalid type requirement '" + types[i] + "'");
			}
		}
	}

	/* parameter and count validation */

	// if we want 0 params and we got 0 params, forget it
	if ( count == 0 && typeof(params) == 'undefined' )	{	return; }

	// if we want a single param, validate that param
	if ( count == 1 && this.isProperType(params, types) ) {	return; }

	// we require multiple but params only has 1
	if ( count > 1 && ! (params instanceof Array) ) {
		throw (this.getClass() + ": Requires exactly " + count + " parameter(s)");
	}

	// we require only 1 and params has multiple
	if ( count == 1 && params instanceof Array ) {
		throw (this.getClass() + ": Requires exactly 1 parameter");
	}

	// check parameter count
	if ( count != SUGAR.expressions.Expression.INFINITY && params instanceof Array && params.length != count ) {
		throw (this.getClass() + ": Requires exactly " + count + " parameter(s)");
	}

	// if a generic type is specified
	if ( typeof(types) == 'string' ) {
		// only a single parameter
		if ( ! (params instanceof Array) ) {
			if ( this.isProperType( params, types ) ) {
				return;
			}
			throw (this.getClass() + ": Parameter must be of type '" + types + "'");
		}

		// multiple parameters
		for ( var i = 0 ; i < params.length ; i ++ ) {
			if ( ! this.isProperType( params[i], types ) ) {
				throw (this.getClass() + ": All parameters must be of type '" + types + "'");
			}
		}
	}

	// if strict type constraints are specified
	else {
		// only a single parameter
		if ( ! (params instanceof Array) ) {
			if ( this.isProperType( params, types[0] ) ) {
				return;
			}
			throw (this.getClass() + ": Parameter must be of type '" + types[0] + "'");
		}

		// improper type
		for ( var i = 0 ; i < types.length ; i++ ) {
			if ( ! this.isProperType( params[i], types[i] ) ) {
				throw (this.getClass() + ": The parameter at index " + i + " must be of type " + types[i] );
			}
		}
	}
};

/**
 * Returns the exact number of parameters needed.
 */
SUGAR.expressions.Expression.prototype.getParamCount = function() {
	return SUGAR.expressions.Expression.INFINITY;
};

/**
 * Enforces the parameter types.
 */
SUGAR.expressions.Expression.prototype.isProperType = function(variable, type) {
	var see = SUGAR.expressions.Expression;
	if ( type instanceof Array ) {
		return false;
	}

	// retrieve the class
	var c = see.TYPE_MAP[type];

	// check if type is empty
	if ( typeof(c) == 'undefined' || c == null || c == '' ) {
		return false;
	}

	// check if it's an instance of type or a generic that could map to any (unknown type)
	if  (variable instanceof c || variable instanceof see.TYPE_MAP.generic || type == see.GENERIC_TYPE)
        return true;

	// now check for generics
	switch(type) {
		case see.STRING_TYPE:
			return (typeof(variable) == 'string' || typeof(variable) == 'number'
                || variable instanceof see.TYPE_MAP[see.NUMERIC_TYPE]);
			break;
		case see.NUMERIC_TYPE:
			return (typeof(variable) == 'number' || SUGAR.expressions.isNumeric(variable));
			break;
		case see.BOOLEAN_TYPE:
			if ( variable instanceof see ) {
				variable = variable.evaluate();
			}
			return ( variable == see.TRUE || variable == see.FALSE );
			break;
        case see.DATE_TYPE:
        case see.TIME_TYPE:
            if ( variable instanceof see ) {
				variable = variable.evaluate();
			}
            if (typeof(variable) == 'string' && SUGAR.util.DateUtils.guessFormat(variable))
                return true;
            break;
		case see.RELATE_TYPE:
			return true;
			break;
	}

	// If its not an instane and we can't map the value to a type, return false.
	return false;
};

/** ABSTRACT METHODS **/

/**
 * Evaluates this expression and returns the resulting value.
 */
SUGAR.expressions.Expression.prototype.evaluate = function() {
	// does nothing .. needs to be overridden
};

/**
 * Gets the name of the expression passed in.
 * @param {Object} exp
 */
SUGAR.expressions.Expression.prototype.getClass = function(exp) {
	for (var i in SUGAR.FunctionMap){
		if (typeof SUGAR.FunctionMap[i] == "function" && SUGAR.FunctionMap[i].prototype 
			&& this instanceof SUGAR.FunctionMap[i])
			return i;
	}
	return false;
};

/**
 * Returns the type each parameter should be.
 */
SUGAR.expressions.Expression.prototype.getParameterTypes = function() {
	// does nothing .. needs to be overridden
};



/** GENERIC TYPE EXPRESSIONS **/
SUGAR.expressions.GenericExpression = function(params) {

};
SUGAR.util.extend(SUGAR.expressions.GenericExpression, SUGAR.expressions.Expression, {
	/**
	 * All parameters have to be a number by default.
	 */
	getParameterTypes: function() {
		return SUGAR.expressions.Expression.GENERIC_TYPE;
	}
});


/**
 * Construct a new NumericExpression.
 */
SUGAR.expressions.NumericExpression = function(params) {
	//this.init(params);
};
SUGAR.util.extend(SUGAR.expressions.NumericExpression, SUGAR.expressions.Expression, {
	/**
	 * All parameters have to be a number by default.
	 */
	getParameterTypes: function() {
		return SUGAR.expressions.Expression.NUMERIC_TYPE;
	}
});


/**
 * Construct a new StringExpression.
 */
SUGAR.expressions.StringExpression = function(params) {
	//this.init(params);
};
SUGAR.util.extend(SUGAR.expressions.StringExpression, SUGAR.expressions.Expression, {
	/**
	 * All parameters have to be a string by default.
	 */
	getParameterTypes: function() {
		return SUGAR.expressions.Expression.STRING_TYPE;
	}
});


/**
 * Construct a new BooleanExpression.
 */
SUGAR.expressions.BooleanExpression = function(params) {
	//this.init(params);
};
SUGAR.util.extend(SUGAR.expressions.BooleanExpression, SUGAR.expressions.Expression, {
	/**
	 * All parameters have to be a sugar-boolean by default.
	 */
	getParameterTypes: function() {
		return SUGAR.expressions.Expression.BOOLEAN_TYPE;
	}
});


/**
 * Construct a new EnumExpression.
 */
SUGAR.expressions.EnumExpression = function(params) {
	//this.init(params);
};
SUGAR.util.extend(SUGAR.expressions.EnumExpression, SUGAR.expressions.Expression, {
	/**
	 * All parameters have to be an enumeration by default.
	 */
	getParameterTypes: function() {
		return SUGAR.expressions.Expression.ENUM_TYPE;
	}
});


/**
 * Construct a new DateExpression.
 */
SUGAR.expressions.DateExpression = function(params) {
	//this.init(params);
};
SUGAR.util.extend(SUGAR.expressions.DateExpression, SUGAR.expressions.Expression, {
	/**
	 * All parameters have to be date by default.
	 */
	getParameterTypes: function() {
		return SUGAR.expressions.Expression.DATE_TYPE;
	}
});


/**
 * Construct a new TimeExpression.
 */
SUGAR.expressions.TimeExpression = function(params) {
	//this.init(params);
};
SUGAR.util.extend(SUGAR.expressions.TimeExpression, SUGAR.expressions.Expression, {
	/**
	 * All parameters have to be time by default.
	 */
	getParameterTypes: function() {
		return SUGAR.expressions.Expression.TIME_TYPE;
	}
});

SUGAR.expressions.RelateExpression = function(params) {

};
SUGAR.util.extend(SUGAR.expressions.RelateExpression, SUGAR.expressions.Expression, {
	/**
	 * All parameters have to be a number by default.
	 */
	getParameterTypes: function() {
		return SUGAR.expressions.Expression.GENERIC_TYPE;
	}
});




/**
 * The type to object map for dynamic expression
 * creation and type validation.
 */
SUGAR.expressions.Expression.TYPE_MAP	= {
		"number" 	: SUGAR.expressions.NumericExpression,
		"string" 	: SUGAR.expressions.StringExpression,
		"date" 		: SUGAR.expressions.DateExpression,
		"time" 		: SUGAR.expressions.TimeExpression,
		"boolean" 	: SUGAR.expressions.BooleanExpression,
		"enum" 		: SUGAR.expressions.EnumExpression,
		"relate" 	: SUGAR.expressions.RelateExpression,
		"generic" 	: SUGAR.expressions.GenericExpression
};



/**
 * Construct a new ConstantExpression.
 */
SUGAR.expressions.ConstantExpression = function(params) {
	this.init(params);
}

SUGAR.util.extend(SUGAR.expressions.ConstantExpression, SUGAR.expressions.NumericExpression, {
	evaluate: function() {
		return this.getParameters();
	},
	getParamCount: function() {
		return 1;
	}
});

/**
 * Construct a new StringLiteralExpression.
 */
SUGAR.expressions.StringLiteralExpression = function(params) {
	this.init(params);
}
SUGAR.util.extend(SUGAR.expressions.StringLiteralExpression, SUGAR.expressions.StringExpression, {
	evaluate: function() {
		return this.getParameters();
	},
	getParamCount: function() {
		return 1;
	}
});

/**
 * Construct a new FalseExpression.
 */
SUGAR.expressions.FalseExpression = function(params) {
	this.init(params);
}
SUGAR.util.extend(SUGAR.expressions.FalseExpression, SUGAR.expressions.BooleanExpression, {
	evaluate: function() {
		return SUGAR.expressions.Expression.FALSE;
	},
	getParamCount: function() {
		return 0;
	}
});

/**
 * Construct a new TrueExpression.
 */
SUGAR.expressions.TrueExpression = function(params) {
	this.init(params);
}
SUGAR.util.extend(SUGAR.expressions.TrueExpression, SUGAR.expressions.BooleanExpression, {
	evaluate: function() {
		return SUGAR.expressions.Expression.TRUE;
	},
	getParamCount: function() {
		return 0;
	}
});

/**
 * The ExpressionParser object.
 */
SUGAR.expressions.ExpressionParser = function() {
	// nothing
};

SUGAR.expressions.ExpressionParser.getFieldsFromExpression = function(expression)
{
	var re = /[^$]*?\$(\w+)[^$]*?/g,
		matches = [],
		result;
	while (result = re.exec(expression))
	{
		matches.push(result[result.length-1]);
	}
	return matches;
}


SUGAR.expressions.ExpressionParser.prototype._generateRange = function(prefix, start, end)
{
    var str = "";
    var i = parseInt(start);
    if ( typeof(end) == 'undefined' )
        while ( this.getElement(prefix + '' + i) != null )
            str += '$' + prefix + '' + (i++) + ',';
    else
        for ( ; i <= end ; i ++ ) {
            var t = prefix + '' + i;
            if ( this.getElement(t) != null )
                str += '$' + t + ',';
        }
    return str.substring(0, str.length-1);
}

SUGAR.expressions.ExpressionParser.prototype._valueReplace = function(val) {
    if ( !(/^\$.*$/).test(val) )
    {
        return val;
    }

    return this.getValue(val.substring(1));
}

SUGAR.expressions.ExpressionParser.prototype._performRangeReplace = function(expression)
{
    var isInQuotes = false;
    var prev;
    var inRange;

    // go character by character
    for ( var i = 0 ;  ; i ++ ) {
        // due to fluctuating expression length
        if ( i == expression.length ) break;

        var ch = expression.charAt(i);

        if ( ch == '"' && prev != '\\' )	isInQuotes = !isInQuotes;

        if ( !isInQuotes && ch == '%' ) {
            inRange = true;

            // perform the replace
            var loc_start = expression.indexOf( '[' , i+1 );
            var loc_comma = expression.indexOf(',', loc_start );
            var loc_end   = expression.indexOf(']', loc_start );

            // invalid expression syntax?
            if ( loc_start < 0 || loc_end < 0 )	throw ("Invalid range syntax");

            // construct the pieces
            var prefix = expression.substring( i+1 , loc_start );
            var start, end;

            // optional param is there
            if ( loc_comma > -1 && loc_comma < loc_end ) {
                start = expression.substring( loc_start+1, loc_comma );
                end = expression.substring( loc_comma + 1, loc_end );
            } else {
                start = expression.substring( loc_start+1, loc_end );
            }

            // optional param is there
            if ( loc_comma > -1 && loc_comma < loc_end )	end = expression.substring( loc_comma + 1, loc_end );

            // construct the range
            var result = this._generateRange(prefix, this._valueReplace(start), this._valueReplace(end));
            //var result = this.generateRange(prefix, start, end);

            // now perform the replace
            if ( typeof(end) == 'undefined' )
                expression = expression.replace('%'+prefix+'['+start+']', result);
            else
                expression = expression.replace('%'+prefix+'['+start+','+end+']', result);

            // skip on
            i = i + result.length - 1;
        }

        prev = ch;
    }

    return expression;
}
SUGAR.expressions.ExpressionParser.prototype.validate = function(expr)
{
	if ( typeof(expr) != 'string' )	throw "ExpressionParser requires a string expression.";
	// check if its a constant and return a constant expression
	var fixed = this.toConstant(expr);

	if ( fixed != null && typeof(fixed) != 'undefined' )
		return true;

	// VALIDATE: expression format
	if ((/^[\w\-]+\(.*\)$/).exec(expr) == null) {
		throw ("Syntax Error (Expression Format Incorrect '" + expr + "' )");
	}

	// if no open-paren '(' found
	if ( expr.indexOf('(') < 0 )
		throw ("Syntax Error (No opening paranthesis found)");

	return true;
}

SUGAR.expressions.ExpressionParser.prototype.tokenize = function(expr)
{
	var fixed = this.toConstant(expr);
	if ( fixed != null && typeof(fixed) != 'undefined' )
	{
		return {
			type: "constant",
			returnType : this.getType(fixed),
            value : fixed.evaluate()
		}
	}

	if(/^[$]\w+$/.test(expr))
	{
		return {
			type:"variable",
			name:YAHOO.lang.trim(expr).substr(1)
		}
	}
	//Related Field
	if(/^[$]\w+\.\w+$/.test(expr))
	{
		expr = YAHOO.lang.trim(expr);
		return {
			type:"variable",
			name: expr.substr(1, expr.indexOf('.') - 1),
			relate: expr.substr(expr.indexOf('.') + 1)
		}
	}

	// EXTRACT: Function
	var open_paren_loc = expr.indexOf('(');
	if (open_paren_loc < 1)
		throw (expr + ": Syntax Error, no open parentheses found");
	if (expr.charAt(expr.length-1) != ')')
		throw (expr + ": Syntax Error, no close parentheses found");

	// get the function
	var func = expr.substring(0, open_paren_loc);

	// EXTRACT: Parameters
	var params = expr.substring(open_paren_loc + 1, expr.length-1);

	// now parse the individual parameters recursively
	var level  = 0;
	var length = params.length;
	var argument = "";
	var args = new Array();

	// flags
	var currChar		= null;
	var lastCharRead	= null;
	var justReadString	= false;		// did i just read in a string
	var justReadComma   = false;
	var isInQuotes 		= false;		// am i currently reading in a string
	var isPrevCharBK 	= false;		// is my previous character a backslash

	for ( var i = 0 ; i <= length ; i++ ) {
		// store the last character read
		lastCharRead = currChar;
		justReadComma = false;

		// the last parameter
		if ( i == length ) {
			argument = YAHOO.lang.trim(argument);
			if (argument != "")
				args[args.length] = this.tokenize(argument);
			break;
		}

		// set isprevcharbk
		isPrevCharBK = ( lastCharRead == '\\' );

		// get the charAt index i
		currChar = params.charAt(i);

		// if i am in quotes, then keep reading
		if ( isInQuotes && currChar != '"' && !isPrevCharBK ) {
			argument += currChar;
			continue;
		}

		// check for quotes
		if ( currChar == '"' && !isPrevCharBK && level == 0 )
		{
			// if i am ending a quote, then make sure nothing follows
			if ( isInQuotes ) {
				// only spaces may follow the end of a string
				var end_reg = params.indexOf(",", i);
				if ( end_reg < 0 )	end_reg = params.length-1;
				var start_reg = ( i < length - 1 ? i+1 : length - 1);

				var temp = params.substring(start_reg , end_reg );
				if ( (/^\s*$/).exec(temp) == null )
					throw (func + ": Syntax Error (Improperly Terminated String '" + temp + "')" + (start_reg) + " " + end_reg);
			}

			// negate if i am in quotes
			isInQuotes = !isInQuotes;
		}

		// check parantheses open/close
		if ( currChar == '(' ) {
			level++;
		} else if ( currChar == ')' ) {
			level--;
		}

		// argument splitting
		else if ( currChar == ',' && level == 0 ) {
			argument = YAHOO.lang.trim(argument);
			if (argument == "")
				throw ("Syntax Error: Unexpected ','");
				args[args.length] = this.tokenize(argument);
			argument = "";
			justReadComma = true;
			continue;
		}

		// construct the next argument
		argument += currChar;
	}

	// now check to make sure all the quotes opened were closed
	if ( isInQuotes )	 throw ("Syntax Error (Unterminated String Literal)");

	// now check to make sure all the parantheses opened were closed
	if ( level != 0 )	 throw ("Syntax Error (Incorrectly Matched Parantheses)");

	//If we hit a comma, but no paramter follows, we shoudl throw an error. 
	if ( justReadComma ) throw ("Syntax Error (No parameter after comma near <b>" + func + "</b>)");

	// require and return the appropriate expression object
	return {
		type: "function",
		name: $.trim(func),
		args: args
	}
}


SUGAR.expressions.ExpressionParser.prototype.getType = function(variable) {
	var see = SUGAR.expressions.Expression;

	for(var type in see.TYPE_MAP)
	{
		if (variable instanceof see.TYPE_MAP[type])
		{
			return type;
		}
	}

	return false;
};

/**
 * Evaluate a given string expression and return an Expression
 * object.
 */
SUGAR.expressions.ExpressionParser.prototype.evaluate = function(expr, context)
{
	// make sure it is only parsing strings
	if ( typeof(expr) != 'string' )	throw "ExpressionParser requires a string expression.";

	// trim spaces, left and right
	expr = expr.replace(/^\s+|\s+$|\n/g,"");

	// check if its a constant and return a constant expression
	var fixed = this.toConstant(expr);
	if ( fixed != null && typeof(fixed) != 'undefined' )
		return fixed;

	//Check if the expression is just a variable
	if (expr.match(/^\$\w+$/))
	{
		if (typeof (context) == "undefined")
			throw ("Syntax Error: variable " + expr + " without context");
		return context.getValue(expr.substring(1));
	}

	if (expr.match(/^\$\w+\.\w+$/))
	{
		return context.getRelatedValue(
				expr.substr(1, expr.indexOf('.') - 1),
				expr.substr(expr.indexOf('.') + 1)
		);
	}

	// VALIDATE: expression format
	if ((/^[\w\-]+\(.*\)$/).exec(expr) == null) {
		throw ("Syntax Error (Expression Format Incorrect '" + expr + "' )");
	}

	// EXTRACT: Function
	var open_paren_loc = expr.indexOf('(');

	// if no open-paren '(' found
	if ( open_paren_loc < 0 )
		throw ("Syntax Error (No opening paranthesis found)");

	// get the function
	var func = expr.substring(0, open_paren_loc);

	if ( SUGAR.FunctionMap[func] == null )
		throw (func + ": No such function defined");

	// EXTRACT: Parameters
	var params = expr.substring(open_paren_loc + 1, expr.length-1);

	// now parse the individual parameters recursively
	var level  = 0;
	var length = params.length;
	var argument = "";
	var args = new Array();

	// flags
	var currChar		= null;
	var lastCharRead	= null;
	var justReadString	= false;		// did i just read in a string
	var isInQuotes 		= false;		// am i currently reading in a string
	var isPrevCharBK 	= false;		// is my previous character a backslash
	var isInVar 		= false;		// am i currently reading a variable name

	if (length > 0) { for ( var i = 0 ; i <= length ; i++ ) {
		// store the last character read
		lastCharRead = currChar;

		// the last parameter
		if ( i == length ) {
			args[args.length] = this.evaluate(argument, context);
			break;
		}

		// set isprevcharbk
		isPrevCharBK = ( lastCharRead == '\\' );

		// get the charAt index i
		currChar = params.charAt(i);

		// if i am in quotes, then keep reading
		if ( isInQuotes && currChar != '"' && !isPrevCharBK ) {
			argument += currChar;
			continue;
		}

		if (isInVar && (currChar == " " || currChar == "," ))
			isInVar = false;
		
		// check for quotes
		if ( currChar == '"' && !isPrevCharBK && level == 0 )
		{
			// if i am ending a quote, then make sure nothing follows
			if ( isInQuotes ) {
				// only spaces may follow the end of a string
				var end_reg = params.indexOf(",", i);
				if ( end_reg < 0 )	end_reg = params.length-1;
				var start_reg = ( i < length - 1 ? i+1 : length - 1);

				var temp = params.substring(start_reg , end_reg );
				if ( (/^\s*$/).exec(temp) == null )
					throw (func + ": Syntax Error (Improperly Terminated String '" + temp + "')" + (start_reg) + " " + end_reg);
			}

			// negate if i am in quotes
			isInQuotes = !isInQuotes;
		}

		if( currChar == '$' && !isPrevCharBK && !isInQuotes && level == 0)
		{
			if (isInVar)
				throw (func + ": Syntax Error (unexpeted '$' in  '" + argument + "')");
			else {
				isInVar = true;
			}
		}

		// check parantheses open/close
		if ( currChar == '(' ) {
			level++;
		} else if ( currChar == ')' ) {
			level--;
		}

		// argument splitting
		else if ( currChar == ',' && level == 0 ) {
			args[args.length] = this.evaluate(argument, context);
			argument = "";
			continue;
		}

		// construct the next argument
		argument += currChar;
	}}

	// now check to make sure all the quotes opened were closed
	if ( isInQuotes )	throw ("Syntax Error (Unterminated String Literal)");

	// now check to make sure all the parantheses opened were closed
	if ( level != 0 )	throw ("Syntax Error (Incorrectly Matched Parantheses)");

	// require and return the appropriate expression object
	return new SUGAR.FunctionMap[func](args, context);
}



/**
 * Takes in a string and returns a ConstantExpression if the
 * string can be converted to a constant.
 */
SUGAR.expressions.ExpressionParser.prototype.toConstant = function(expr) {

	// a raw numeric constant
	if ( (/^(\-)?[0-9]+(\.[0-9]+)?$/).exec(expr) != null ) {
		return new SUGAR.expressions.ConstantExpression( parseFloat(expr) );
	}

	// a pre defined numeric constant
	var fixed = SUGAR.expressions.NumericConstants[expr];
	if ( fixed != null && typeof(fixed) != 'undefined' )
		return new SUGAR.expressions.ConstantExpression( parseFloat(fixed) );

	// a constant string literal
	if ( (/^".*"$/).exec(expr) != null ) {
		expr = expr.substring(1, expr.length-1);		// remove start/end quotes
		return new SUGAR.expressions.StringLiteralExpression( expr );
	}

    // empty string
    if (expr == '')
    {
        return new SUGAR.expressions.StringLiteralExpression( expr );
    }

	// a boolean
	if ( expr == "true" ) {
		return new SUGAR.expressions.TrueExpression();
	} else if ( expr == "false" ) {
		return new SUGAR.expressions.FalseExpression();
	}

	// a date
	if ( (/^(0[0-9]|1[0-2])\/([0-2][0-9]|3[0-1])\/[0-3][0-9]{3,3}$/).exec(expr) != null ) {
		var day   = parseFloat(expr.substring(0, 2));
		var month = parseFloat(expr.substring(3, 2));
		var year  = parseFloat(expr.substring(6, 4));
		return new SUGAR.DateExpression([day, month, year]);
	}

	// a time
	if ( (/^([0-1][0-9]|2[0-4]):[0-5][0-9]:[0-5][0-9]$/).exec(expr) != null ) {
		var hour   = parseFloat(expr.substring(0, 2));
		var minute = parseFloat(expr.substring(3, 2));
		var second = parseFloat(expr.substring(6, 2));
		return new SUGAR.TimeExpression([hour, minute, second]);
	}

	// neither
	return null;
};

SUGAR.expressions.ExpressionParser.prototype.getRelatedFieldsFromFormula = function(expr) {
    var fields = [],
        relateFunctions = ["related", "count", "rollupSum", "rollupMax", 'rollupMin', "rollupAve"];
    var recurseTokens = function(t){
        //First check if its a simple related field
        if (t.type == "variable" && t.relate){
            fields.push({
                type:"related",
                link:t.name,
                relate:t.relate
            });
        } else if (t.type == "function" && relateFunctions.indexOf(t.name) != -1)
        {
            switch(t.name){
                case "related":
                    // For now, do not attempt to prefetch relate fields that use a formula to determine what related field to pull from
                    if (t.args[1].type == "constant")
                        fields.push({
                            type:"related",
                            link:t.args[0].name,
                            relate:t.args[1].value
                        });
                    break;
                case "count":
                    //count has no field parameter, only a link
                    fields.push({
                        type:"count",
                        link:t.args[0].name
                    });
                    break;
                default:
                    //Default will be a rollup, again, no nested formulas allowed
                    if (t.args[1].type == "constant")
                    {
                        fields.push({
                            type:t.name,
                            link:t.args[0].name,
                            relate:t.args[1].value
                        });
                    }
            }
        } else if (t.type == "function") {
            for(var i = 0; i < t.args.length; i++){
                recurseTokens(t.args[i]);
            }
        }
    }
    try {
        var t = this.tokenize(expr);
        recurseTokens(t);
    }
    catch(e){}

    return fields;
}

/**
 * An expression context is used to retrieve variables when evaluating expressions.
 * the default class only returns the empty string.
 */
SUGAR.expressions.ExpressionContext = function()
{
	//No opp, this is just an API
}

SUGAR.expressions.ExpressionContext.prototype.getValue = function(varname)
{
	return "";
}

SUGAR.expressions.ExpressionContext.prototype.setValue = function(varname, value)
{
	return "";
}

SUGAR.expressions.ExpressionContext.prototype.addListener = function(varname, callback, scope)
{
	return "";
}


SUGAR.expressions.ExpressionContext.prototype.getRelatedValue = function(linkField, relField)
{
	return new SUGAR.RelatedFieldExpression([
		new SUGAR.expressions.StringLiteralExpression( linkField ),
		new SUGAR.expressions.StringLiteralExpression( relField )
	]);
}

SUGAR.expressions.isNumeric = function(str) {
    if(typeof(str) != 'number' && typeof(str) != 'string')
        return false;
    var SE = SUGAR.expressions;
    var numRegex = new RegExp("^(\\-)?[0-9\\,]+(\\.[0-9]+)?$");
    str = SE.unFormatNumber(str);
    return numRegex.exec(str) != null;

};

SUGAR.expressions.unFormatNumber = function(num) {
    if(typeof num == 'string')
    {
    var SE = SUGAR.expressions;
    var ts = "," , ds= ".";
    if (SE.userPrefs) {
        ts = SE.userPrefs.num_grp_sep;
        ds = SE.userPrefs.dec_sep;
    };
    num = SE.replaceAll(num, ts, "");
    num = SE.replaceAll(num, ds, ".");
    }
    return num;
};

SUGAR.expressions.replaceAll = function(haystack, needle, rpl) {
    if (needle == rpl || haystack == "" || needle == "") return haystack;
    var str = haystack;
    while ( str.indexOf(needle) > -1 ) {
        str = str.replace(needle, rpl);
    }
    return str;
};

/**
 * 
 */
 
SUGAR.util.DateUtils = {
	/**
 	 * Converts a date string to a new format.
 	 * If no new format is passed in, the date is returned as a Unix timestamp.
 	 * If no old format is passed in, the old format is guessed.
 	 * @param {String} date String representing a date.
 	 * @param {String} oldFormat Optional: Current format of the date string.
 	 */
	parse : function(date, oldFormat) {
        if (date instanceof Date)
            return date;
        if (oldFormat == "user")
		{
			if (SUGAR.expressions.userPrefs && SUGAR.expressions.userPrefs.datef) {
				oldFormat = SUGAR.expressions.userPrefs.datef + " " + SUGAR.expressions.userPrefs.timef;
			} else {
				oldFormat = SUGAR.util.DateUtils.guessFormat(date);
			}
		}
		if (oldFormat == null || oldFormat == "") {
			oldFormat = SUGAR.util.DateUtils.guessFormat(date);
		}
		if (oldFormat == false) {
			//Check if date is a timestamp
			if (/^\d+$/.test(date))
				return new Date(date);
			//Otherwise give up
			return false;
		}
		var jsDate = new Date("Jan 1, 1970 00:00:00");
		var part = "";
		var dateRemain = YAHOO.lang.trim(date);
		oldFormat = YAHOO.lang.trim(oldFormat) + " "; // Trailing space to read as last separator.
		for (var j = 0; j < oldFormat.length; j++) {
			var c = oldFormat.charAt(j);
			if (c == ':' || c == '/' || c == '-' || c == '.' || c == " " || c == 'a' || c == "A") {
				var i = dateRemain.indexOf(c);
				if (i == -1) i = dateRemain.length;
				var v = dateRemain.substring(0, i);
				dateRemain = dateRemain.substring(i+1);
				switch (part) {
					case 'm':
						if (!(v > 0 && v < 13)) return false;
						jsDate.setMonth(v - 1); break;
					case 'd':
						if(!(v > 0 && v < 32)) return false;
						jsDate.setDate(v); break;
					case 'Y':
						if(!(v > 0)) return false;
						jsDate.setYear(v); break;
					case 'h':
						//Read time, assume minutes are at end of date string (we do not accept seconds)
						var timeformat = oldFormat.substring(oldFormat.length - 4);
						if (timeformat.toLowerCase() == "i a " || timeformat.toLowerCase() == c + "ia ") {
							if (dateRemain.substring(dateRemain.length - 2).toLowerCase() == 'pm') {
								v = v * 1;
								if (v < 12) {
									v += 12;
								}
							}
						}
					case 'H':
						jsDate.setHours(v);
						break;
					case 'i':
						v = v.substring(0, 2);
						jsDate.setMinutes(v); break;
				}
				part = "";
			} else {
				part = c;
			}
		}
		return jsDate;
	},
	guessFormat: function(date) {
		if (typeof date != "string")
			return false;
		//Is there a time
		var time = "";
		if (date.indexOf(" ") != -1) {
			time = date.substring(date.indexOf(" ") + 1, date.length);
			date = date.substring(0, date.indexOf(" "));
		}

		//First detect if the date contains "-" or "/"
		var dateSep = "/";
		if (date.indexOf("/") != -1){}
		else if (date.indexOf("-") != -1)
		{
			dateSep = "-";
		} 
		else if (date.indexOf(".") != -1)
		{
			dateSep = ".";
		}
		else 
		{
		 	return false;
		}
		var dateParts = date.split(dateSep);
		var dateFormat = "";
		var jsDate = new Date("Jan 1, 1970 00:00:00");
		if (dateParts[0].length == 4)
		{
			dateFormat = "Y" + dateSep + "m" + dateSep + "d";
		}
		else if (dateParts[2].length == 4)
		{
			dateFormat = "m" + dateSep + "d" + dateSep + "Y";
		}
		else 
		{
			return false;
		}

		//Detect the Time format
		if (time != "")
		{
			var timeFormat = "";
			var timeSep = ":";
			if (time.indexOf(".") == 2) {
				timeSep = ".";
			}
			if (time.indexOf(" ") != -1) {
				var timeParts = time.split(" ");
				if (timeParts[1] == "am" || timeParts[1] == "pm") {
					return dateFormat + " h" + timeSep + "i a";
				} else if (timeParts[1] == "AM" || timeParts[1] == "PM") {
					return dateFormat + " h" + timeSep + "i A";
				}	
			}
			else 
			{
				var timeEnd = time.substring(time.length - 2, time.length);
				if (timeEnd == "AM" || timeEnd == "PM") {
					return dateFormat + " h" + timeSep + "iA";
				}
				if (timeEnd == "am" || timeEnd == "pm") {
					return dateFormat + " h" + timeSep + "iA";
				}

				return dateFormat + " H" + timeSep + "i";
			}
		}

		return dateFormat;
	},

    formatDate : function(date, useTime, format)
    {
        if (!format && SUGAR.expressions.userPrefs.datef && SUGAR.expressions.userPrefs.timef) {
            if (useTime)
				format = SUGAR.expressions.userPrefs.datef + " " + SUGAR.expressions.userPrefs.timef;
			else
				format = SUGAR.expressions.userPrefs.datef;
        }
        var out = "";
        for (var i=0; i < format.length; i++) {
			var c = format.charAt(i);
			switch (c) {
                case 'm':
                    var m= date.getMonth() + 1; 
                    out += m < 10 ? "0" + m : m;
                    break;
                case 'd':
                    var d = date.getDate();
                    out += d < 10 ? "0" + d : d;
                    break;
                case 'Y':
                    out += date.getFullYear(); break;
				case 'H':
                case 'h':
					var h = date.getHours();
                    if(c == "h") h = h > 12 ? h - 12 : h;
                    out += h < 10 ? "0" + h : h; break;
                case 'i':
                    var m = date.getMinutes();
                    out += m < 10 ? "0" + m : m; break;
                case 'a':
                    if (date.getHours() < 12)
                        out += "am";
                    else
                        out += "pm";
                    break;
                case 'A':
                    if (date.getHours() < 12)
                        out += "AM";
                    else
                        out += "PM";
                    break;
                default :
                    out += c;
            }
		}
        return out;
    },
	roundTime: function(date)
	{
		var min = date.getMinutes();

		if (min < 1) { min = 0; }
		else if (min < 16) { min = 15; }
		else if (min < 31) { min = 30; }
		else if (min < 46) { min = 45; }
		else { min = 0; date.setHours(date.getHours() + 1)}

		date.setMinutes(min);

		return date;
	},
	getUserTime: function()
	{
		var date = new Date();
		if (typeof(SUGAR.expressions.userPrefs.gmt_offset) != "undefined")
		{
			//Sugars TZ offset is negative compared with JS's offset, so adding is really subtracting;
			var offset = SUGAR.expressions.userPrefs.gmt_offset;
			date.setMinutes(date.getMinutes() + (date.getTimezoneOffset() + offset));
		}
		return date;
	}
 };
