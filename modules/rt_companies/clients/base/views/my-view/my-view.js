({
    className: 'my-view tcenter',
    events: {
        'change .companies': 'handelChange'
    },

    handelChange: function(e) {
		var root_path = 'custom/themes/default/images/';
        if(e.currentTarget.value =='ibm'){
			document.getElementById('img_show').setAttribute('src', root_path+'wheel.PNG');
		}else{
			document.getElementById('img_show').setAttribute('src', root_path+'ludo.PNG');
		}
    }
})