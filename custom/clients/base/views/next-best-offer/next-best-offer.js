({
    extendsFrom: 'DashablelistView',
	plugins: ['LinkedModel','Dashlet'],
	
	/**
	* initializing 'next-best-offer' Dashlet for Contact 
	* @param {Object} view
	* @param {Function} initDashlet
	*/
    initialize: function (options) {
		console.log(this);
        this._super('initialize', [options]);
    },
	initDashlet: function (view) {
		if(view == 'main'){
			this.context.set('link', 'next_best_offer');
			this.collection.link.name = 'next_best_offer';			
		}
		app.view.invokeParent(this, {
            type: 'view',
            name: 'dashablelist',
            method: 'initDashlet',
            args: [view]
        });
    },
})