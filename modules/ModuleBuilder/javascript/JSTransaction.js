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



   
function JSTransaction(){
    this.JSTransactions = new Array();
    this.JSTransactionIndex = 0;
    this.JSTransactionCanRedo = false;
    this.JSTransactionTypes = new Array(); 
    

}

    JSTransaction.prototype.record = function(transaction, data){
        this.JSTransactions[this.JSTransactionIndex] = {'transaction':transaction , 'data':data};
        this.JSTransactionIndex++;
        this.JSTransactionCanRedo = false
    }
    JSTransaction.prototype.register = function(transaction, undo, redo){
        this.JSTransactionTypes[transaction] = {'undo': undo, 'redo':redo};
    }
    JSTransaction.prototype.undo = function(){
        if(this.JSTransactionIndex > 0){
            if(this.JSTransactionIndex > this.JSTransactions.length ){
                this.JSTransactionIndex  = this.JSTransactions.length;
            }
            var transaction = this.JSTransactions[this.JSTransactionIndex - 1];
            var undoFunction = this.JSTransactionTypes[transaction['transaction']]['undo'];
            undoFunction(transaction['data']);
            this.JSTransactionIndex--;
            this.JSTransactionCanRedo = true;
        }
    }
    JSTransaction.prototype.redo = function(){
        if(this.JSTransactionCanRedo && this.JSTransactions.length < 0)this.JSTransactionIndex = 0;
        if(this.JSTransactionCanRedo && this.JSTransactionIndex <= this.JSTransactions.length ){
            this.JSTransactionIndex++;
            var transaction = this.JSTransactions[this.JSTransactionIndex - 1];
            var redoFunction = this.JSTransactionTypes[transaction['transaction']]['redo'];
            redoFunction(transaction['data']);
        }
    }



